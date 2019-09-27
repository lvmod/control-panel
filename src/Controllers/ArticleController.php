<?php

namespace Lvmod\ControlPanel\Controllers;

use Lvmod\ControlPanel\Models\Article;
use Lvmod\ControlPanel\Repositories\ArticleRepository;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Symfony\Component\DomCrawler\Crawler;
use Illuminate\Support\Facades\Storage;

class ArticleController extends Controller
{

    protected $disk = "media";
    protected $materialsPath = "materials";

    /**
     * Экземпляр ArticleRepository.
     *
     * @var ArticleRepository
     */
    protected $article;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(ArticleRepository $article)
    {
        $this->article = $article;
    }

    public function index(Request $request)
    {
        return view('control::article.index', [
            'article' => $this->article->findPaginate(),
        ]);
    }

    public function view(Request $request, Article $article)
    {
        return view('control::article.view', [
            'article' => $article,
        ]);
    }

    public function create(Request $request)
    {
        return view('control::article.create');
    }

    public function edit(Request $request, Article $article)
    {
        return view('control::article.edit', [
            'type' => 'article',
            'id' => $article->id,
            'article' => $article
        ]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'posted' => 'required',
            'title' => 'required|max:255',
        ]);

        $article = new Article;
        $article->title = $request->title;
        $article->posted = \Carbon\Carbon::parse($request->posted)->toDateString();
        $article->visible = !!$request->visible;
        $article->body = ""; //$request->body;
        $article->author_id = $request->user()->id;
        $article->multimedia_id = $request->multimedia ? $request->multimedia : null;
        $article->save();

        return redirect('/control/article/edit/' . $article->id);
    }

    public function update(Request $request, Article $article)
    {
        $this->validate($request, [
            'posted' => 'required',
            'title' => 'required|max:255',
            'body' => 'required',
        ]);

        //Удаление неиспользуемого материала
        try {
            $crawler = new Crawler($request->body);
            $src = ($crawler->filter('img[src]')->each(function ($node) {
                $path = $node->attr('src');
                if ($path) {
                    return basename($path);
                }
                return;
            }));
            $indoc = [];
            foreach ($src as $value) {
                if ($value) {
                    $indoc[basename($value)] =  $value;
                }
            }
            $files = Storage::disk($this->disk)->files($this->materialsPath . '/' . 'article' . '/' . $article->id);
            foreach ($files as $file) {
                if (!array_key_exists(basename($file), $indoc)) {
                    Storage::disk($this->disk)->delete($file);
                }
            }
        } catch (\Exception $ex) {
            //throw $th;
        }

        $article->title = $request->title;
        $article->posted = \Carbon\Carbon::parse($request->posted)->toDateString();
        $article->visible = !!$request->visible;
        $article->body = $request->body;
        $article->author_id = $request->user()->id;
        $article->multimedia_id = $request->multimedia ? $request->multimedia : null;
        $article->save();

        return redirect('/control/article');
    }

    public function delete(Request $request, Article $article)
    {
        $article->delete();
        return redirect('/control/article');
    }
}

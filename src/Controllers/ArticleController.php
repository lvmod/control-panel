<?php

namespace Lvmod\ControlPanel\Controllers;

use Lvmod\ControlPanel\Models\Article;
use Lvmod\ControlPanel\Repositories\ArticleRepository;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
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

        $article->title = $request->title;
        $article->posted = \Carbon\Carbon::parse($request->posted)->toDateString();
        $article->visible = !!$request->visible;
        $article->body = $request->body;
        $article->author_id = $request->user()->id;
        $article->multimedia_id = $request->multimedia ? $request->multimedia : null;
        $article->save();

        //Удаление неиспользуемого материала
        app()->Utils->deleteNotUseMaterials('article', $article->id, $request->body);

        return redirect('/control/article');
    }

    public function delete(Request $request, Article $article)
    {
        $article->delete();

        //Удаление папки материала
        app()->Utils->deleteMaterialsFolder('article', $article->id);

        return redirect('/control/article');
    }
}

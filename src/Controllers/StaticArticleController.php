<?php

namespace Lvmod\ControlPanel\Controllers;

use Lvmod\ControlPanel\Models\StaticArticle;
use Lvmod\ControlPanel\Repositories\StaticArticleRepository;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class StaticArticleController extends Controller
{

    /**
     * Экземпляр StaticArticleRepository.
     *
     * @var StaticArticleRepository
     */
    protected $staticArticle;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(StaticArticleRepository $staticArticle)
    {
        $this->staticArticle = $staticArticle;
    }

    public function index(Request $request)
    {
        return view('control::static-article.index', [
            'staticArticle' => $this->staticArticle->findPaginate(),
        ]);
    }

    public function getFillBaseImage(Request $request)
    {
        return $this->staticArticle->findFillBaseImagePaginate();
    }

    public function view(Request $request, StaticArticle $staticArticle)
    {
        return view('control::static-article.view', [
            'staticArticle' => $staticArticle,
        ]);
    }

    public function create(Request $request)
    {
        return view('control::static-article.create');
    }

    public function edit(Request $request, StaticArticle $staticArticle)
    {
        return view('control::static-article.edit', [
            'type' => 'static-article',
            'pathReadonly' => false,
            'id' => $staticArticle->id,
            'staticArticle' => $staticArticle
        ]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'path' => [
                'required', function ($attribute, $value, $fail) {
                    $art = $this->staticArticle->byPath($value);
                    //Если есть статья с таким же path и она не удалена, то ошибка
                    if ($art && !$art->deleted_at) {
                        $fail('Такое значение поля ' . $attribute . ' уже существует.');
                    }
                },
            ],
            'title' => 'required|max:255',
        ]);

        $staticArticle = new StaticArticle;
        $staticArticle->path = strtolower($request->path);
        $staticArticle->title = $request->title;
        $staticArticle->body = ""; //$request->body;
        $staticArticle->author_id = $request->user()->id;
        $staticArticle->save();

        return redirect('/control/static/article/edit/' . $staticArticle->id);
    }

    public function update(Request $request, StaticArticle $staticArticle)
    {
        $this->validate($request, [
            'path' => [
                'required', function ($attribute, $value, $fail) use ($staticArticle) {
                    $art = $this->staticArticle->byPath($value);
                    if ($art && $art->id != $staticArticle->id) {
                        $fail('Такое значение поля ' . $attribute . ' уже существует.');
                    }
                },
            ],
            'title' => 'required|max:255',
            'body' => 'required',
        ]);

        $staticArticle->path = strtolower($request->path);
        $staticArticle->title = $request->title;
        $staticArticle->body = $request->body;
        $staticArticle->author_id = $request->user()->id;
        $staticArticle->multimedia_id = $request->multimedia ? $request->multimedia : null;
        $staticArticle->image = $request->image;
        $staticArticle->save();

        //Удаление неиспользуемого материала
        app()->Utils->deleteNotUseMaterials('static-article', $staticArticle->id, $request->body, [$request->image]);

        if($request->pathedit) {
            return redirect('/control/static/article/path/edit/' . $staticArticle->path);
        }
        return redirect('/control/static/article');
    }

    public function pathEdit(Request $request, $path)
    {
        if (!$path) {
            abort(404);
        }

        $staticArticle = $this->staticArticle->byPath($path);
        if (!$staticArticle) {
            $staticArticle = new StaticArticle;
            $staticArticle->path = strtolower($path);
            $staticArticle->title = "";
            $staticArticle->body = ""; //$request->body;
            $staticArticle->author_id = $request->user()->id;
            $staticArticle->save();
        }

        return view('control::static-article.edit', [
            'type' => 'static-article',
            'pathReadonly' => true,
            'id' => $staticArticle->id,
            'staticArticle' => $staticArticle
        ]);
    }

    public function delete(Request $request, StaticArticle $staticArticle)
    {
        $staticArticle->delete();

        //Удаление папки материала
        app()->Utils->deleteMaterialsFolder('static-article', $staticArticle->id);

        return redirect('/control/static/article');
    }
}

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
        return view('control::static-article.edit', ['staticArticle' => $staticArticle]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'path' => 'required|unique:static_article',
            'title' => 'required|max:255',
            'body' => 'required',
        ]);

        $staticArticle = new StaticArticle;
        $staticArticle->path = strtolower($request->path);
        $staticArticle->title = $request->title;
        $staticArticle->body = $request->body;
        $staticArticle->author_id = $request->user()->id;
        $staticArticle->multimedia_id = $request->multimedia;
        $staticArticle->save();

        return redirect('/control/static/article');
    }

    public function update(Request $request, StaticArticle $staticArticle)
    {
        $this->validate($request, [
            'path' => 'required|unique:static_article',
            'title' => 'required|max:255',
            'body' => 'required',
        ]);

        $staticArticle->path = strtolower($request->path);
        $staticArticle->title = $request->title;
        $staticArticle->body = $request->body;
        $staticArticle->author_id = $request->user()->id;
        $staticArticle->multimedia_id = $request->multimedia;
        $staticArticle->save();

        return redirect('/control/static/article');
    }

    public function delete(Request $request, StaticArticle $staticArticle)
    {
        $staticArticle->delete();
        return redirect('/control/static/article');
    }
}

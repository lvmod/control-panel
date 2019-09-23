<?php

namespace Lvmod\ControlPanel\Controllers;

use Lvmod\ControlPanel\Models\News;
use Lvmod\ControlPanel\Repositories\NewsRepository;
use Lvmod\ControlPanel\Repositories\CategoryRepository;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class NewsController extends Controller
{

    /**
     * Экземпляр NewsRepository.
     *
     * @var NewsRepository
     */
    protected $news;
    protected $category;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(NewsRepository $news, CategoryRepository $category)
    {
        //        $this->middleware('auth');
        $this->news = $news;
        $this->category = $category;
    }

    public function index(Request $request)
    {
        // var_dump(json_encode(app()->controlMenu->breadcrumb()));
        // die();
        return view('control::news.index', [
            'news' => $this->news->findPaginate(),
        ]);
    }

    public function view(Request $request, News $news)
    {
        // var_dump(json_encode(app()->controlMenu->breadcrumb()));
        // die();
        return view('control::news.view', [
            'news' => $news,
        ]);
    }

    public function create(Request $request)
    {
        return view('control::news.create', ['category' => $this->category->find()]);
    }

    public function edit(Request $request, News $news)
    {
        return view('control::news.edit', ['news' => $news, 'category' => $this->category->find()]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'posted' => 'required',
            'category' => 'required',
            'title' => 'required|max:255',
            // 'body' => 'required',
        ]);

        $news = new News;
        $news->title = $request->title;
        $news->posted = \Carbon\Carbon::parse($request->posted)->toDateString();
        $news->visible = !!$request->visible;
        $news->inline = !!$request->inline;
        $news->body = ""; //$request->body;
        $news->author_id = $request->user()->id;
        $news->category_id = $request->category;
        $news->multimedia_id = $request->multimedia;
        $news->save();

        return redirect('/control/news/edit/'.$news->id);
    }

    public function update(Request $request, News $news)
    {
        $this->validate($request, [
            'posted' => 'required',
            'category' => 'required',
            'title' => 'required|max:255',
            'body' => 'required',
        ]);

        $news->title = $request->title;
        $news->posted = \Carbon\Carbon::parse($request->posted)->toDateString();
        $news->visible = !!$request->visible;
        $news->inline = !!$request->inline;
        $news->body = $request->body;
        $news->author_id = $request->user()->id;
        $news->category_id = $request->category;
        $news->multimedia_id = $request->multimedia;
        $news->save();

        return redirect('/control/news');
    }

    public function delete(Request $request, News $news)
    {
        $news->delete();
        return redirect('/control/news');
    }
}

<?php

namespace Lvmod\ControlPanel\Controllers;

use Lvmod\ControlPanel\Models\News;
use Lvmod\ControlPanel\Repositories\NewsRepository;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class NewsController extends Controller {

    /**
     * Экземпляр NewsRepository.
     *
     * @var NewsRepository
     */
    protected $news;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(NewsRepository $news) {
//        $this->middleware('auth');
        $this->news = $news;
    }

    public function index(Request $request) {
        return view('control::news.index', [
            'news' => $this->news->find(),
        ]);
    }

    public function create(Request $request) {
        return view('control::news.create');
    }

    public function store(Request $request) {
        $this->validate($request, [
            'title' => 'required|max:255',
//            'body' => 'required',
        ]);

        $news = new News;
        $news->title = $request->title;
        $news->body = "sdf";
        $news->author = 1;
        $news->category = 1;
        $news->save();

        return redirect('/control/news');
    }

    public function delete(Request $request, News $news) {
        $news->delete();
        return redirect('/control/news');
    }

}

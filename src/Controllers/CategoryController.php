<?php

namespace Lvmod\ControlPanel\Controllers;

use Lvmod\ControlPanel\Models\Category;
use Lvmod\ControlPanel\Repositories\CategoryRepository;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CategoryController extends Controller
{

    /**
     * Экземпляр CategoryRepository.
     *
     * @var CategoryRepository
     */
    protected $category;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(CategoryRepository $category)
    {
        $this->category = $category;
    }

    public function index(Request $request)
    {
        return view('control::category.index', [
            'category' => $this->category->findPaginate(),
        ]);
    }

    public function view(Request $request, Category $category)
    {
        return view('control::category.view', [
            'category' => $category,
        ]);
    }

    public function create(Request $request)
    {
        return view('control::category.create');
    }

    public function edit(Request $request, Category $category)
    {
        return view('control::category.edit', [
            'id' => $category->id,
            'category' => $category]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
        ]);

        $category = new Category;
        $category->name = $request->name;
        $category->save();

        return redirect('/control/category');
    }

    public function update(Request $request, Category $category)
    {
        $this->validate($request, [
            'name' => 'required',
        ]);

        $category->name = $request->name;
        $category->save();

        return redirect('/control/category');
    }

    public function delete(Request $request, Category $category)
    {
        $category->delete();

        return redirect('/control/category');
    }
}

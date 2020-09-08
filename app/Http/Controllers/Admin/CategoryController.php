<?php

namespace App\Http\Controllers\Admin;

use App\Facades\FileFacade;
use App\Http\Requests\Admin\Category\AddCategoryRequest;
use App\Http\Requests\Admin\Category\UpdateCategoryRequest;
use App\Http\Requests\ExecuteOptionRequest;
use App\Http\Resources\Category\CategoryDTFResource;
use App\Models\Category;
use App\Traits\Cache\CategoryCacheTrait;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

// Requests

// models

class CategoryController extends HomeController
{
    use CategoryCacheTrait;

    public function __construct()
    {
        parent::__construct();

        self::$data['main_title'] = trans('admin.categories');
        self::$data['breadcrumbs'] = [
            ['name' => trans('admin.home'), 'url' => url('admin')],
            ['name' => trans('admin.categories'), 'url' => route('admin.categories.index')],
        ];
        self::$data['active_menu'] = 'categories';
        self::$data['sub_menu'] = '';

    }

    public function index()
    {
//        $a = CategoryDTFResource::collection(Category::all());
//        $b= collect(json_decode($a->toJson(),false ));

        parent::$data['categories'] = $this->getCategoryAsSpecificArrange();
        parent::$data['options'] = $this->getOptionsWithDelete();
        return view('admin.categories.index', parent::$data);
    }


    public function create()
    {

    }

    public function store(AddCategoryRequest $request)
    {

        $data = $request->validated();
        $data['image_id'] = FileFacade::storeImageId($request->image, null, null, true);
        $data['parent_id'] = $request->parent_id != -1 ? $request->parent_id : null;
        $category = Category::create($data);
        return responseJson(true, trans('admin.add_success'), [
            'categories' => $this->getCategoryAsSpecificArrange(-1)
        ], 200);
    }

    public function show($id)
    {

    }

    public function edit($id)
    {

    }

    public function update(UpdateCategoryRequest $request, Category $category)
    {
        $data = $request->validated();
        $data['image_id'] = FileFacade::storeImageId($request->image, $category, 'image_id', false);
        $data['parent_id'] = $request->parent_id != -1 ? $request->parent_id : null;
        $category->update($data);
        return responseJson(true, trans('admin.update_success'), [
            'categories' => $this->getCategoryAsSpecificArrange(-1)
        ], 200);
    }

    public function destroy($id)
    {
        try {
            Category::destroy($id);
            return responseJson(true, trans('admin.done_delete'), [], 200);

        } catch (\Exception $e) {
            return responseJson(false, $e->getMessage(), [], 200);

        } catch (\Error $e) {
            return responseJson(false, $e->getMessage(), [], 200);

        }

    }

    // execute options
    public function executeOptions(ExecuteOptionRequest $request)
    {
        $ids = $request->ids;
        $option_id = $request->option_id;
        switch ($option_id) {
            case 1 :
                Category::whereIn('id', $ids)->update(['status' => 1]);
                break;
            case 2 :
                Category::whereIn('id', $ids)->update(['status' => 0]);
                break;
            case 3 :
                Category::destroy($ids);
                break;
        }
        return responseJson(true, trans('admin.update_success'), [], 200);

    }

    // remote data
    public function get_remote_category(Request $request)
    {
        $categories = Category::with('parent')
            ->withCount('children')
            ->CategoryParent($request->category_id);

        return DataTables::of($categories)
            ->addColumn('link_name', function ($model) {
                return view('admin.categories.parts.link_name',
                    ['name' => $model->name, 'children_count' => $model->children_count])
                    ->render();
            })->addColumn('select_record', function ($model) {
                return view('admin.categories.parts.select_record', ['id' => $model->id])->render();
            })->addColumn('show_image', function ($model) {
                return view('admin.categories.parts.show_image', ['image' => $model->image])->render();
            })->addColumn('show_status', function ($model) {
                return view('admin.categories.parts.status', ['id' => $model->id, 'status' => $model->status])->render();
            })->addColumn('actions', function ($model) {
                return view('admin.categories.parts.actions', ['id' => $model->id])->render();
            })->escapeColumns(['*'])->make(true);
    }


}

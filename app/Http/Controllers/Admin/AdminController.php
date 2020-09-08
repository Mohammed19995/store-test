<?php

namespace App\Http\Controllers\Admin;

use App\Facades\FileFacade;
// Requests
use App\Http\Requests\Admin\Admin\AddAdminRequest;
use App\Http\Requests\Admin\Admin\UpdateAdminRequest;
use App\Http\Requests\ExecuteOptionRequest;

// models
use App\Models\Admin;
use App\Models\Country;
use App\User;

use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class AdminController extends HomeController
{

    public function __construct()
    {
        parent::__construct();

        self::$data['main_title'] = trans('admin.admins');
        self::$data['breadcrumbs'] = [
            ['name' => trans('admin.home'), 'url' => url('admin')],
            ['name' => trans('admin.admins'), 'url' => route('admin.admins.index')],
        ];
        self::$data['active_menu'] = 'admins';
        self::$data['sub_menu'] = '';

    }

    public function index()
    {
        parent::$data['countries'] = Country::Active()->get();
        parent::$data['options'] = $this->getOptionsWithDelete();
        return view('admin.admins.index', parent::$data);
    }


    public function create()
    {

    }

    public function store(AddAdminRequest $request)
    {
        $data = $request->validated();
        $data['image_id'] = FileFacade::storeImageId($request->image, null, null, true);
        Admin::create($data);
        return responseJson(true, trans('admin.add_success'), [], 200);
    }

    public function show($id)
    {

    }

    public function edit($id)
    {

    }

    public function update(UpdateAdminRequest $request, Admin $admin)
    {
        $data = $request->validated();
        $data['image_id'] = FileFacade::storeImageId($request->image,$admin, 'image_id' , false);
        $admin->update($data);
        return responseJson(true, trans('admin.update_success'), [], 200);
    }

    public function destroy($id)
    {
        $admin = Admin::find($id);
        try {
            $admin->delete();
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
               Admin::whereIn('id', $ids)->update(['status' => 1]);
                break;
            case 2 :
                Admin::whereIn('id', $ids)->update(['status' => 0]);
                break;
            case 3 :
                Admin::destroy($ids);
                break;
        }
        return responseJson(true, trans('admin.update_success'), [], 200);

    }

    // remote data
    public function get_remote_admins (Request $request)
    {
        $admins = Admin::query();

        return DataTables::of($admins)
            ->addColumn('select_record', function ($model) {
                if($model->is_super == 1) return "";
                return view('admin.admins.parts.select_record', ['id' => $model->id])->render();
            })->addColumn('show_image', function ($model) {
                return view('admin.admins.parts.show_image', ['image' => $model->image])->render();
            })->addColumn('phone_with_code', function ($model) {
                return $model->phone_code . "-" . $model->phone;
            })->addColumn('show_status', function ($model) {
                return view('admin.admins.parts.status', ['id' => $model->id, 'status' => $model->status])->render();
            })->addColumn('actions', function ($model) {
                if($model->is_super == 1) return "";
                return view('admin.admins.parts.actions', ['id' => $model->id])->render();
            })->escapeColumns(['*'])->make(true);
    }
}

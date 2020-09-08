<?php

namespace App\Http\Controllers\Admin;

use App\Facades\FileFacade;
use App\Http\Requests\Admin\User\AddUserRequest;
use App\Http\Requests\Admin\User\UpdateUserRequest;
use App\Http\Requests\ExecuteOptionRequest;
use App\Models\Country;
use App\Repository\UserRepository;
use App\User;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class UserController extends HomeController
{

    public $user_repository;

    public function __construct(UserRepository $user_repository)
    {
        parent::__construct();
        $this->user_repository = $user_repository;

        self::$data['main_title'] = trans('admin.users');
        self::$data['breadcrumbs'] = [
            ['name' => trans('admin.home'), 'url' => url('admin')],
            ['name' => trans('admin.users'), 'url' => route('admin.users.index')],
        ];
        self::$data['active_menu'] = 'users';
        self::$data['sub_menu'] = '';

    }

    public function index()
    {
        parent::$data['countries'] = Country::Active()->get();
        parent::$data['options'] = $this->getOptionsWithDelete();
        return view('admin.users.index', parent::$data);
    }


    public function create()
    {

    }

    public function store(AddUserRequest $request)
    {
        $this->user_repository->add($request);
        return responseJson(true, trans('admin.add_success'), [], 200);
    }

    public function show($id)
    {

    }

    public function edit($id)
    {

    }

    public function update(UpdateUserRequest $request, User $user)
    {
        $this->user_repository->update($request , $user);
        return responseJson(true, trans('admin.update_success'), [], 200);
    }

    public function destroy($id)
    {
        $user = $this->user_repository->find($id);
        try {
            $user->delete();
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
                $this->user_repository->whereIn('id', $ids)->update(['status' => 1]);
                break;
            case 2 :
                $this->user_repository->whereIn('id', $ids)->update(['status' => 0]);
                break;
            case 3 :
                $this->user_repository->destroy($ids);
                break;
        }
        return responseJson(true, trans('admin.update_success'), [], 200);

    }

    // remote data
    public function get_users_ajax(Request $request)
    {
        $users = $this->user_repository->query();

        return DataTables::of($users)
            ->addColumn('select_record', function ($model) {
                return view('admin.users.parts.select_record', ['id' => $model->id])->render();
            })->addColumn('show_image', function ($model) {
                return view('admin.users.parts.show_image', ['image' => $model->image])->render();
            })->addColumn('phone_with_code', function ($model) {
                return $model->phone_code . "-" . $model->phone;
            })->addColumn('show_status', function ($model) {
                return view('admin.users.parts.status', ['id' => $model->id, 'status' => $model->status])->render();
            })->addColumn('actions', function ($model) {
                return view('admin.users.parts.actions', ['id' => $model->id])->render();
            })->escapeColumns(['*'])->make(true);
    }
}

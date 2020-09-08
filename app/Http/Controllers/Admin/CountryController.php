<?php

namespace App\Http\Controllers\Admin;

use App\Facades\FileFacade;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Country\UpdateCountryRequest;
use App\Http\Requests\ExecuteOptionRequest;
use App\Models\Country;
use App\Traits\Controller\ExecuteOptionsTrait;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class CountryController extends HomeController
{
    use ExecuteOptionsTrait;

    public function __construct()
    {
        parent::__construct();

        self::$data['main_title'] = trans('admin.users');
        self::$data['breadcrumbs'] = [
            ['name' => trans('admin.home'), 'url' => url('admin')],
            ['name' => trans('admin.countries'), 'url' => route('admin.countries.index')],
        ];
        self::$data['active_menu'] = 'countries';
        self::$data['sub_menu'] = '';
    }

    public function index() {
        parent::$data['options'] = $this->getOptions();
        return view('admin.countries.index', parent::$data);
    }

    public function update(UpdateCountryRequest $request, Country $country)
    {
        $data = $request->validated();
        $data['flag_id'] = FileFacade::storeImageId($request->flag,$country, 'flag_id' , false);
        $country->update($data);
        return responseJson(true, trans('admin.update_success'), [], 200);
    }

    // execute options
    public function executeOptions(ExecuteOptionRequest $request)
    {
        $ids = $request->ids;
        $option_id = $request->option_id;
        switch ($option_id) {
            case 1 :
                Country::whereIn('id', $ids)->update(['status' => 1]);
                break;
            case 2 :
                Country::whereIn('id', $ids)->update(['status' => 0]);
                break;
//            case 3 :
//                Country::whereIn('id', $ids)->delete();
//                break;
        }
        return responseJson(true, trans('admin.update_success'), [], 200);

    }

    // remote data
    public function get_remote_country(Request $request)
    {
        $countries = Country::with('currency');

        return DataTables::of($countries)
            ->addColumn('select_record', function ($model) {
                return view('admin.countries.parts.select_record', ['id' => $model->id])->render();
            })->addColumn('show_image', function ($model) {
                return view('admin.countries.parts.show_image', ['image' => $model->flag])->render();
            })->addColumn('show_status', function ($model) {
                return view('admin.countries.parts.status', ['id' => $model->id, 'status' => $model->status])->render();
            })->addColumn('actions', function ($model) {
                return view('admin.countries.parts.actions', ['id' => $model->id])->render();
            })->escapeColumns(['*'])->make(true);
    }
}

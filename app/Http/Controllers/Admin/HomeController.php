<?php

namespace App\Http\Controllers\Admin;

use App\Traits\Controller\ExecuteOptionsTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use phpDocumentor\Reflection\Types\Self_;

use App\Repository\HomeRepository;

class HomeController extends Controller
{
    use ExecuteOptionsTrait;

    public static $data = [];
    public function __construct()
    {
        self::$data['locales'] = \GuzzleHttp\json_encode(config('app.locales'));
        self::$data['active_menu'] = 'home';
        self::$data['sub_menu'] = '';

        self::$data['main_title'] = trans('admin.home');
        self::$data['breadcrumbs'] = [];

    }

    public function index() {
        return view('admin.index' ,self::$data);
    }
}

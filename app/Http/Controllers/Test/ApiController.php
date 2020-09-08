<?php

namespace App\Http\Controllers\Test;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use App\Facades\FileFacade;


class ApiController extends Controller
{

    public function test(Request $request) {
       return FileFacade::storeImageId($request->file ,User::first() ,'image_id' , true);
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Facades\FileFacade;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Gallery\AddGalleryRequest;
use App\Models\Gallery;
use App\Models\GalleryType;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class GalleryController extends HomeController
{

    public function __construct()
    {
        parent::__construct();
        self::$data['main_title'] = trans('admin.galleries');
        self::$data['breadcrumbs'] = [
            ['name' => trans('admin.home'), 'url' => url('admin')],
            ['name' => trans('admin.galleries'), 'url' => route('admin.galleries.index')],
        ];

        self::$data['active_menu'] = 'galleries';
        self::$data['sub_menu'] = '';
    }
    public function index()
    {
        parent::$data['types'] = GalleryType::all();
        return view('admin.galleries.index', parent::$data);

    }

    public function create()
    {


    }

    public function store(AddGalleryRequest $request)
    {
        $data = $request->validated();
        $src_path = FileFacade::storeImage($request->src ,'galleries' , null , null , true);
        $image_data = FileFacade::getImageData($src_path);

        $data['src'] = $src_path;
        $data['size'] = $image_data['size'];
        $data['mime_type'] = $image_data['mime_type'];

        $gallery = Gallery::create($data);
        return responseJson(true, trans('admin.add_success'), [
            'gallery' => $gallery
        ], 200);
    }


    public function show($id)
    {

    }


    public function edit($id)
    {

    }


    public function update(AddGalleryRequest $request, Gallery $gallery)
    {
        $data = $request->validated();

        $src_path = FileFacade::storeImage($request->src ,'galleries' , $gallery , 'src' , false);
        $image_data = FileFacade::getImageData($src_path);

        $data['src'] = $src_path;
        $data['size'] = $image_data['size'];
        $data['mime_type'] = $image_data['mime_type'];

        $gallery->update($data);
        return responseJson(true, trans('admin.update_success'), [
            'gallery' => $gallery
        ], 200);
    }

    public function destroy($id)
    {
        $gallery = Gallery::find($id);

        try {
            $gallery->delete();
            return responseJson(true, trans('admin.done_delete'), [], 200);

        } catch (\Exception $e) {
            return responseJson(false, trans('error.image_is_used'), [], 200);

        } catch (\Error $e) {
            return responseJson(false, $e->getMessage(), [], 200);

        }
    }

    // help function
    public function get_remote_gallery(Request $request) {
       $galleries = Gallery::latest()->Search($request->search)->Type($request->type_id)
           ->paginate($request->paginate ?? 10);
       return $galleries;
    }
}

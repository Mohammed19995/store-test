<?php

namespace App\Http\Controllers\Test;

use App\Http\Controllers\Controller;
use App\ServiceInterfaces\Export\ExportPdf;
use App\Traits\Export\ExportTrait;
use App\User;
use Illuminate\Http\Request;
use App\Facades\FileFacade;



class PDFController extends Controller
{
    use ExportTrait;

    public function test(Request $request) {
        $data = $this->setPdfData('test.pdf' ,['users' => User::all()],'Hello World' , 'test2.pdf');
        $this->export(new ExportPdf() ,$data);

        return redirect()->to('test');
    }
}

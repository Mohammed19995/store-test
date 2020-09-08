<?php
/**
 * Created by PhpStorm.
 * User: Al
 * Date: 21/7/2020
 * Time: 09:29 م
 */

namespace App\ServiceInterfaces\Export;

use PDF;
use Elibyy\TCPDF\Facades\TCPDF;

class ExportPdf implements Exportable
{

    public function export($data)
    {
        $view = \View::make($data['view'] , $data['data']);
        $html = $view->render();

        $pdf = new TCPDF();
        $pdf::SetFont('aealarabiya', '', 10);
        $pdf::SetTitle($data['title']);
        $pdf::AddPage();
        $pdf::writeHTML($html, true, false, true, true, '');
        $pdf::Output($data['output']);
    }
}
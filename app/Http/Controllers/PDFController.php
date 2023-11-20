<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf as PDF;

class PDFController extends Controller {

    /**
     * Generate PDF from view
     * 
     * @param string $type
     * @param array $data
     * @return \Illuminate\Http\Response
     */
    public static function generatePDF($type, $data) : \Illuminate\Http\Response {
        switch ($type) {
            case 'employee_shifts':
                $view = 'admin.pdf.employee_shifts';
                break;
        }

        $pdf = PDF::loadView($view, $data);

        $today = date('Y-m-d');
        $filename = $today . '_' . $type . '.pdf';
  
        return $pdf->download($filename);
    }
}

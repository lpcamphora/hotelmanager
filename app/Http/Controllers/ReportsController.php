<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\Reports;


class ReportsController extends Controller
{
    public function __construct(Request $request) {
    }

    public function index(Request $request) {

        $reports = Reports::getReports();
        $chartData = Reports::getPaymentsChartData();

        return view('reports.index', compact('reports', 'chartData'));

    }    

    public function export(Request $request) {

        $reports = Reports::getReports();

        $rows = [];

        foreach ($reports as $report) {
            $payment_method = '';
            switch ($report->payment_method) {
                case 1:
                    $payment_method = 'Dinheiro';
                    break;
                case 2:
                    $payment_method = 'Cartão de Crédito';
                    break;
                case 3:
                    $payment_method = 'Cartão de Débito';
                    break;
                case 4:
                    $payment_method = 'PIX';
                    break;
            }
            $rows[] = [ $report->client, $report->apartment,  $report->plan, $payment_method, $report->created, $report->updated ];
        }

        $data = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><meta http-equiv="content-type" content="application/vnd.ms-excel; charset=UTF-8"><head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>{worksheet}</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--></head><body>';

        $data .= '<table>';
        $data .= "<tr><td colspan=\"4\"><b>Relatórios</b></td></tr>";
        $data .= "<tr><td><b>Cliente:</b></td><td><b>Apartamento:</b></td><td><b>Plano:</b></td><td><b>Forma Pgto.:</b></td><td><b>Data / Hora:</b></td></tr>";

        foreach ($rows as $row) {
            $data .= "<tr><td>" . implode('</td><td>', $row) . "</td></tr>";
        }

        $data .= '</table>';
        $data .= '</body></html>';

        $fileName = 'relatorios-' . date('YmdHis') . '.xls';
    
        header('Content-Encoding: UTF-8');
        header("Content-type: application/excel; charset=UTF-8", true);
        header("Content-Disposition: attachment; filename=\"{$fileName}\"", true);
        header("Content-length: " . strlen($data), true);
        header("Cache-control: private", true);

        echo $data;
        exit(0);

    }    

}

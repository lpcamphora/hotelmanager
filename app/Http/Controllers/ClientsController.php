<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\Clients;


class ClientsController extends Controller
{
    public function __construct(Request $request) {
    }

    public function index(Request $request) {

        $clients = Clients::getClients();

        return view('clients.index', compact('clients'));

    }    

    public function add(Request $request) {

        if ($request->isMethod('post')) {
            $result = Clients::saveClient($request->all());
            if ($result > 0 || $result === true) {
                $clients = Clients::getClients();
                return view('clients.index', compact('clients'));
            } else {
                switch ($result) {
                    case -1:
                        $message = 'Cliente não encontrado.';
                        break;
                    case -2:
                        $message = 'CPF já cadastrado.';
                        break;
                }
                Session::flash('message', $message);
            }
        }

        return view('clients.add');

    }    

    public function change(Request $request) {

        if ($request->isMethod('post')) {
            $result = Clients::saveClient($request->all());
            if ($result > 0 || $result === true) {
                $clients = Clients::getClients();
                return view('clients.index', compact('clients'));
            } else {
                switch ($result) {
                    case -1:
                        $message = 'Cliente não encontrado.';
                        break;
                    case -2:
                        $message = 'CPF já cadastrado.';
                        break;
                }
                Session::flash('message', $message);

            }
        }

        $client = Clients::find($request->id);

        return view('clients.change', compact('client'));

    }    

    public function export(Request $request) {

        $clients = Clients::getClients();

        $rows = [];

        foreach ($clients as $client)
            $rows[] = [ $client->name, $client->cpf, $client->created_at, $client->updated_at ];

        $data = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><meta http-equiv="content-type" content="application/vnd.ms-excel; charset=UTF-8"><head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>{worksheet}</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--></head><body>';

        $data .= '<table>';
        $data .= "<tr><td colspan=\"4\"><b>Clientes</b></td></tr>";
        $data .= "<tr><td><b>Nome:</b></td><td><b>CPF:</b></td><td><b>Criado:</b></td><td><b>Atualizado:</b></td></tr>";

        foreach ($rows as $row) {
            $data .= "<tr><td>" . implode('</td><td>', $row) . "</td></tr>";
        }

        $data .= '</table>';
        $data .= '</body></html>';

        $fileName = 'clientes-' . date('YmdHis') . '.xls';
    
        header('Content-Encoding: UTF-8');
        header("Content-type: application/excel; charset=UTF-8", true);
        header("Content-Disposition: attachment; filename=\"{$fileName}\"", true);
        header("Content-length: " . strlen($data), true);
        header("Cache-control: private", true);

        echo $data;
        exit(0);

    }    

    public function delete(Request $request) {

        if (isset($request->id)) {
            Clients::deleteClient($request->id);
            Session::flash('message', 'Registro excluído com sucesso.');
            return redirect()->route('clients.index');
        }

    }    

}

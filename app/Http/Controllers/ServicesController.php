<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\Services;


class ServicesController extends Controller
{
    public function __construct(Request $request) {
    }

    public function index(Request $request) {

        $services = Services::getServices();

        return view('services.index', compact('services'));

    }    

    public function add(Request $request) {

        if ($request->isMethod('post')) {
            $result = Services::saveService($request->all());
            if ($result > 0 || $result === true) {
                $services = Services::getServices();
                return view('services.index', compact('services'));
            } else {
                switch ($result) {
                    case -1:
                        $message = 'Serviço não encontrado.';
                        break;
                }
                Session::flash('message', $message);
            }
        }

        return view('services.add');

    }    

    public function change(Request $request) {

        if ($request->isMethod('post')) {
            $result = Services::saveService($request->all());
            if ($result > 0 || $result === true) {
                $services = Services::getServices();
                return view('services.index', compact('services'));
            } else {
                switch ($result) {
                    case -1:
                        $message = 'Serviço não encontrado.';
                        break;
                }
                Session::flash('message', $message);

            }
        }

        $service = Services::find($request->id);

        return view('services.change', compact('service'));

    }    

    public function delete(Request $request) {

        if (isset($request->id)) {
            Services::deleteService($request->id);
            Session::flash('message', 'Registro excluído com sucesso.');
            return redirect()->route('services.index');
        }

    }    

}

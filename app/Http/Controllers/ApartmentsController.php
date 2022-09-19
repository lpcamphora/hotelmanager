<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\Apartments;


class ApartmentsController extends Controller
{
    public function __construct(Request $request) {
    }

    public function index(Request $request) {

        $apartments = Apartments::getApartments();

        return view('apartments.index', compact('apartments'));

    }    

    public function add(Request $request) {

        if ($request->isMethod('post')) {
            $result = Apartments::saveApartment($request->all());
            if ($result > 0 || $result === true) {
                $apartments = Apartments::getApartments();
                return view('apartments.index', compact('apartments'));
            } else {
                switch ($result) {
                    case -1:
                        $message = 'Quarto não encontrado.';
                        break;
                    case -2:
                        $message = 'Número de quarto já existente.';
                        break;
                }
                Session::flash('message', $message);
            }
        }

        return view('apartments.add');

    }    

    public function change(Request $request) {

        if ($request->isMethod('post')) {
            $result = Apartments::saveApartment($request->all());
            if ($result > 0 || $result === true) {
                $apartments = Apartments::getApartments();
                return view('apartments.index', compact('apartments'));
            } else {
                switch ($result) {
                    case -1:
                        $message = 'Quarto não encontrado.';
                        break;
                    case -2:
                        $message = 'Número de quarto já existente.';
                        break;
                }
                Session::flash('message', $message);

            }
        }

        $apartment = Apartments::find($request->id);

        return view('apartments.change', compact('apartment'));

    }    

    public function delete(Request $request) {

        if (isset($request->id)) {
            Apartments::deleteApartment($request->id);
            Session::flash('message', 'Registro excluído com sucesso.');
            return redirect()->route('apartments.index');
        }

    }    

}

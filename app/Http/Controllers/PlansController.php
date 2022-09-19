<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\Plans;


class PlansController extends Controller
{
    public function __construct(Request $request) {
    }

    public function index(Request $request) {

        $plans = Plans::getPlans();

        return view('plans.index', compact('plans'));

    }    

    public function add(Request $request) {

        if ($request->isMethod('post')) {
            $result = Plans::savePlan($request->all());
            if ($result > 0 || $result === true) {
                $plans = Plans::getPlans();
                return view('plans.index', compact('plans'));
            } else {
                switch ($result) {
                    case -1:
                        $message = 'Plano não encontrado.';
                        break;
                }
                Session::flash('message', $message);
            }
        }

        return view('plans.add');

    }    

    public function change(Request $request) {

        if ($request->isMethod('post')) {
            $result = Plans::savePlan($request->all());
            if ($result > 0 || $result === true) {
                $plans = Plans::getPlans();
                return view('plans.index', compact('plans'));
            } else {
                switch ($result) {
                    case -1:
                        $message = 'Plano não encontrado.';
                        break;
                }
                Session::flash('message', $message);

            }
        }

        $plan = Plans::find($request->id);

        return view('plans.change', compact('plan'));

    }    

    public function delete(Request $request) {

        if (isset($request->id)) {
            Plans::deletePlan($request->id);
            Session::flash('message', 'Registro excluído com sucesso.');
            return redirect()->route('plans.index');
        }

    }    

}

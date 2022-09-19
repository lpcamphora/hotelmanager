<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Http\Response;
use App\Models\User;
use App\Models\Controls;
use App\Models\Services;
use App\Models\Clients;
use App\Models\Apartments;
use App\Models\Plans;
use App\Models\ControlsServices;
use App\Models\Roles;

class IndexController extends Controller
{

    const OAUTH2_CLIENT_ID = 'bde3fe79f2dfad06404f';
    const OAUTH2_CLIENT_SECRET = '29fcbcb46a18aea1f8ebb4aca4132f0605850933';

    protected $authorizeURL = 'https://github.com/login/oauth/authorize';
    protected $tokenURL = 'https://github.com/login/oauth/access_token';
    protected $apiURLBase = 'https://api.github.com/';
    
    public function __construct(Request $request) {
    }

    public function index(Request $request) {

        $controls = Controls::getControls();
        return view('index.index', compact('controls'));

    }    

    public function login(Request $request) {

        return view('index.login');

    }    

    public function logout(Request $request) {

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect(route('index.login'));

    }    

    public function auth(Request $request) {

        if ($request->isMethod('post')) {

            $email = $request->email;
            $password = $request->password;

            if (($login = User::login($email, $password)) === true) {
                return redirect(route('index'));
            } else {
                switch ($login) {
                    case -1:
                        $message = 'Usuário não encontrado.';
                        break;
                    case -2:
                        $message = 'Usuário ou senha inválida.';
                        break;
                }
                Session::flash('message', $message);
                return redirect()->route('index.login');
            }
            
        }

        return redirect()->route('index.login');

    }

    public function github(Request $request) {

        $request->session()->put('state', hash('sha256', microtime(TRUE).rand().$_SERVER['REMOTE_ADDR']));

        $params = array(
            'client_id' => IndexController::OAUTH2_CLIENT_ID,
            'redirect_uri' => '',
            'scope' => 'user',
            'state' => Session::get('state')
        );        

        return redirect($this->authorizeURL . '?' . http_build_query($params), 302);

    }

    public function oauth(Request $request) {

        if (!isset($request->state)) {
            return redirect()->route('index.login');
        }

        $token = $this->apiRequest($this->tokenURL, [
            'client_id' => IndexController::OAUTH2_CLIENT_ID,
            'client_secret' => IndexController::OAUTH2_CLIENT_SECRET,
            'redirect_uri' => '',
            'state' => $request->state,
            'code' => $request->code
        ]);

        $githubUser = $this->apiRequest($this->apiURLBase . 'user', false, [], $token->access_token);

        $user = User::getGithubUser($githubUser->id);

        if ($user) {
            $userId = $user->id_user;
        } else {
            $userId = User::saveGithubUser($githubUser->id, $githubUser->login, '');
        }

        if (Auth::loginUsingId($userId)) {
            return redirect(route('index'));
        }

        return redirect(route('login'));

    }

    public function signup(Request $request) {

        if ($request->isMethod('post')) {
            $result = User::saveUser($request->all());
            if ($result > 0 || $result === true) {
                return redirect(route('index.login'));
            } else {
                switch ($result) {
                    case -1:
                        $message = 'Usuário não encontrado.';
                        break;
                    case -2:
                        $message = 'Usuário ou senha inválida.';
                        break;
                    case -3:
                        $message = 'Senha e confirmação não conferem.';
                        break;
                    case -4:
                        $message = 'Senha deve possuir no mínimo 6 caracteres.';
                        break;
                }
                Session::flash('message', $message);
            }
        }

        $roles = Roles::get();

        return view('index.signup', compact('roles'));

    }

    public function register(Request $request) {

        if ($request->isMethod('post')) {
            $result = Controls::saveControl($request->all());
            if ($result > 0 || $result === true) {
                $controls = Controls::getControls();
                return view('index.index', compact('controls'));
            } else {
                switch ($result) {
                    case -1:
                        $message = 'Registro não encontrado.';
                        break;
                    case -2:
                        $message = 'Apartamento ocupado no momento.';
                        break;
    
                }
                Session::flash('message', $message);
            }

        }

        Controls::flush();

        $id_control = Controls::createEmpty();
        $clients = Controls::getClients();
        $apartments = Controls::getApartments();
        $plans = Plans::getPlans();
        $services = Services::getServices();;

        return view('index.register', compact('services', 'id_control', 'clients', 'apartments', 'plans'));

    }    

    public function services(Request $request) {

        $data = ControlsServices::getServices($request->id);
        return response()->json(['success' => true, 'data' => json_encode($data)]);        

    }

    public function addservice(Request $request) {

        if ($request->isMethod('post')) {
            $result = ControlsServices::saveService($request->id_control, $request->id_service);
            return response()->json(['success' => true]);        
        }

    }    

    public function deleteservice(Request $request) {

        $result = ControlsServices::deleteService($request->s);
        return response()->json(['success' => true]);        

    }    

    public function release(Request $request) {

        $result = Controls::release($request->id);
        return redirect()->route('index');

    }    

    protected function apiRequest($url, $post = false, $headers = [], $token = null) {

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
      
        if ($post)
          curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post));
      
        $headers[] = 'Accept: application/json';
        $headers[] = 'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/81.0.4044.138 Safari/537.36';
      
        if($token)
          $headers[] = 'Authorization: Bearer ' . $token;

        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
      
        $response = curl_exec($ch);

        return json_decode($response);

      }
      

}

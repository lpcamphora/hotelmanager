<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Clients extends Model
{
    use HasFactory;

    const E_CLIENT_NOT_FOUND = -1;
    const E_CPF_EXISTANT = -2;

    protected $primaryKey = 'id_client';

    public static function getClients() {

        return Clients::selectRaw("*, DATE_FORMAT(clients.created_at, '%d/%m/%Y %H:%i:%s') AS created, DATE_FORMAT(clients.updated_at, '%d/%m/%Y %H:%i:%s') AS updated")
                        ->get();

    }

    public static function saveClient($data) {

        $name               = $data['name'];
        $last_name          = $data['last_name'];
        $cpf                = $data['cpf'];

        if (!isset($data['id_client'])) {

            if (Clients::where('cpf', $cpf)->first()) {
                return Clients::E_CPF_EXISTANT;
            }

            $client = new Clients();

            $client->name = $name;
            $client->last_name = $last_name;
            $client->cpf = $cpf;
            
            $client->created_at = Carbon::now()->setTimezone('UTC')->format('Y-m-d H:i:s');
            $client->updated_at = Carbon::now()->setTimezone('UTC')->format('Y-m-d H:i:s');

            $client->save();

            return true;

        } else {

            $client = Clients::find($data['id_client']);

            if ($client) {

                $client->name = $name;
                $client->last_name = $last_name;
                $client->cpf = $cpf;
                    
                $client->updated_at = Carbon::now()->setTimezone('UTC')->format('Y-m-d H:i:s');

                $client->save();

                return true;

            } else {
                return Clients::E_CLIENT_NOT_FOUND;
            }

        }

    }

    public static function deleteClient($id) {

        Clients::where('id_client', $id)->delete();
        return;

    }

}

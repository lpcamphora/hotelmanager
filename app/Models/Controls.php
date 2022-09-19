<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use App\Models\Apartments;

class Controls extends Model
{
    use HasFactory;

    const E_NOT_FOUND = -1;
    const E_BUSY = -2;

    const S_UNREGISTERED = 0;
    const S_BUSY = 1;
    const S_RELEASED = 2;

    protected $primaryKey = 'id_control';

    public static function getControls() {

        /*return Apartments::select(['apartments.name AS name', 'apartments.number AS number', 'controls.id_control AS id_control', 'controls.total AS total', 'controls.total AS prictotale', 'controls.status AS status'])
                        ->leftJoin('controls', 'controls.id_apartment', '=', 'apartments.id_apartment')
                        ->groupBy('name', 'number', 'id_control', 'total', 'status')
                        ->get();*/

        $result = [];

        $apartments = Apartments::all();

        foreach ($apartments as $apartment) {
            $row = [
                'id_apartment' => $apartment->id_apartment,
                'name' => $apartment->name,
                'number' => $apartment->number,
            ];
            $control = Controls::where(['id_apartment' => $apartment->id_apartment, 'status' => 1])->first();
            if ($control) {
                $row['id_control'] = $control->id_control;
                $row['total'] = $control->total;
                $row['status'] = Controls::S_BUSY;
            } else {
                $row['id_control'] = null;
                $row['total'] = null;
                $row['status'] = Controls::S_RELEASED;

            }
            $result[] = $row;
        }

        return $result;

    }

    public static function getApartments() {

        $apartments = [];

        $rows = Apartments::getApartments();

        foreach ($rows as $row) {
            if (!Controls::where(['id_apartment' => $row->id_apartment, 'status' => Controls::S_BUSY])->first())
                $apartments[] = $row;
        }

        return $apartments;
 
    }

    public static function getClients() {

        $clients = [];

        $rows = Clients::getClients();

        foreach ($rows as $row) {
            if (!Controls::where(['id_client' => $row->id_client, 'status' => Controls::S_BUSY])->first())
                $clients[] = $row;
        }

        return $clients;
 
    }

    public static function saveControl($data) {

        $id_client      = (int) $data['id_client'];
        $id_apartment   = (int) $data['id_apartment'];
        $id_plan        = (int) $data['id_apartment'];
        $payment_method = (int) $data['payment_method'];
        $total          = (float) $data['total'];

        $control = Controls::find($data['id_control']);

        if ($control) {

            if (Controls::where(['id_apartment' => $id_apartment, 'status' => Controls::S_BUSY])->first())
                return Controls::E_BUSY;

            $control->id_client = $id_client;
            $control->id_apartment = $id_apartment;
            $control->id_plan = $id_plan;
            $control->payment_method = $payment_method;
            $control->total = $total;
            $control->status = Controls::S_BUSY;
                    
            $control->updated_at = Carbon::now()->setTimezone('UTC')->format('Y-m-d H:i:s');

            $control->save();

            Reports::saveReport($data);

            return true;

        } else {
            return Controls::E_NOT_FOUND;
        }

    }

    public static function deleteControl($id) {

        Controls::where('id_client', $id)->delete();
        return;

    }

    public static function createEmpty() {

        $control = new Controls();
        $control->created_at = Carbon::now()->setTimezone('UTC')->format('Y-m-d H:i:s');
        $control->updated_at = Carbon::now()->setTimezone('UTC')->format('Y-m-d H:i:s');
        $control->status = Controls::S_UNREGISTERED;
        $control->save();

        return $control->id_control;

    }

    public static function flush() {

        Controls::where('status', Controls::S_UNREGISTERED)->delete();
        return;

    }

    public static function release($id) {

        $control = Controls::find($id);
        $control->status = Controls::S_RELEASED;
        $control->save();
        return;

    }


}

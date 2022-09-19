<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class ControlsServices extends Model
{
    use HasFactory;

    const E_NOT_FOUND = -1;

    protected $primaryKey = 'id_control_service';

    public static function getServices($idControl) {

        return ControlsServices::select(['controls_services.id_control_service AS id', 'services.name AS service', 'services.price AS price'])
                        ->join('services', 'services.id_service', '=', 'controls_services.id_service')
                        ->where('controls_services.id_control', $idControl)
                        ->groupBy('id', 'name', 'price')
                        ->get();

    }

    public static function saveService($idControl, $idService) {

        $idControl   = (int) $idControl;
        $idService   = (int) $idService;

        $control = new ControlsServices();

        $control->id_control = $idControl;
        $control->id_service = $idService;
        $control->created_at = Carbon::now()->setTimezone('UTC')->format('Y-m-d H:i:s');
        $control->updated_at = Carbon::now()->setTimezone('UTC')->format('Y-m-d H:i:s');

        $control->save();

        return true;

    }

    public static function deleteService($id) {

        ControlsServices::where('id_control_service', $id)->delete();
        return;

    }

}

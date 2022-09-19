<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Services extends Model
{
    use HasFactory;

    const E_SERVICE_NOT_FOUND = -1;

    protected $primaryKey = 'id_service';

    public static function getServices() {

        return Services::selectRaw("*, DATE_FORMAT(services.created_at, '%d/%m/%Y %H:%i:%s') AS created, DATE_FORMAT(services.updated_at, '%d/%m/%Y %H:%i:%s') AS updated")
                        ->get();

    }

    public static function saveService($data) {

        $name               = $data['name'];
        $price              = $data['price'];

        $price = str_replace(',', '.', str_replace('.', '', $price));

        if (!isset($data['id_service'])) {

            $service = new Services();

            $service->name = $name;
            $service->price = $price;
            
            $service->created_at = Carbon::now()->setTimezone('UTC')->format('Y-m-d H:i:s');
            $service->updated_at = Carbon::now()->setTimezone('UTC')->format('Y-m-d H:i:s');

            $service->save();

            return true;

        } else {

            $service = Services::find($data['id_service']);

            if ($service) {

                $service->name = $name;
                $service->price = $price;
                            
                $service->updated_at = Carbon::now()->setTimezone('UTC')->format('Y-m-d H:i:s');

                $service->save();

                return true;

            } else {
                return Services::E_SERVICE_NOT_FOUND;
            }

        }

    }

    public static function deleteService($id) {

        Services::where('id_service', $id)->delete();
        return;

    }

}

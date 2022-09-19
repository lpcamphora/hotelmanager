<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Apartments extends Model
{
    use HasFactory;

    const E_APARTMENT_NOT_FOUND = -1;
    const E_NUMBER_EXISTANT = -2;

    protected $primaryKey = 'id_apartment';

    public static function getApartments() {

        return Apartments::selectRaw("*, DATE_FORMAT(apartments.created_at, '%d/%m/%Y %H:%i:%s') AS created, DATE_FORMAT(apartments.updated_at, '%d/%m/%Y %H:%i:%s') AS updated")
                        ->get();

    }

    public static function saveApartment($data) {

        $name               = $data['name'];
        $number             = (int) $data['number'];

        if (!isset($data['id_apartment'])) {

            if (Apartments::where('number', $number)->first()) {
                return Apartments::E_NUMBER_EXISTANT;
            }

            $apartment = new Apartments();

            $apartment->name = $name;
            $apartment->number = $number;
            
            $apartment->created_at = Carbon::now()->setTimezone('UTC')->format('Y-m-d H:i:s');
            $apartment->updated_at = Carbon::now()->setTimezone('UTC')->format('Y-m-d H:i:s');

            $apartment->save();

            return true;

        } else {

            $apartment = Apartments::find($data['id_apartment']);

            if ($apartment) {

                $apartment->name = $name;
                $apartment->number = $number;
                        
                $apartment->updated_at = Carbon::now()->setTimezone('UTC')->format('Y-m-d H:i:s');

                $apartment->save();

                return true;

            } else {
                return Apartments::E_APARTMENT_NOT_FOUND;
            }

        }

    }

    public static function deleteApartment($id) {

        Apartments::where('id_apartment', $id)->delete();
        return;

    }

}

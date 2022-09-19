<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Plans extends Model
{
    use HasFactory;

    const E_PLAN_NOT_FOUND = -1;

    protected $primaryKey = 'id_plan';

    public static function getPlans() {

        return Plans::selectRaw("*, DATE_FORMAT(plans.created_at, '%d/%m/%Y %H:%i:%s') AS created, DATE_FORMAT(plans.updated_at, '%d/%m/%Y %H:%i:%s') AS updated")
                        ->get();

    }

    public static function savePlan($data) {

        $name               = $data['name'];
        $days               = (int) $data['days'];
        $price              = $data['price'];

        $price = str_replace(',', '.', str_replace('.', '', $price));

        if (!isset($data['id_plan'])) {

            $plan = new Plans();

            $plan->name = $name;
            $plan->days = $days;
            $plan->price = $price;
            
            $plan->created_at = Carbon::now()->setTimezone('UTC')->format('Y-m-d H:i:s');
            $plan->updated_at = Carbon::now()->setTimezone('UTC')->format('Y-m-d H:i:s');

            $plan->save();

            return true;

        } else {

            $plan = Plans::find($data['id_plan']);

            if ($plan) {

                $plan->name = $name;
                $plan->days = $days;
                $plan->price = $price;
                            
                $plan->updated_at = Carbon::now()->setTimezone('UTC')->format('Y-m-d H:i:s');

                $plan->save();

                return true;

            } else {
                return Plans::E_PLAN_NOT_FOUND;
            }

        }

    }

    public static function deletePlan($id) {

        Plans::where('id_plan', $id)->delete();
        return;

    }

}

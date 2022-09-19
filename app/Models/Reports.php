<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;


class Reports extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_report';

    public static function getReports() {

        return Reports::selectRaw("*, CONCAT(clients.name, ' ', clients.last_name) AS client, CONCAT(apartments.name, ' ', apartments.number) AS apartment, plans.name AS plan, DATE_FORMAT(reports.created_at, '%d/%m/%Y %H:%i:%s') AS created, DATE_FORMAT(reports.updated_at, '%d/%m/%Y %H:%i:%s') AS updated")
                        ->join('clients', 'clients.id_client', '=', 'reports.id_client')
                        ->join('apartments', 'apartments.id_apartment', '=', 'apartments.id_apartment')
                        ->join('plans', 'plans.id_plan', '=', 'plans.id_plan')
                        ->groupBy('reports.id_report')
                        ->get();

    }

    public static function saveReport($data) {

        $id_client      = (int) $data['id_client'];
        $id_apartment   = (int) $data['id_apartment'];
        $id_plan        = (int) $data['id_apartment'];
        $payment_method = (int) $data['payment_method'];
        $total          = (float) $data['total'];

        $report = new Reports();

        $report->id_client = $id_client;
        $report->id_apartment = $id_apartment;
        $report->id_plan = $id_plan;
        $report->payment_method = $payment_method;
        $report->total = $total;
        $report->created_at = Carbon::now()->setTimezone('UTC')->format('Y-m-d H:i:s');
        $report->updated_at = Carbon::now()->setTimezone('UTC')->format('Y-m-d H:i:s');

        $report->save();

        return;

    }

    public static function  getPaymentsChartData() {

        $datasets = [
            0 => [],
            1 => [],
            2 => [],
            3 => []
        ];
        $labels = [];

        for ($i = 6; $i >= 0 ; $i--) {

            $dt = date('Y-m-d', strtotime("-$i days", strtotime(date('Y-m-d'))));

            $p1 = Reports::select([ DB::raw('COUNT(*) AS num_payments') ])
                            ->where([ 'payment_method' => 1 ])
                            ->whereBetween('created_at', [$dt . ' 00:00:00', $dt . ' 23:59:59'])
                            ->first();

            $datasets[0][] = $p1->num_payments;

            $p2 = Reports::select([ DB::raw('COUNT(*) AS num_payments') ])
                            ->where([ 'payment_method' => 2 ])
                            ->whereBetween('created_at', [$dt . ' 00:00:00', $dt . ' 23:59:59'])
                            ->first();

            $datasets[1][] = $p2->num_payments;                            

            $p3 = Reports::select([ DB::raw('COUNT(*) AS num_payments') ])
                            ->where([ 'payment_method' => 3 ])
                            ->whereBetween('created_at', [$dt . ' 00:00:00', $dt . ' 23:59:59'])
                            ->first();

            $datasets[2][] = $p3->num_payments;                            

            $p4 = Reports::select([ DB::raw('COUNT(*) AS num_payments') ])
                            ->where([ 'payment_method' => 4 ])
                            ->whereBetween('created_at', [$dt . ' 00:00:00', $dt . ' 23:59:59'])
                            ->first();

            $datasets[3][] = $p4->num_payments;   
            
            $labels[] = $dt;
            
        }

        $result = new \stdClass();

        $result->datasets = $datasets;
        $result->labels = $labels;

        return $result;

    }

}

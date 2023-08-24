<?php

namespace App\Http\Controllers\Teknisi;

use Illuminate\Http\Request;
use App\Models\PsbWorkOrders;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;

class TeknisiController extends Controller
{
    public function index()
    {
        $customers = PsbWorkOrders::
        join('griya_customers.customers','psb_work_orders.pppoe_secret','=','griya_customers.customers.pppoe_secret')
        ->join('griya_customers.customers_alamat_maps','psb_work_orders.pppoe_secret','=','griya_customers.customers_alamat_maps.pppoe_secret')
        ->join('griya_customers.customers_alamat_terpasang','psb_work_orders.pppoe_secret','=','griya_customers.customers_alamat_terpasang.pppoe_secret')
        ->join('griya_company.service_packages','griya_customers.customers.service_packages_id','=','griya_company.service_packages.id')
        ->join('griya_coverage.spliters','griya_customers.customers.spliter_id','=','griya_coverage.spliters.id')
        ->join('griya_coverage.coverage_areas','griya_customers.customers.coverage_areas_id','=','griya_coverage.coverage_areas.id')
        ->join('griya_coverage.placements','griya_coverage.spliters.placement_id','=','griya_coverage.placements.id')
        ->where('griya_customers.customers.subscribe_status','=','paid')
        ->where('status_proggres','!=',null)
        ->where('is_active','=',1)
        ->count();

        if($customers == 1){
            $all = PsbWorkOrders::
            join('griya_customers.customers','psb_work_orders.pppoe_secret','=','griya_customers.customers.pppoe_secret')
            ->join('griya_customers.customers_alamat_maps','psb_work_orders.pppoe_secret','=','griya_customers.customers_alamat_maps.pppoe_secret')
            ->join('griya_customers.customers_alamat_terpasang','psb_work_orders.pppoe_secret','=','griya_customers.customers_alamat_terpasang.pppoe_secret')
            ->join('griya_company.service_packages','griya_customers.customers.service_packages_id','=','griya_company.service_packages.id')
            ->join('griya_coverage.spliters','griya_customers.customers.spliter_id','=','griya_coverage.spliters.id')
            ->join('griya_coverage.coverage_areas','griya_customers.customers.coverage_areas_id','=','griya_coverage.coverage_areas.id')
            ->join('griya_coverage.placements','griya_coverage.spliters.placement_id','=','griya_coverage.placements.id')
            ->where('griya_customers.customers.subscribe_status','=','paid')
            ->where('status_proggres','!=',null)
            ->where('is_active','=',1)
            ->get();
            
            return view('teknisi.index',[
                'customers' => $all
            ]);
        }else{
            $all = PsbWorkOrders::
            join('griya_customers.customers','psb_work_orders.pppoe_secret','=','griya_customers.customers.pppoe_secret')
            ->join('griya_customers.customers_alamat_maps','psb_work_orders.pppoe_secret','=','griya_customers.customers_alamat_maps.pppoe_secret')
            ->join('griya_customers.customers_alamat_terpasang','psb_work_orders.pppoe_secret','=','griya_customers.customers_alamat_terpasang.pppoe_secret')
            ->join('griya_company.service_packages','griya_customers.customers.service_packages_id','=','griya_company.service_packages.id')
            ->join('griya_coverage.spliters','griya_customers.customers.spliter_id','=','griya_coverage.spliters.id')
            ->join('griya_coverage.coverage_areas','griya_customers.customers.coverage_areas_id','=','griya_coverage.coverage_areas.id')
            ->join('griya_coverage.placements','griya_coverage.spliters.placement_id','=','griya_coverage.placements.id')
            ->where('griya_customers.customers.subscribe_status','=','paid')
            ->where('status_proggres','!=',null)
            ->where('is_active','!=',1)
            ->get();
            // dd('a');

            return view('teknisi.index',[
                'customers' => $all
            ]);

        }
    }

    public function penarikan($pppoe_secret)
    {
        $jam = Carbon::now()->format('Y-m-d H:i:s');
        PsbWorkOrders::where('pppoe_secret',$pppoe_secret)->update(
            ['start' => $jam,'is_active' => 1,'status_proggres' => 'mulai_penarikan']);
        return redirect('/teknisi')->with('success', 'Penarikan Start');
    }
    public function ajukanreg($pppoe_secret)
    {
        PsbWorkOrders::where('pppoe_secret',$pppoe_secret)->update(
            ['status_proggres' => 'ajukan_reg']);
        return redirect('/teknisi')->with('success', 'Request Registrasi');
    }
    public function show($pppoe_secret)
    {
        $customers = PsbWorkOrders::
        join('griya_customers.customers','psb_work_orders.pppoe_secret','=','griya_customers.customers.pppoe_secret')
        ->join('griya_customers.customers_alamat_maps','psb_work_orders.pppoe_secret','=','griya_customers.customers_alamat_maps.pppoe_secret')
        ->join('griya_customers.customers_alamat_terpasang','psb_work_orders.pppoe_secret','=','griya_customers.customers_alamat_terpasang.pppoe_secret')
        ->join('griya_company.service_packages','griya_customers.customers.service_packages_id','=','griya_company.service_packages.id')
        ->join('griya_coverage.spliters','griya_customers.customers.spliter_id','=','griya_coverage.spliters.id')
        ->join('griya_coverage.coverage_areas','griya_customers.customers.coverage_areas_id','=','griya_coverage.coverage_areas.id')
        ->join('griya_coverage.placements','griya_coverage.spliters.placement_id','=','griya_coverage.placements.id')
        ->where('griya_customers.customers.pppoe_secret','=',$pppoe_secret)
        ->get();
        // dd($customers);
        return view('teknisi.show',[
            'customers' => $customers
        ]);
    }
}

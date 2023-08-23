<?php

namespace App\Http\Controllers\Oprasional;

use Illuminate\Http\Request;
use App\Models\PsbWorkOrders;
use App\Http\Controllers\Controller;

class OprasionalController extends Controller
{
    public function index()
    {
        return view('oprasional.index');
    }

    public function allPsb()
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
        ->get();
        // dd($customers);
        return view('oprasional.all-psb',[
            'customers' => $customers
        ]);
    }


}

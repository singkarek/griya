<?php

namespace App\Http\Controllers\Oprasional;

use Illuminate\Http\Request;
use App\Models\PsbWorkOrders;
use App\Http\Controllers\Controller;

class AntrianController extends Controller
{
    public function requestvalidasi()
    {
        $request_validasi = PsbWorkOrders::
          join('griya_customers.customers','psb_work_orders.pppoe_secret','=','griya_customers.customers.pppoe_secret')
        ->join('griya_customers.customers_alamat_maps','psb_work_orders.pppoe_secret','=','griya_customers.customers_alamat_maps.pppoe_secret')
        ->join('griya_customers.customers_alamat_terpasang','psb_work_orders.pppoe_secret','=','griya_customers.customers_alamat_terpasang.pppoe_secret')
        ->join('griya_company.service_packages','griya_customers.customers.service_packages_id','=','griya_company.service_packages.id')
        ->where('status_wo','!=','terpasang')
        ->where('status_wo','=','prosess_validasi')
        ->get();

        // dd($request_validasi);
        return view('oprasional.new-customers.request-validasi',[
           'customers' => $request_validasi
        ]);
    }

    public function riviewValidasi($pppoe_secret)
    {
        // dd($pppoe_secret);
        return view('oprasional.new-customers.riview-validasi');
    }

    public function waitPayment()
    {
        $wait_payment = PsbWorkOrders::
            join('griya_customers.customers','psb_work_orders.pppoe_secret','=','griya_customers.customers.pppoe_secret')
        ->join('griya_customers.customers_alamat_maps','psb_work_orders.pppoe_secret','=','griya_customers.customers_alamat_maps.pppoe_secret')
        ->join('griya_customers.customers_alamat_terpasang','psb_work_orders.pppoe_secret','=','griya_customers.customers_alamat_terpasang.pppoe_secret')
        ->join('griya_company.service_packages','griya_customers.customers.service_packages_id','=','griya_company.service_packages.id')
        ->where('subscribe_status','=','pra_wo')
        ->where('status_wo','=','tervalidasi')
        ->get();

        // dd($wait_payment);
        return view('oprasional.new-customers.wait-payment',[
            'customers' => $wait_payment
        ]);
    }

    public function waitaAtrian()
    {
        $wait_jadwal = PsbWorkOrders::
            join('griya_customers.customers','psb_work_orders.pppoe_secret','=','griya_customers.customers.pppoe_secret')
        ->join('griya_customers.customers_alamat_maps','psb_work_orders.pppoe_secret','=','griya_customers.customers_alamat_maps.pppoe_secret')
        ->join('griya_customers.customers_alamat_terpasang','psb_work_orders.pppoe_secret','=','griya_customers.customers_alamat_terpasang.pppoe_secret')
        ->join('griya_company.service_packages','griya_customers.customers.service_packages_id','=','griya_company.service_packages.id')
        ->where('subscribe_status','=','paid')
        ->where('status_wo','=','tervalidasi')
        ->get();

        return view('oprasional.new-customers.wait-jadwal',[
            'customers' => $wait_jadwal
        ]);
    }

    public function penjadwalan()
    {
        return view('oprasional.new-customers.penjadwalan');
    }

}

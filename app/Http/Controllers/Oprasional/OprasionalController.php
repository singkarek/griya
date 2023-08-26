<?php

namespace App\Http\Controllers\Oprasional;

use App\Models\Customers;
use App\Models\Prospects;
use Illuminate\Http\Request;
use App\Models\PsbWorkOrders;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;

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

    public function regist()
    {
        $customers = PsbWorkOrders::
        join('griya_customers.customers','psb_work_orders.pppoe_secret','=','griya_customers.customers.pppoe_secret')
        ->join('griya_customers.customers_alamat_maps','psb_work_orders.pppoe_secret','=','griya_customers.customers_alamat_maps.pppoe_secret')
        ->join('griya_customers.customers_alamat_terpasang','psb_work_orders.pppoe_secret','=','griya_customers.customers_alamat_terpasang.pppoe_secret')
        ->join('griya_company.service_packages','griya_customers.customers.service_packages_id','=','griya_company.service_packages.id')
        ->join('griya_coverage.spliters','griya_customers.customers.spliter_id','=','griya_coverage.spliters.id')
        ->join('griya_coverage.coverage_areas','griya_customers.customers.coverage_areas_id','=','griya_coverage.coverage_areas.id')
        ->join('griya_coverage.placements','griya_coverage.spliters.placement_id','=','griya_coverage.placements.id')
        ->where('status_proggres','=','ajukan_reg')
        ->get();
        // dd($customers);
        return view('oprasional.regist',[
            'customers' => $customers
        ]);
    }

    public function registDetail($pppoe_secret)
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
        return view('oprasional.regist-detail',[
            'customers' => $customers
        ]);
    }

    public function registStore(Request $request)
    {
        // dd($request->pppoe_secret);
        $jam = Carbon::now()->format('Y-m-d H:i:s');
        PsbWorkOrders::where('pppoe_secret',$request->pppoe_secret)->update(['end' => $jam,'is_active' => 0,'status_proggres' => 'reg_done']);
        return redirect('/oprasional/regist')->with('success', 'Registrasi Berhasil !');
    }

    public function doneCustomer($pppoe_secret)
    {
        $cust = Customers::where('pppoe_secret',$pppoe_secret)
        ->join('griya_company.service_packages','griya_customers.customers.service_packages_id','=','griya_company.service_packages.id')->get();
        $prospect_id = $cust[0]['prospects_id']; 
        $tstamp = Carbon::now()->format('Y-m-d H:i:s');
        $date = Carbon::now()->format('Y-m-d');
        $expdate = Carbon::now()->addDays(30)->format('Y-m-d');

        $nomer_tlp = $cust[0]['no_tlp'];
        $nama = $cust[0]['nama'];
        $nomor_pelanggan = $cust[0]['pppoe_secret'];
        $nama_layanan = $cust[0]['nama_layanan'];
        $harga_layanan = $cust[0]['harga'];
        $va = $cust[0]['va'];
        $type_customer = $cust[0]['type_customer'];

        // dd($cust);

        $customer = [
            'subscribe_start' => $date,
            'subscribe_expired' => $expdate,
            'subscribe_status' => 'aktif_berlangganan'
        ];

        $wo = ['status_wo' => 'selesai'];

        $prospect = ['status_akhir' => 'selesai'];

        if($type_customer == 3){
            $customer['subscribe_expired'] = null;
            Customers::where('pppoe_secret',$pppoe_secret)->update($customer);
            PsbWorkOrders::where('pppoe_secret',$pppoe_secret)->update($wo);
            Prospects::where('id',$prospect_id)->update($prospect);
            return redirect('/oprasional/allpsb')->with('success', 'Validasi Berhasil !');
        }

        Http::asForm()->post(env('WHATSAPP'), [
            'number' => $nomer_tlp,
            'message' => 'Terimakasih atas kepercayaan anda untuk berlanggan internet GRIYANET.'."\n"."\n".
                         'Kami Menginformasikan Layanan INTERNET Anda Telah Aktif :'."\n"."\n".
                         'Nama Pelanggan : '.$nama."\n".
                         'Nomor Pelanggan : '. $nomor_pelanggan."\n".
                         'Paket Berlanggan : '.$nama_layanan."\n".
                         'Harga Layanan : '.'Rp. '.$harga_layanan."\n".
                         'Jatuh Tempo Selanjutnya : '.$expdate."\n"."\n".

                        'Pembayaran selanjutnya dapat dilakukan melalui Bank atau retail di bawah ini, dengan Virtual Account sebagai berikut :'."\n"."\n".
                        'BCA : '.'19005614'.$va."\n".
                        'Mandiri : '.'19005614'.$va."\n".
                        'BRI : '.'142321'.$va."\n".
                        'Alfamart : '.'352220'.$va."\n",
                        'Indomart : '.'352221'.$va."\n",
        ]);


        Customers::where('pppoe_secret',$pppoe_secret)->update($customer);
        PsbWorkOrders::where('pppoe_secret',$pppoe_secret)->update($wo);
        Prospects::where('id',$prospect_id)->update($prospect);

        return redirect('/oprasional/allpsb')->with('success', 'Validasi Berhasil !');
    }

}

<?php
// Sales::select('id')->where('id',7)->get()
namespace App\Http\Controllers\Sales;

use App\Models\Sales;
use App\Models\Pakets;
use App\Models\Spliters;
use App\Models\Customers;
use App\Models\CoverageArea;
use Illuminate\Http\Request;
use App\Models\PsbWorkOrders;
use App\Http\Controllers\Controller;

class SalesController extends Controller
{
    public function index()
    {
    //    $data = Customers::with('spliter')
    //     ->where('pppoe_secret','=','G2108232')
    //     ->get();
    //    dd($data);
        return view('sales.index');
    }

    public function mapsAccess()
    {
        // $accsess = CoverageArea::Join('placements', 'coverage_areas.id', '=' , 'placements.area_id')->get();
        // 'spliters.type_spliter', 'spliters.id'
        $accsess = Spliters::select(
            'coverage_areas.kode_area',
            'spliters.id', 'spliters.type_spliter', 'spliters.parent_ke', 'spliters.spliter_ke','spliters.coverage_areas_id',
            'placements.nama_tempat', 'placements.alamat', 'placements.lat', 'placements.lng'
            )->join('placements', 'spliters.placement_id', '=', 'placements.id')
            ->join('coverage_areas', 'spliters.coverage_areas_id', '=', 'coverage_areas.id')
            ->whereNotNull('placement_id')
            ->where('spliters.type_spliter', 'accsess')
            ->withCount(['customers' => function ($query) {
                    $query->where('subscribe_status', '!=' ,'terminate');
                }])->get();
                
        return view('sales.map-access',[
            'accsess' => $accsess
        ]);
    }

    public function prosesPemasangan()
    {   
        $nip = auth()->user()->karyawan_nip;
        $admin = auth()->user()->is_admin;

        $work_orders_psb = PsbWorkOrders::
            join('griya_customers.customers','psb_work_orders.pppoe_secret','=','griya_customers.customers.pppoe_secret')
            ->join('griya_customers.customers_alamat_maps','psb_work_orders.pppoe_secret','=','griya_customers.customers_alamat_maps.pppoe_secret')
            ->join('griya_customers.customers_alamat_terpasang','psb_work_orders.pppoe_secret','=','griya_customers.customers_alamat_terpasang.pppoe_secret')
            ->join('griya_company.service_packages','griya_customers.customers.service_packages_id','=','griya_company.service_packages.id')
            ->where('status_wo','!=','terpasang')
            ->where('sales_nip','=',$nip)->get();
            // dd($work_orders_psb);
        return view('sales.progres-pemasangan',[
            'customers' => $work_orders_psb
        ]);
    }

}

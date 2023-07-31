<?php
// Sales::select('id')->where('id',7)->get()
namespace App\Http\Controllers\Sales;

use Illuminate\Http\Request;
use App\Models\Sales;
use App\Models\Pakets;
use App\Http\Controllers\Controller;

class SalesController extends Controller
{
    public function index()
    {
        return view('sales.index');
    }

    public function antrian()
    {
        return view('sales.prospect.antrian');
    }

}

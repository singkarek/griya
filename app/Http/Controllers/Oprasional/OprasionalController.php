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


}

<?php

namespace App\Http\Controllers;

use App\Models\Kendaraan;
use App\Models\Sewa;
use App\Models\Wisatawan;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $totalWisatawan = Wisatawan::count();
        $totalKendaraan =  Kendaraan::count();
        $totalBooking = Sewa::count();

        return view('home', compact('totalWisatawan', 'totalKendaraan', 'totalBooking'));
    }
}

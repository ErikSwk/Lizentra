<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lizenz;
use App\Models\Computer;
use App\Models\ComputerLizenz;
use DB;

use Illuminate\Support\Facades\Storage;

class AlleLizenzenController extends Controller
{
    // Abrufen aller Lizenzen
    public function get()
    {
        //$licenses = Lizenz::all();
        $licenses =Lizenz::select('Software',
            DB::raw('SUM(MaxAnzahl) as totaleMaxAnzahl'),
            DB::raw('SUM(Anzahl) as totaleAnzahl'))
            ->groupBy('Software')
            ->get()
            ->map(function ($item) {
                return [
                    'Software' => $item->Software,
                    'MaxAnzahl' => $item->totaleMaxAnzahl,
                    'Anzahl' => $item->totaleAnzahl,
                ];
            });

        return response()->json([
            'status' => 200,
            'lizenzen' => $licenses,
        ]);
    }

    public function view()
    {
        return view('admin.alleLizenzen');
    }
}

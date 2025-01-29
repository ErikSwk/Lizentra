<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Computer;
use App\Models\Lizenz;
use App\Models\ComputerLizenz;
use DB;

class ComputerControllerNeu extends Controller
{
    public function view($sek_id, $Lizenzschluessel)
    {
        return view('user.computerEinerLizenz', [
            'Lizenzschluessel' => $Lizenzschluessel,    
            'sek_id' => $sek_id
        ]);
    }

    public function get($Lizenzschluessel)
    {
        $pivot = ComputerLizenz::where('lizenzschluessel', $Lizenzschluessel)->get();

        if ($pivot->isEmpty()) {
            return response()->json([
                'status' => 404,
                'message' => 'Keine Computer gefunden.',
                'computers' => [],
            ]);
        }

        $computers = $pivot->map(function ($entry) {
            return Computer::find($entry->computer_id);
        });

        return response()->json([
            'status' => 200,
            'computers' => $computers,
        ]);
    }

    public function entfernen($PCID, $Lizenzschluessel)
    {
        $lizenz = Lizenz::where('Lizenzschluessel', $Lizenzschluessel)->first();
        Lizenz::where('Lizenzschluessel', $Lizenzschluessel)->update([
            'Anzahl' => ($lizenz->Anzahl - 1),
        ]);

        // Hier nur n:m Beziehung löschen
        DB::table('computer_lizenz')->where('lizenzschluessel', $Lizenzschluessel)->where('computer_id', $PCID)->delete();

        return response()->json(['status' => 200, 'message' => 'Lizenz erfolgreich entfernt.']); 
    }
}

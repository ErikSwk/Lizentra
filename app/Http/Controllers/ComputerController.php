<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;


use Illuminate\Http\Request;
use App\Models\Computer;
use App\Models\Lizenz;
use DB;

class ComputerController extends Controller
{
    public function view($sek_id){ // Exsetiert nur für die Admins wenn die auf die Computer eines Sek gehen
        return view('user.dashboard', [
            'id' => $sek_id
        ]);
    }

    public function store(Request $request, $id)
    {
        $validatedData = $request->validate([
            'PCID' => 'required|string|max:255',
            'Büronummer' => 'required|string|max:255',
        ]);

        $computer = new Computer;
        $computer->PCID = $request->PCID;
        $computer->Büronummer = $request->Büronummer;
        $computer->sekretariat_id = $id;
        $computer->save();

        return response()->json(['status' => 200, 'message' => 'Computer successfully added']);
    }

    public function getall($id)
    {
        // Nur relevante Felder aus der Datenbank abrufen
        $computers = Computer::where('sekretariat_id', $id)->get();

        return response()->json([
            'status' => 200,
            'computers' => $computers
        ]);
    }

    public function edit($PCID)
    {
        $computer = Computer::where('id', $PCID)->first();
        if ($computer) {
            return response()->json([
                'status' => 200,
                'computer' => $computer
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Computer not found'
            ]);
        }
    }


    public function update(Request $request)
    {
        $validatedData = $request->validate([
            'PCID' => 'required|string|max:255', // PCID bleibt unverändert
            'Büronummer' => 'required|string|max:255',
        ]);

        $computer = Computer::where('id', $request->id)->first(); // Suche nach PCID

        if ($computer) {
            $computer->PCID = $request->PCID;
            $computer->Büronummer = $request->Büronummer;
            $computer->save();
            return response()->json([
                'status' => 200,
                'message' => 'Computer updated successfully'
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Computer not found'
            ]);
        }
    }

    public function delete($id)
    {
        $computer = Computer::where('id', $id)->first(); // Suche nach PCID

        //Anzahl kooriegeiern
        $lizenzen = $computer->lizenzen()->get();
        foreach ($lizenzen as $lizenz) {
            Lizenz::where('Lizenzschluessel', $lizenz->Lizenzschluessel)->update([
                'Anzahl' => ($lizenz->Anzahl - 1),
            ]);
        }

        //n:m Beziehung auflösen
        DB::table('computer_lizenz')->where('computer_id', $id)->delete();

        if ($computer && $computer->delete()) {
            return response()->json(['status' => 200, 'message' => 'Computer deleted successfully.']);
        } else {
            return response()->json(['status' => 400, 'message' => 'Failed to delete the computer.']);
        }
    }

    // Hier neuer Bereich für die alle Computer Seite der Amins
    public function viewAlleComputer()
    {
        $sek_id = Auth::user()->sekretariat_id; // Annahme: Sekretariat-ID im User-Modell hinterlegt
        return view('admin.alleComputer', [
            'sek_id' => $sek_id, // Hier wird sek_id an die View übergeben
        ]);
    }




    public function getAlleComputer()
    {
        $computers = DB::table('computer')->select('id', 'PCID', 'Büronummer', 'sekretariat_id')->get();

        return response()->json([
            'status' => 200,
            'computers' => $computers
        ]);
    }

    public function storeBeiAlleComputer(Request $request)
    {
        $validatedData = $request->validate([
            'PCID' => 'required|string|max:255',
            'Büronummer' => 'required|string|max:255',
            'sekretariat_id' => 'required|string|max:255',
        ]);

        $computer = new Computer;
        $computer->PCID = $request->PCID;
        $computer->Büronummer = $request->Büronummer;
        $computer->sekretariat_id = $request->sekretariat_id;
        $computer->save();

        return response()->json(['status' => 200, 'message' => 'Computer successfully added']);
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lizenz;
use App\Models\Conputer;
use App\Models\ComputerLizenz;
use Illuminate\Support\Facades\Storage;
use DB;

class LizenzenControllerNeu extends Controller
{
    public function view($id)
    {
        return view('user.lizenzen', [
            'id' => $id
        ]);
    }

    public function get($id)
    {
        $lizenzen = Lizenz::where('sekretariat_id', $id)->get();

        return response()->json([
            'status' => 200,
            'lizenzen' => $lizenzen,
        ]);
    }

    public function add(Request $request, $id)
    {
        $request->validate([
            'Lizenzschluessel' => 'required|string|unique:lizenzen,lizenzschluessel',
            'MaxAnzahl' => 'required|int',
            'Lizenzbeginn' => 'required|date',
            'Lizenzende' => 'required|date',
            'Software' => 'required|string',
            'Lizenzstatus' => 'required|string',
            'Rechnung' => 'nullable|file|mimes:pdf,jpeg,jpg,png|max:2048',
        ]);

        $rechnungsPfad = null;
        if ($request->hasFile('Rechnung')) {
            $rechnungsPfad = $request->file('Rechnung')->store('Rechnungen', 'local');
        }

        $lizenz = new Lizenz;
        $lizenz->Lizenzschluessel = $request->Lizenzschluessel;
        $lizenz->sekretariat_id = $id;

        $lizenz->MaxAnzahl = $request->MaxAnzahl;

        $lizenz->Lizenzbeginn = $request->Lizenzbeginn;
        $lizenz->Lizenzende = $request->Lizenzende;
        $lizenz->Software = $request->Software;
        $lizenz->Lizenzstatus = $request->Lizenzstatus;
        $lizenz->Rechnungs_Pfad = $rechnungsPfad;
        $lizenz->save();



        return response()->json([
            'message' => 'Lizenz erfolgreich hinzugefügt!',
        ]);
    }

    public function update(Request $request)
    {
        //return $request->all();
        //return $request->id;
        $request->validate([
            'Lizenzschluessel' => 'required|string|unique:lizenzen,lizenzschluessel,' .  $request->LizenzschluesselAlt . ',lizenzschluessel', // der letzte Teil sorft dafür das der Prim Schlüssel das sein/bleiben kann was er aktuell ist
            'MaxAnzahl' => 'required|int',
            'Lizenzbeginn' => 'required|date',
            'Lizenzende' => 'required|date',
            'Software' => 'required|string',
            'Lizenzstatus' => 'required|string',
            'Rechnung' => 'nullable|file|mimes:pdf,jpeg,jpg,png|max:2048',
        ]);

        $lizenz = Lizenz::where('Lizenzschluessel', $request->LizenzschluesselAlt)->first();
        $rechnungsPfad = $lizenz->Rechnungs_Pfad;
        if ($request->hasFile('Rechnung')) {
            if($rechnungsPfad != null) { // löschen der alten Rechnung
                Storage::delete($rechnungsPfad);
            }
            $rechnungsPfad = $request->file('Rechnung')->store('Rechnungen', 'local');
            $lizenz->Rechnungs_Pfad = $rechnungsPfad;
        }

        Lizenz::where('Lizenzschluessel', $request->LizenzschluesselAlt)->update([
            'Lizenzschluessel' => $request->Lizenzschluessel,
            'MaxAnzahl' => $request->MaxAnzahl,
            'Lizenzbeginn' => $request->Lizenzbeginn,
            'Lizenzende' => $request->Lizenzende,
            'Software' => $request->Software,
            'Lizenzstatus' => $request->Lizenzstatus,
            'Rechnungs_Pfad' => $rechnungsPfad,
        ]);
        

        return response()->json([
            'message' => 'Lizenz erfolgreich aktualisiert.',
        ]);
        
        // Warum auch immer funktioniert die alte Syntax mit update() hier nicht nicht
        
        /* //$license = Lizenz::find($request->id);
        $lizenz = Lizenz::where('Lizenzschluessel', $request->LizenzschluesselAlt)->first();
        //return $license;

        $lizenz->Lizenzschluessel = $request->Lizenzschluessel;
        $lizenz->MaxAnzahl = $request->MaxAnzahl;
        $lizenz->Lizenzbeginn = $request->Lizenzbeginn;
        $lizenz->Lizenzende = $request->Lizenzende;
        $lizenz->Software = $request->Software;
        $lizenz->Lizenzstatus = $request->Lizenzstatus;

        $rechnungsPfad = $lizenz->Rechnungs_Pfad;


        if ($request->hasFile('Rechnung')) {
            if($rechnungsPfad != null) { // löschen der alten Rechnung
                Storage::delete($rechnungsPfad);
            }
            $rechnungsPfad = $request->file('Rechnung')->store('Rechnungen', 'local');
            $lizenz->Rechnungs_Pfad = $rechnungsPfad;
        }
        return $lizenz;

        $lizenz->save();

        return response()->json([
            'message' => 'Lizenz erfolgreich aktualisiert.',
        ]); */
    }

    public function delete($Lizenzschluessel)
    {
        $lizenz = Lizenz::where('Lizenzschluessel', $Lizenzschluessel)->first();
        $rechnungsPfad = $lizenz->Rechnungs_Pfad;
        if($rechnungsPfad != null) { // löschen der alten Rechnung
            Storage::delete($rechnungsPfad);
        }

        //n:m Beziehung löschen
        DB::table('computer_lizenz')->where('lizenzschluessel', $Lizenzschluessel)->delete();
        
        Lizenz::where('Lizenzschluessel', $Lizenzschluessel)->delete();

        return response()->json(['status' => 200, 'message' => 'Lizenz erfolgreich gelöscht.']);
        /* if ($lizenz && $lizenz->delete()) {
            return response()->json(['status' => 200, 'message' => 'Lizenz erfolgreich gelöscht.']);                             
        } else {
            return response()->json(['status' => 400, 'message' => 'Das Löschen der Lizenz fehlgeschlagen.']);
        } */    
    }

    public function viewRechnung($Lizenzschluessel)
    {
        //return $Lizenzschluessel;
        $lizenz = Lizenz::where('Lizenzschluessel', $Lizenzschluessel)->first();
        //return $lizenz;

        if (!$lizenz->Rechnungs_Pfad || !Storage::disk('local')->exists($lizenz->Rechnungs_Pfad)) {
            return response()->json([
                'status' => 404,
                'message' => 'Rechnung nicht gefunden.',
            ], 404);
        }

        $dateiPfad = $lizenz->Rechnungs_Pfad;
        $fileContents = Storage::disk('local')->get($dateiPfad);
        $mimeType = Storage::disk('local')->mimeType($dateiPfad);

        return response($fileContents, 200)->header('Content-Type', $mimeType);
    }
}

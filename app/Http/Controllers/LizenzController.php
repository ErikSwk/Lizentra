<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lizenz;
use App\Models\Computer;
use App\Models\ComputerLizenz;
use DB;

use Illuminate\Support\Facades\Storage;

class LizenzController extends Controller
{
    // Speichern einer neuen Lizenz
    public function store(Request $request, $sek_id, $PCID)
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
        $lizenz->sekretariat_id = $sek_id;

        $lizenz->MaxAnzahl = $request->MaxAnzahl;
        $lizenz->Anzahl = 1;

        $lizenz->Lizenzbeginn = $request->Lizenzbeginn;
        $lizenz->Lizenzende = $request->Lizenzende;
        $lizenz->Software = $request->Software;
        $lizenz->Lizenzstatus = $request->Lizenzstatus;
        $lizenz->Rechnungs_Pfad = $rechnungsPfad;

        $lizenz->save();

        // n:m beziehung
        $lizenz->computer()->attach($PCID, [
            'lizenzschluessel' => $lizenz->Lizenzschluessel,
        ]);

        return response()->json([
            'message' => 'Lizenz erfolgreich hinzugefügt!',
        ]);
    }

    // Hinzufügen einer bestehenden Lizenz
    public function exStore(Request $request, $sek_id, $PCID)
    {
        $request->validate([
            'Lizenzschluessel' => 'required|string',
        ]);


        $lizenz = Lizenz::where('Lizenzschluessel', $request->Lizenzschluessel)->first();

        if ($lizenz->Anzahl >= $lizenz->MaxAnzahl) {
            return response()->json([
                'message' => 'Maximale Anzahl an Computern für diese Lizenz erreicht!',
            ]);
        }

        //Warum funktioniert diese Syntax schon wieder nicht
        /* $lizenz->Anzahl = ($lizenz->Anzahl+1);
        $lizenz->save(); */

        Lizenz::where('Lizenzschluessel', $request->Lizenzschluessel)->update([
            'Anzahl' => ($lizenz->Anzahl + 1),
        ]);

        // n:m beziehung
        $lizenz->computer()->attach($PCID, [
            'lizenzschluessel' => $lizenz->Lizenzschluessel,
        ]);

        return response()->json([
            'message' => 'Lizenz erfolgreich hinzugefügt!',
        ]);
    }


    // Abrufen aller Lizenzen
    public function getAll()
    {
        $licenses = Lizenz::all();
        return response()->json([
            'status' => 200,
            'licenses' => $licenses,
        ]);
    }

    // Abrufen einer spezifischen Lizenz
    public function edit($LizenzID)
    {
        $lizenz = Lizenz::where('LizenzID', $LizenzID)->first();
        if ($lizenz) {
            return response()->json([
                'status' => 200,
                'lizenz' => $lizenz,
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Lizenz nicht gefunden.',
            ]);
        }
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

    }



    // Löschen einer Lizenz
    public function delete($Lizenzschluessel, $PCID)
    {
        $lizenz = Lizenz::where('Lizenzschluessel', $Lizenzschluessel)->first();
        /* $rechnungsPfad = $lizenz->Rechnungs_Pfad;
        if($rechnungsPfad != null) { // löschen der alten Rechnung
            Storage::delete($rechnungsPfad);
        } */

        Lizenz::where('Lizenzschluessel', $Lizenzschluessel)->update([
            'Anzahl' => ($lizenz->Anzahl - 1),
        ]);

        // Hier nur n:m Beziehung löschen aber Lizenz nicht
        DB::table('computer_lizenz')->where('lizenzschluessel', $Lizenzschluessel)->where('computer_id', $PCID)->delete();

        return response()->json(['status' => 200, 'message' => 'Lizenz erfolgreich entfernt.']);
    }

    public function getByPC($PCID)
    {
        $computer = Computer::with('lizenzen')->find($PCID);
        $lizenzen = $computer->lizenzen;
        //$licenses = Lizenz::where('PCID', $PCID)->get();

        if ($lizenzen->isEmpty()) {
            return response()->json([
                'status' => 404,
                'message' => 'Keine Lizenz für diesen Computer gefunden.',
            ]);
        }

        return response()->json([
            'status' => 200,
            'licenses' => $lizenzen,
        ]);
    }

    public function viewByPC($sek_id, $PCID)
    {
        //$licenses = Lizenz::where('PCID', $PCID)->get();

        return view('licenses.viewByPC', [
            //'licenses' => $licenses,
            'sek_id' => $sek_id,
            'PCID' => $PCID
        ]);
    }

    public function viewRechnung($LizenzID)
    {
        $license = Lizenz::where('Lizenzschluessel', $LizenzID)->first();

        if (!$license->Rechnungs_Pfad || !Storage::disk('local')->exists($license->Rechnungs_Pfad)) {
            return response()->json([
                'status' => 404,
                'message' => 'Rechnung nicht gefunden.',
            ], 404);
        }

        $filePath = $license->Rechnungs_Pfad;
        $fileContents = Storage::disk('local')->get($filePath);
        $mimeType = Storage::disk('local')->mimeType($filePath);

        return response($fileContents, 200)->header('Content-Type', $mimeType);
    }

}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sekretariat;

class SekretariatController extends Controller
{
    // Alle Sekretariate abrufen
    public function getAll()
    {
        $sekretariate = Sekretariat::all();
        return response()->json([
            'status' => 200,
            'sekretariate' => $sekretariate
        ]);
    }

    // Neues Sekretariat speichern
    public function store(Request $request)
    {
        $request->validate([
            'SekretariatID' => 'required|unique:sekretariat,SekretariatID',
            'Lehrstuhl' => 'required',
            'Email' => 'required|email',
            'Fakultät' => 'required',
        ]);

        $sekretariat = new Sekretariat();
        $sekretariat->SekretariatID = $request->SekretariatID;
        $sekretariat->Lehrstuhl = $request->Lehrstuhl;
        $sekretariat->Email = $request->Email;
        $sekretariat->Fakultät = $request->Fakultät;
        $sekretariat->save();

        return response()->json([
            'status' => 200,
            'message' => 'Sekretariat erfolgreich hinzugefügt.',
        ]);
    }

    // Sekretariat aktualisieren
    public function update(Request $request)
    {
        $request->validate([
            'SekretariatID' => 'required|exists:sekretariat,SekretariatID',
            'Lehrstuhl' => 'required',
            'Email' => 'required|email',
            'Fakultät' => 'required',
        ]);

        $sekretariat = Sekretariat::where('SekretariatID', $request->SekretariatID)->first();
        $sekretariat->Lehrstuhl = $request->Lehrstuhl;
        $sekretariat->Email = $request->Email;
        $sekretariat->Fakultät = $request->Fakultät;
        $sekretariat->save();

        return response()->json([
            'status' => 200,
            'message' => 'Sekretariat erfolgreich aktualisiert.',
        ]);
    }

    // Sekretariat löschen
    public function destroy(Request $request)
    {
        $request->validate([
            'SekretariatID' => 'required|exists:sekretariat,SekretariatID',
        ]);

        $sekretariat = Sekretariat::where('SekretariatID', $request->SekretariatID)->first();

        if (!$sekretariat) {
            return response()->json([
                'status' => 404,
                'message' => 'Sekretariat nicht gefunden.',
            ]);
        }

        $sekretariat->delete();

        return response()->json([
            'status' => 200,
            'message' => 'Sekretariat erfolgreich gelöscht.',
        ]);
    }


    public function viewAlleSekretariate()
    {
        return view('admin.alleSekretariate');
    }

}
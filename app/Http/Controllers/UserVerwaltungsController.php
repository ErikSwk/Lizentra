<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Hash;

class UserVerwaltungsController extends Controller
{
    // Alle User abrufen
    public function getAll()
{
    $users = User::select('id', 'name', 'email', 'buero', 'SekretariatID')->where('role', 'user')->where('approved', True)->get();

    return response()->json([
        'status' => 200,
        'User' => $users,
    ]);
}


    public function getAllUserZumFreischalten()
    {
        $users = User::where('approved', False)->get();
        return response()->json([
            'status' => 200,
            'UserFreischalten' => $users,
        ]);
    }

    // Neuen User speichern
    public function store(Request $request)
    {
        try {
            $request->validate([
                'Name' => 'required',
                'Email' => 'required|email',
                'Buero' => 'required',
                'password' => 'required|confirmed|min:8',
                'password_confirmation' => 'required',
                'SekretariatID' => 'nullable|exists:sekretariat,SekretariatID',
            ], [
                'SekretariatID.exists' => 'Das Sekretariat existiert nicht.', // Benutzerdefinierte Nachricht
            ]);

            $user = new User();
            $user->name = $request->Name;
            $user->email = $request->Email;
            $user->password = Hash::make($request->password);
            $user->buero = $request->Buero;
            $user->status = 'active';
            $user->approved = True;
            $user->SekretariatID = $request->SekretariatID;
            $user->save();

            return response()->json([
                'status' => 200,
                'message' => 'User erfolgreich hinzugefügt.',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'status' => 422,
                'errors' => $e->errors(), // Gibt die Validierungsfehler zurück
            ], 422);
        }
    }


    // User aktualisieren
    public function update(Request $request)
    {
        try {
            $request->validate([
                'Name' => 'required',
                'Email' => 'required|email',
                'Buero' => 'required',
                'password' => 'nullable|confirmed|min:8',
                'password_confirmation' => 'nullable',
                'SekretariatID' => 'nullable|exists:sekretariat,SekretariatID',
            ], [
                'SekretariatID.exists' => 'Das Sekretariat existiert nicht.', // Benutzerdefinierte Nachricht
            ]);

            $user = User::where('id', $request->ID)->first();
            $user->name = $request->Name;
            $user->email = $request->Email;
            if ($request->filled('password')) { // Nur Passwort aktualisieren, wenn es übergeben wird
                $user->password = Hash::make($request->password);
            }
            $user->buero = $request->Buero;
            $user->status = $request->Status;
            $user->SekretariatID = $request->SekretariatID;
            $user->save();

            return response()->json([
                'status' => 200,
                'message' => 'User erfolgreich aktualisiert.',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'status' => 422,
                'errors' => $e->errors(), // Gibt die Validierungsfehler zurück
            ], 422);
        }
    }


    // User löschen
    public function destroy(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:users,id', // Stellt sicher, dass die ID vorhanden ist
        ]);

        $user = User::find($request->id); // Findet den Benutzer anhand der ID

        if (!$user) {
            return response()->json([
                'status' => 404,
                'message' => 'User nicht gefunden.',
            ]);
        }

        $user->delete(); // Löscht den Benutzer

        return response()->json([
            'status' => 200,
            'message' => 'User erfolgreich gelöscht.',
        ]);
    }

    public function freischalten(Request $request)
    {
        $user = User::where('id', $request->ID)->first();
        $user->approved = True;
        $user->save();

        return response()->json([
            'status' => 200,
            'message' => 'User erfolgreich freigeschaltet.',
        ]);
    }

}


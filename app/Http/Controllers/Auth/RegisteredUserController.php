<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use App\Mail\AdminNeuerBenutzerMail;
use Illuminate\Support\Facades\Mail;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        // Validierung der Benutzereingaben
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'buero' => ['required', 'string', 'max:255'],
            'SekretariatID' => ['required', 'string', 'max:255'], // Validation für SekretariatID
        ]);

        // Prüfen, ob die SekretariatID existiert
        $sekretariatExists = \App\Models\Sekretariat::where('SekretariatID', $request->SekretariatID)->exists();

        if (!$sekretariatExists) {
            // Fehler zurückgeben, wenn die SekretariatID nicht existiert
            return redirect()->back()
                ->withErrors(['SekretariatID' => 'Das Sekretariat existiert nicht.'])
                ->withInput();
        }

        // Neuen Benutzer erstellen
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'buero' => $request->buero,
            'SekretariatID' => $request->SekretariatID, // Hier speichern
        ]);

        event(new Registered($user));

        //$empfänger = 'finn.manegold@stud.uni-goettingen.de'; // hier hardcoded der Admin Empfänger, auch Array mögllich

        //Mail::to($empfänger)->send(new AdminNeuerBenutzerMail());

        Auth::login($user);

        return redirect(route('home', absolute: false));
    }
}
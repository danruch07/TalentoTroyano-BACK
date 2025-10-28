<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\User;
use Carbon\Carbon;

class PasswordController extends Controller
{
    public function showForgot() { return view('auth.forgot'); }

    public function sendLink(Request $request)
    {
        $request->validate(['email'=>'required|email:rfc']);
        $user = User::where('email',$request->email)->first();

        if (!$user) {
            return back()->with('status','Si el correo existe, se enviará un enlace de restablecimiento.');
        }

        $token = Str::random(64);
        DB::table('password_reset_tokens')->updateOrInsert(
            ['email'=>$user->email],
            ['token'=>hash('sha256',$token), 'created_at'=>now()]
        );

        // Aquí se envia correo real (SMTP). Para demo, mostramos el enlace:
        return back()->with('status', 'Usa este enlace temporal (demo): ' . url('/reset-password?email=' . urlencode($user->email) . '&token=' . $token));
    }

    public function showReset(Request $request)
    {
        $request->validate([
            'email' => 'required|email:rfc',
            'token' => 'required|string'
        ]);
        return view('auth.reset', ['email'=>$request->email, 'token'=>$request->token]);
    }

    public function reset(Request $request)
    {
        $request->validate([
            'email'    => 'required|email:rfc',
            'token'    => 'required|string',
            'password' => 'required|string|min:8|confirmed'
        ]);

        $row = DB::table('password_reset_tokens')->where('email',$request->email)->first();
        if (!$row) return back()->withErrors(['email'=>'Token inválido o expirado.']);

        // valida token y expiración (60 min)
        if (!hash_equals($row->token, hash('sha256',$request->token))) {
            return back()->withErrors(['email'=>'Token inválido.']);
        }
        if (Carbon::parse($row->created_at)->diffInMinutes(now()) > 60) {
            return back()->withErrors(['email'=>'Token expirado.']);
        }

        $user = User::where('email',$request->email)->firstOrFail();
        $user->password = Hash::make($request->password);
        $user->save();

        DB::table('password_reset_tokens')->where('email',$request->email)->delete();

        return redirect('/login')->with('success','Contraseña actualizada. Inicia sesión.');
    }
}

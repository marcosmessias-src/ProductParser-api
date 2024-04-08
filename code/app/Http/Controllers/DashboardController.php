<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function dashboard(Request $request){
        $user = $request->user();

        foreach($user->tokens as $token){
            $token->delete();
        }

        $token = explode('|', $user->createToken('API Token')->plainTextToken)[1];

        return view('dashboard', compact('token'));
    }
}

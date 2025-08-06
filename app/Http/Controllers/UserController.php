<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function checkUser($id) {
        $exists = User::where('id', $id)->exists();

        return response()->json(['exists' => $exists]);
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Secret;

class SecretController extends Controller
{
    public function index(Request $request)
    {
        return $request->user()->secrets();
    }
}

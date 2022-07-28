<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\CalculatorService;

class CalculatorController extends Controller
{
    public function index()
    {
        return view('interface');
    }

    public function acceptInput(Request $request)
    {
        $equation = $request->input('keypad-input');
        $type = $request->input('equation-type');
        return json_encode(CalculatorService::calculate($equation, $type));
    }
}

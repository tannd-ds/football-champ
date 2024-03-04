<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class SeasonController extends Controller
{ 
    public function index()
    {
        $all_season = DB::table('season')->get();
        return response()->json($all_season);
    }
}

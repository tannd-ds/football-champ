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

    public function add(Request $request)
    {
        try {
            $season = $request->input('id');
            $start_date = $request->input('start_date');
            $end_date = $request->input('end_date');

            // turn the dates into the format that the database expects
            $start_date = date('Y-m-d', strtotime($start_date));
            $end_date = date('Y-m-d', strtotime($end_date));

            $data = array('id' => $season, 'start_day' => $start_date, 'end_day' => $end_date);
            DB::table('season')->insert($data);
            return response()->json('Season added successfully');
        
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to add season: ' . $e->getMessage()], 500);
        }
    }

}

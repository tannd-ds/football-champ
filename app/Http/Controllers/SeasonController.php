<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class SeasonController extends Controller
{  
    // Trang xem
    public function index()
    {
        $all_season = DB::table('season')->get();
        return response()->json($all_season);
    }
    // Add be
    public function add(Request $request)
    {
        try {
            $season_name = $request->input('season_name');
            $start_date = $request->input('start_date');
            $end_date = $request->input('end_date');
            $quantity = $request->input('quantity');
            // turn the dates into the format that the database expects
            $start_date = date('Y-m-d', strtotime($start_date));
            $end_date = date('Y-m-d', strtotime($end_date));

            $data = array('name_season' => $season_name, 'start_day' => $start_date, 'end_day' => $end_date, 'quantity_team'=> $quantity);
            DB::table('season')->insert($data);
            return response()->json('Season added successfully');
        
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to add season: ' . $e->getMessage()], 500);
        }
    }
    // Trang chỉnh sửa
    public function edit_season($id)
    {
        $edit_season = DB::table('season')->where('id', $id)->get();
        return response()->json($edit_season);
    }
    // Update be
    public function update(Request $request, $id){
        try {
        $season_name = $request->input('season_name');
        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');
        $quantity = $request->input('quantity');
        // turn the dates into the format that the database expects
        $start_date = date('Y-m-d', strtotime($start_date));
        $end_date = date('Y-m-d', strtotime($end_date));

        $data = array('name_season' => $season_name, 'start_day' => $start_date, 'end_day' => $end_date, 'quantity_team'=> $quantity);
        DB::table('season')->where('id', $id)->update($data);
        return response()->json('Season update successfully');
    } catch (\Exception $e) {
        return response()->json(['error' => 'Failed to update season: ' . $e->getMessage()], 500);
    }

    }
    // Delete be
    public function delete($id){
        try{
        DB::table('season')->where('id', $id)->delete();
    return response()->json('Season delete successfully');
}
catch(\Exception $e){
    return response()->json(['error' => 'Failed to delete season: ' . $e->getMessage()], 500);    }
    }
}

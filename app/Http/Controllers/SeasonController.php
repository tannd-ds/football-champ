<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class SeasonController extends Controller
{  
    // Trang xem toàn bộ mùa giải
    public function index()
    {
        $all_season = DB::table('season')->get();
        return response()->json($all_season);
    }
    // Add new season
    public function add(Request $request)
    {
        try {
            $season_name = $request->input('name_season');
            $start_date = $request->input('start_date');
            $end_date = $request->input('end_date');
            $quantity = $request->input('quantity_team');
            // turn the dates into the format that the database expects
            $start_date = date('Y-m-d', strtotime($start_date));
            $end_date = date('Y-m-d', strtotime($end_date));

            $data = array('name_season' => $season_name, 'start_date' => $start_date, 'end_date' => $end_date, 'quantity_team'=> $quantity);
            DB::table('season')->insert($data);
            return response()->json('Season added successfully', 200);
        
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
    // Update funtion
    public function update(Request $request, $id){
        try {
        $season_name = $request->input('name_season');
        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');
        $quantity = $request->input('quantity_team');
        // turn the dates into the format that the database expects
        $start_date = date('Y-m-d', strtotime($start_date));
        $end_date = date('Y-m-d', strtotime($end_date));

        $data = array(
            'name_season' => $season_name, 
            'start_date' => $start_date, 
            'end_date' => $end_date, 
            'quantity_team'=> $quantity
        );
        DB::table('season')->where('id', $id)->update($data);
        return response()->json('Season update successfully');
    } catch (\Exception $e) {
        return response()->json(['error' => 'Failed to update season: ' . $e->getMessage()], 500);
    }

    }
    // Delete season
    public function delete($id){
        try{
            $Schedule= DB::table('schedule')->join('detailschedule','detailschedule.schedule_id','=','schedule.id')->select('schedule.id')->where('schedule.season_id',$id)->get();
            foreach($Schedule as $item){
                DB::table('detailschedule')->where('schedule_id', $item->id)->delete();
            }
        DB::table('season')->where('id', $id)->delete();
    return response()->json('Season delete successfully');
}
catch(\Exception $e){
    return response()->json(['error' => 'Failed to delete season: ' . $e->getMessage()], 500);    }
    }
}

<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use function Laravel\Prompts\table;

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
            $e = [
                'content'=> 'success',
                'code'=>200,
            ];
            return response()->json($e);}
            catch (\Exception $e) {
                $e = [
                    'content'=> 'fail',
                    'code'=>500,
                ];
                return response()->json($e);
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
        $e = [
            'content'=> 'success',
            'code'=>200,
        ];
        return response()->json($e);}
        catch (\Exception $e) {
            $e = [
                'content'=> 'fail',
                'code'=>500,
            ];
            return response()->json($e);
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
        $e = [
            'content'=> 'success',
            'code'=>200,
        ];
        return response()->json($e);}
        catch (\Exception $e) {
            $e = [
                'content'=> 'fail',
                'code'=>500,
            ];
            return response()->json($e);
        }
    }
    // Season activite
    public function register_season()
    {   $now = date('y-m-d');
        $data = DB::table('season')->where('start_date','>',$now)->get();
        return response()->json($data);
    }
    // Register season
    public function register_into_season(Request $request){
        try {
            $team_id = $request->input('team_id');
            $season_id = $request->input('season_id');
            $date_signin = $request->input('date_signin');
            $status = $request->input('status');

            $quantity_team = DB::table('detailteam')->select('quantity_soccer')->where('id', $team_id)->first();
            if ($quantity_team && isset($quantity_team->quantity_soccer) && $quantity_team->quantity_soccer >= 15 && $quantity_team->quantity_soccer <= 20) {
                $data = array('season_id' => $season_id, 'team_id' => $team_id, 'date_signin' => $date_signin,'status' => $status);
                DB::table('listteam')->insert($data);
                $reponse=[
                    'content'=> 'succes',
                    'code' => 200,
                ];
                return response()->json($reponse);
            } else {
                $reponse=[
                    'content'=> 'Số lượng cầu thủ phải trong khoảng 15 tới 20',
                    'code' => 500,
                ];
                return response()->json($reponse);
            }
        } catch (\Exception $e) {
            $e=[
                'content'=> 'Fail',
                'code' => 500,
            ];
            return response()->json($e);
        }

    }
    
}

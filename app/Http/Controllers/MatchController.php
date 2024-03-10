<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\JsonResponse;
class MatchController extends Controller
{   
    // Show match of season
    public function index($id){
        $schedule=DB::table('schedule')->where('season_id',$id)->get();
        $team_1=DB::table('detailteam')->join('schedule','detailteam.id','=','schedule.team_id_1')->select('detailteam.name_team')->where('schedule.season_id',$id)->get();
        $team_2=DB::table('detailteam')->join('schedule','detailteam.id','=','schedule.team_id_2')->select('detailteam.name_team')->where('schedule.season_id',$id)->get();
        $responseData = [
            'schedule' => $schedule,
            'team_1' => $team_1,
            'team_2' => $team_2,
        ];
        return response()->json($responseData);
    }
    // List team of season
    public function list_team_season($id){
        $list=DB::table('listteam')->join('detailteam','detailteam.id','=','listteam.team_id')->join('result','result.team_id','=','listteam.team_id')->where('listteam.season_id',$id)->get();
        return response()->json($list);
    }
    
    public function add(Request $request){ 
         try{
        $season_id=$request->input('season_id');
        $date=$request->input('date');
        $team_id_1=$request->input('team_id_1');
        $team_id_2=$request->input('team_id_2');
        $data = array('season_id' => $season_id, 'date' => $date, 'team_id_1' => $team_id_1, 'team_id_2'=> $team_id_2);
        DB::table('schedule')->insert($data);
        return response()->json('Match added successfully', 200);} 
        catch (\Exception $e) {
            return response()->json(['error' => 'Failed to add match: ' . $e->getMessage()], 500);
        }
    }

    public function edit_match($id){
        $match= DB::table('schedule')->where('id',$id)->get();
        return response()->json($match);
    }
    public function update(Request $request,$id){
        try{
            $season_id=$request->input('season_id');
            $date=$request->input('date');
            $team_id_1=$request->input('team_id_1');
            $team_id_2=$request->input('team_id_2');
            $data = array('season_id' => $season_id, 'date' => $date, 'team_id_1' => $team_id_1, 'team_id_2'=> $team_id_2);
            DB::table('schedule')->where('id',$id)->update($data);
            return response()->json('Match update successfully', 200);} 
            catch (\Exception $e) {
                return response()->json(['error' => 'Failed to update match: ' . $e->getMessage()], 500);
            }
    }
    public function delete($id){
        try{
        DB::table('schedule')->where('id',$id)->delete();
        return response()->json('Match delete successfully', 200);      } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to delete match: ' . $e->getMessage()], 500);
        }
    }

}

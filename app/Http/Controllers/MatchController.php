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
    public function delete($id){
        try{
        DB::table('schedule')->where('id',$id)->delete();
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
    
    // Chi tiết trận đấu 
    public function detailmatch($id){
        $data = DB::table('detailschedule')->join('detailteam','detailteam.id','=','detailschedule.team_id')->join('soccer','soccer.id','=','detailschedule.soccer_id')->where('detailschedule.schedule_id',$id)->get();
        return response()->json($data);
    }

    public function add_detailmatch (Request $request){
        try{
            $schedule_id=$request->input('schedule_id');
            $soccer_id=$request->input('soccer_id');
            $team_id=$request->input('team_id');
            $category_goal=$request->input('category_goal');
            $time_goal = $request -> input('time_goal');
            $data = array('schedule_is' => $schedule_id, 'soccer_id' => $soccer_id, 'team_id' => $team_id, 'category_goal'=> $category_goal , 'time_goal' => $time_goal);
            DB::table('detailschedule')->insert($data);
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
    public function delete_detailmatch($id){
        try{
        DB::table('detailschedule')->where('id',$id)->delete();
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

    

}

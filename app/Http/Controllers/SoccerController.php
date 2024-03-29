<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SoccerController extends Controller
{   
    // Show soccer
    public function index(){
        $player=DB::table('soccer')->get();
        return response()->json($player);
    }
    //Add soccer
    public function add(Request $request)
    {
        try {
            $name_soccer = $request->input('name_soccer');
            $birthday = $request->input('birthday');
            $category = $request->input('category');
            $team_id = $request->input('team_id');

            // turn the dates into the format that the database expects
            

            $data = array('name_soccer' => $name_soccer, 'birthday' => $birthday, 'category' => $category, 'team_id'=> $team_id);
            DB::table('soccer')->insert($data);
            return response()->json('Soccer added successfully', 200);
        
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to add soccer: ' . $e->getMessage()], 500);
        }
    }
    //edit
    public function edit_soccer($id){
        $soccer = DB::table('soccer')->leftjoin('detailteam','soccer.team_id','=','detailteam.id')->where('soccer.id',$id)->get();
        return response()->json($soccer);
    }
    //update
    public function update(Request $request,$id){
        try {
            $name_soccer = $request->input('name_soccer');
            $birthday = $request->input('birthday');
            $category = $request->input('category');
            $team_id = $request->input('team_id');

            // turn the dates into the format that the database expects
            

            $data = array('name_soccer' => $name_soccer, 'birthday' => $birthday, 'category' => $category, 'team_id'=> $team_id);
            DB::table('soccer')->where('id',$id)->update($data);
            return response()->json('Soccer update successfully', 200);
        
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to update soccer: ' . $e->getMessage()], 500);
        }

    }
    //delete
    public function ban($id){
        try{ 
            $data = array('status'=> 0);
            DB::table('soccer')->where('id',$id)->update($data);
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
public function unban($id){
    try{ 
        $data = array('status'=> 1);
        DB::table('soccer')->where('id',$id)->update($data);
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
        $data = array('team_id'=> null);
        DB::table('soccer')->where('id',$id)->update($data);
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

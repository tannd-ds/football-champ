<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SoccerController extends Controller
{   
    // Hiển thị
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
        $soccer =DB::table('soccer')->join('detailteam','soccer.team_id','=','detailteam.id')->where('soccer.id',$id)->get();
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
    public function delete($id){
        DB::table('soccer')->where('id',$id)->delete();
        return response()->json('Soccer delete successfully', 200);    }

}

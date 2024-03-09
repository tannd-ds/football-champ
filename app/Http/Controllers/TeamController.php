<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class TeamController extends Controller
{
    //show team
    public function index(){
        $teams = DB::table('detailteam')->get();
        return response()->json($teams);
    }
    // show soccer team
    public function show_team($id){

    }
    //add team
    public function add(Request $request)
    {
        try {
            $name_team= $request->input('name_team');
            $quantity_soccer = $request -> input('quantity_soccer');
            $established_date = $request -> input('established_date');
            $home_court = $request-> input('home_court');
            $url_image= $request->file('url_image');
            // $get_name_image = $url_image->getClientOriginalName();
            // $name_image = current(explode('.',$get_name_image));
            // $new_image =  $name_image.rand(0,99).'.'.$url_image->getClientOriginalExtension();
            // $url_image->move('public/uploads/team',$new_image);

            $data = array('name_team' => $name_team, 'quantity_soccer' => $quantity_soccer, 'established_date' => $established_date, 'home_court'=> $home_court ,'url_image' => $url_image);
            DB::table('detailteam')->insert($data);
            return response()->json('Team added successfully', 200);
        
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to add Team: ' . $e->getMessage()], 500);
        }
    }
    //edit team
    public function edit_team($id)
    {
        $edit_team = DB::table('detailteam')->where('id', $id)->get();
        return response()->json($edit_team);
    }
    //update team
    public function update(Request $request, $id){
        try {
            $name_team= $request->input('name_team');
            $quantity_soccer = $request -> input('quantity_soccer');
            $established_date = $request -> input('established_date');
            $home_court = $request-> input('home_court');
            $url_image= $request->file('url_image');
            $data = array('name_team' => $name_team, 'quantity_soccer' => $quantity_soccer, 'established_date' => $established_date, 'home_court'=> $home_court ,'url_image' => $url_image);
            DB::table('detailteam')->where('id',$id)->update($data);
            return response()->json('Team update successfully', 200);
        
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to update Team: ' . $e->getMessage()], 500);
        }
    }
    public function delete($id){
        DB::table('soccer')->where('team_id',$id)->delete();
        DB::table('detailteam')->where('id',$id)->delete();
        return response()->json('Team delete successfully', 200);    }
}

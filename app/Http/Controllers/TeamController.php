<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class TeamController extends Controller
{
    public function index(){
        $teams = DB::table('detailteam')->get();
        return response()->json($teams);
    }
    public function add(Request $request)
    {
        try {
            $name_team= $request->input('name_team');
            $quantity_soccer = $request -> input('quantity_soccer');
            $established_date = $request -> input('established_date');
            $home_court = $request-> input('home_court');
            $url_image= $request->file('url_image');
                $get_name_image = $url_image->getClientOriginalName();
                $name_image = current(explode('.',$get_name_image));
                $new_image =  $name_image.rand(0,99).'.'.$url_image->getClientOriginalExtension();
                $url_image->move('public/uploads/team',$new_image);

            $data = array('name_team' => $name_team, 'quantity_soccer' => $quantity_soccer, 'established_date' => $established_date, 'home_court'=> $home_court ,'url_image' => $new_image);
            DB::table('detailteam')->insert($data);
            return response()->json('Team added successfully', 200);
        
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to add Team: ' . $e->getMessage()], 500);
        }
    }
}

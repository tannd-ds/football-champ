<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\JsonResponse;

class RegistrationFormController extends Controller
{   // show all register form 
    public function index(){
     $all_register  = DB::table('listteam')->join('season','season.id','=','listteam.season_id')->join('detailteam','detailteam.id','=','listteam.team_id')->where('listteam.status', 0)->get();
        return response()->json($all_register);
       }
    // Accept register
    public function accept($id){
        try{
        $Data= array('status'=>1);
        DB::table('listteam')->where('id',$id)->update($Data);
        return response()->json('Success',200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed' . $e->getMessage()], 500);
        }

    }
    //refuse
    public function refuse($id){
        try{
        $Data= array('status'=>2);
        DB::table('listteam')->where('id',$id)->update($Data);
        return response()->json('Success',200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed' . $e->getMessage()], 500);
        }

    }
}

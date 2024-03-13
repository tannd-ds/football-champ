<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class UserController extends Controller
{   
    //login
    public function login(Request $request){
        $user_email = $request -> input('user_email');
        $user_password = $request -> input('user_password');
        $user = DB::table('user')->where('user_email',$user_email)->Where('user_password',$user_password)->first();
        if(empty($user)){
            $e = [
                'content'=> 'Tài khoản hoặc mật khẩu không chính xác',
                'code'=>500,
            ];
           
            return response()->json($e);
        }
        else{
            $e = [
                'content' => $user,
                'code' => 200,
            ];
            return response()->json($e);
        }
    }

    public function register(Request $request){
        try {
        $user_name = $request -> input('user_name');
        $user_email = $request -> input('user_email');
        $user_password = $request -> input('user_password');
            $check = DB::table('user')->where('user_email',$user_email)->get();
            if(empty($check)){
                $e = [
                    'content'=> 'Tài khoản đã tồn tại',
                    'code'=>500,
                ];
                return response()->json($e);
            }
            else{
        $data = array('user_name' => $user_name, 'user_email' => $user_email, 'user_password' => $user_password );
            DB::table('user')->insert($data);
            $e = [
                'content'=> 'success',
                'code'=>200,
            ];
            return response()->json($e);}
            
        }
            catch (\Exception $e) {
                $e = [
                    'content'=> 'fail',
                    'code'=>500,
                ];
                return response()->json($e);
            }
}
        public function index(){
            $data = DB::table('user')->where('rule', 1)->get();
            return response()->json($data);
        }
        public function edit_user($id){
            $data = DB::table('user')->where('id', $id)->get();
            return response()->json($data);
        }
        public function update(Request $request,$id)
        {
            try {
                $user_name = $request -> input('user_name');
                $user_password = $request -> input('user_password');
                $team_id = $request -> input('team_id');
                $check_team = DB::table('user')->wher('team_id',$team_id)->get();
                if(empty($check_team)){ $e = [
                    'content'=> 'Đội này đã đăng kí tài khoản',
                    'code'=>200,
                ];
                return response()->json($e);}
                else{
                $data = array('user_name' => $user_name, 'user_password' => $user_password,'team_id' => $team_id );
                
                    DB::table('user')->where('id',$id)->update($data);
                    $e = [
                        'content'=> 'success',
                        'code'=>200,
                    ];
                    return response()->json($e);}}
                    catch (\Exception $e) {
                        $e = [
                            'content'=> 'fail',
                            'code'=>500,
                        ];
                        return response()->json($e);
                    }
        }
        //create team
    public function create_team(Request $request, $id)
    {
        try {
            $name_team= $request->input('name_team');
            $established_date = $request -> input('established_date');
            $home_court = $request-> input('home_court');
            $url_image= $request->file('url_image');
            // $get_name_image = $url_image->getClientOriginalName();
            // $name_image = current(explode('.',$get_name_image));
            // $new_image =  $name_image.rand(0,99).'.'.$url_image->getClientOriginalExtension();
            // $url_image->move('public/uploads/team',$new_image);

            $data = array('name_team' => $name_team, 'established_date' => $established_date, 'home_court'=> $home_court ,'url_image' => $url_image);
            $team_id = DB::table('detailteam')->insertGetId($data);
            $user_team_id =array('team_id'=>$team_id);
            DB::table('user')->where('id',$id)->update($user_team_id);
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

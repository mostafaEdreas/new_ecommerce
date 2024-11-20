<?php

namespace App\Http\Controllers\Api;

use App\User;
use File;
use Mail;
use Image;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Str;
use Twilio\Rest\Client;
use Hash;


use App\Http\Resources\UserResource;

class UserController extends Controller
{
        
    public function authenticate(Request $request)
    {

        if(is_numeric($request->get('email'))){
            $credentials= ['phone'=>$request->get('email'),'password'=>$request->get('password')];
        }
        elseif (filter_var($request->get('email'), FILTER_VALIDATE_EMAIL)) {
            $credentials= ['email' => $request->get('email'), 'password'=>$request->get('password')];
        }

        try {
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json(['message'=>trans('messages.invalid_credentials'),'statusCode'=>400]);
            }
        } catch (JWTException $e) {
            return response()->json(['error' => 'could_not_create_token'], 500);
        }
        $user = JWTAuth::user($token);
        
        if($user->status == 'active'){
            $user ->remember_token = $request->token;
            $user ->device_type = $request->device_type;
            $user ->save();
    
            $user = new UserResource ($user);
            return response()->json(['userData'=>$user,'token'=>$token,'message'=>trans('messages.user authenticated'),'statusCode'=>200]);
    
        }else{
            return response()->json(['message'=>trans('messages.account no verified yet'),'statusCode'=>204]);
        }
    }
    
    public function refreshToken(Request $request){        
        try{
            $user = User::where('email',$request->email)->orwhere('phone',$request->email)->first();
            if($user) {
                $token = JWTAuth::fromUser($user);
                return response()->json(compact('token'));
            }else{
                return response()->json(['error' => 'invalid_credentials'], 400);
            }
        }catch(JWTException $e) {
            return response()->json(['error' => 'could_not_create_token'], 500);
        }       
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'required|string|unique:users',
            'country_id' => 'required|int',
            'password' => 'required|string|min:6|confirmed',
            'token'=>'required|string',
        ]);

        if($validator->fails()){
           //return response()->json($validator->errors(), 400);

            // $errors = $validator->errors();
            // dd($errors);
            // foreach ($errors->all() as $message) {
            //     dd($message);
            //     $error[] =  trans("messages.$message");
            // }
            return response()->json(['message'=>trans('messages.error entering data'),'errors'=>$validator->errors(),'statusCode'=>400]);
        }
        
        $user = new User();
        $user->name = $request->name ;
        $user->email = $request->email ;
        $user->phone = $request->phone ;
        $user->password = Hash::make($request->password) ;
        $user->remember_token = $request->token ;
        $user->country_id = $request->country_id ;
        $user->region_id = $request->region_id ;
        $user->area_id = $request->area_id ;
        $user->device_type = $request->device_type ;
        if($request->status){
            $user->status = $request->status ;
        }else{
            $user->status = 'inactive' ;
        }
        if($request->is_admin){
            $user->is_admin =$request->is_admin ;
        }else{
            $user->is_admin = 0 ;
        }
        $user->verification_code = mt_rand(100000, 999999);
        $user->remember_token = $request->token;
        $user->save();
 
        $token = JWTAuth::fromUser($user);

        $this->sendVerificationCode($user);

        $user = new UserResource ($user);        
        
        return response()->json(['message'=>trans('messages.new user registered verfication code will be sent in a few seconds'),'statusCode'=>201]);
    }

    //////////// send verfication code//////////
    public function sendVerificationCode($user){

        $sid = 'ACe22b2d0298ab93d6356d071af8e275e1';
        $token = '51f27ff7c5b1ed36f37041daedc1f4d5';
        $client = new Client($sid, $token);

        // Use the client to do fun stuff like send text messages!
        $client->messages->create(
            // the number you'd like to send the message to
            '+2'.$user->phone,
            [
                // A Twilio phone number you purchased at twilio.com/console
                'from' => '+14159914443',
                // the body of the text message you'd like to send
                'body' => 'كود التفعيل الخاص بك'.$user->verification_code,
            ]
        );

    }

    public function accountVerfication(Request $request){        
        try{
            $user = User::where('phone',$request->phone)->where('verification_code',$request->code)->first();
            if($user){
                $user->verification_code = mt_rand(100000, 999999);
                $user->status ='active';
                $user->save();
                $token = JWTAuth::fromUser($user);
                $user = new UserResource ($user);
                return response()->json(['userData'=>$user,'token'=>$token,'message'=>trans('messages.account verfied successfully'),'statusCode'=>200]);

            }else{
                return response()->json(['message'=>trans('messages.phone and verfication code not valid'),'statusCode'=>400]);
            }
        }catch(\Exception $e){
            return response()->json(['message'=>trans('messages.Exception Error Found Try Again Later !'),'statusCode'=>500]);
        }
    }


    public function resetPasswordVerfication(Request $request){
        try{
            $user = User::where('phone',$request->phone)->first();
            if($user){

                $this->sendVerificationCode($user);
                $user->status ='active';
                $user->save();

                return response()->json(['message'=>trans('messages.code sent successfully'),'statusCode'=>200]);

            }else{
                return response()->json(['message'=>trans('messages.phone not found'),'statusCode'=>400]);
            }
        }catch(\Exception $e){
            return response()->json(['message'=>trans('messages.Exception Error Found Try Again Later !'),'statusCode'=>500]);
        }
    }
    
    public function checkResetPasswordVerfication(Request $request){        
        try{
            $user = User::where('phone',$request->phone)->where('verification_code',$request->code)->first();
            if($user){
                $user->verification_code = mt_rand(100000, 999999);
                $user->status ='active';
                $user->save();
                return response()->json(['message'=>trans('messages.code and phone matached successfully'),'statusCode'=>200]);
            }else{
                return response()->json(['message'=>trans('messages.phone and verfication code not valid'),'statusCode'=>400]);
            }
        }catch(\Exception $e){
            return response()->json(['message'=>trans('messages.Exception Error Found Try Again Later !'),'statusCode'=>500]);
        }
    }


    public function resetPassword(Request $request){
        try{
            $user = User::where('phone',$request->phone)->first();
            $user->password = Hash::make($request->password);
            $user->save();

            return response()->json(['message'=>trans('messages.password changed successfully'),'statusCode'=>200]);
        }catch(\Exception $e) {
            return response()->json(['message'=>'account not found','statusCode'=>404]);
        }
    }

    public function changePassword(Request $request){
        try{
            
            $token = $request->bearerToken();
            if($token){
                $user = JWTAuth::toUser($token);
            }

            if (Hash::check($request->old_password, $user->password) ) {
               $user->password = Hash::make($request->password);
               $user->save();
               return response()->json(['message'=>trans('messages.password changed successfully'),'statusCode'=>200]);

            }else{
                return response()->json(['message'=>trans('messages.old password is incorrect'),'statusCode'=>404]);
            }            
        }catch(\Exception $e) {
            return response()->json(['message'=>trans('messages.Exception Error Found Try Again Later !'),'statusCode'=>500]);
        }
    }

    public function removeUser(request $request){
        try{
            $user = User::where('phone',$request->phone)->first();

            if ($user) {
               $user->delete();
               return response()->json(['message'=>trans('messages.user deleted successfully'),'statusCode'=>200]);

            }else{
                return response()->json(['message'=>trans('messages.no user found with this number'),'statusCode'=>200]);

            }            
        }catch(\Exception $e) {
            dd($e);
            return response()->json(['message'=>'account not found','statusCode'=>404]);
        }
    }


    public function getAuthenticatedUser()
    {
        try {

            if (! $user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['user_not_found'], 404);
            }

        } catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {

            return response()->json(['token_expired'], $e->getStatusCode());

        } catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {

            return response()->json(['token_invalid'], $e->getStatusCode());

        } catch (Tymon\JWTAuth\Exceptions\JWTException $e) {

            return response()->json(['token_absent'], $e->getStatusCode());

        }
        $token = JWTAuth::fromUser($user);
        $user = new UserResource ($user);
        return response()->json(['userData'=>$user,'token'=>$token,'message'=>trans('messages.user data'),'statusCode'=>200]);
    }
    
    /////////// function update user profile ///////////////
    public function updateUserProfile(Request $request){

        $token = $request->bearerToken();
        if($token){
            $user = JWTAuth::toUser($token);
        }

        $user->name=$request->name;
        $user->email=$request->email;
        $user->remember_token = $request->token;

        ////////// save image as a file///////////
        if($request->image){
            if ($request->hasFile("image")) {
    
                $file = $request->file("image");
                $mime = File::mimeType($file);
                $mimearr = explode('/', $mime);
    
                // $destinationPath = base_path() . '/uploads/'; // upload path
                $extension = $mimearr[1]; // getting file extension
                $fileName = rand(11111, 99999) . '.' . $extension; // renameing image
                $path = base_path('uploads/users/source/' . $fileName);
                $resize200 = base_path('uploads/users/resize200/' . $fileName);
                $resize800 = base_path('uploads/users/resize800/' . $fileName);
                //  $file->move($destinationPath, $fileName);
    
                Image::make($file->getRealPath())->save($path);
    
                $arrayimage = list($width, $height) = getimagesize($file->getRealPath());
                $widthreal = $arrayimage['0'];
                $heightreal = $arrayimage['1'];
    
                $width200 = ($widthreal / $heightreal) * 200;
                $height200 = $width200 / ($widthreal / $heightreal);
    
                $img200 = Image::canvas($width200, $height200);
                $image200 = Image::make($file->getRealPath())->resize($width200, $height200, function ($c) {
                    $c->aspectRatio();
                    $c->upsize();
                });
                $img200->insert($image200, 'center');
                $img200->save($resize200);
    
                $width800 = ($widthreal / $heightreal) * 800;
                $height800 = $width800 / ($widthreal / $heightreal);
    
                $img800 = Image::canvas($width800, $height800);
                $image800 = Image::make($file->getRealPath())->resize($width800, $height800, function ($c) {
                    $c->aspectRatio();
                    $c->upsize();
                });
                $img800->insert($image800, 'center');
                $img800->save($resize800);
    
                $user->image = $fileName;
            }else{
                $image_parts = explode(";base64,", $request->image);
                $image_type_ext = explode("image/", $image_parts[0]);
                $image_type = $image_type_ext[1];
                $image_base64 = base64_decode($image_parts[1]);
                              
                $extension = $image_type_ext[1]; // getting file extension
                $fileName = rand(11111, 99999) . '.' . $extension; // renameing image
                $path = base_path('uploads/users/source/' . $fileName);
                $resize200 = base_path('uploads/users/resize200/' . $fileName);
                $resize800 = base_path('uploads/users/resize800/' . $fileName);
    
                $sourceImage=Image::make($image_base64)->save($path);
    
                $widthreal = $sourceImage->height();
                $heightreal = $sourceImage->width();
                $width200 = ($widthreal / $heightreal) * 200;
                $height200 = $width200 / ($widthreal / $heightreal);
                $img200 = Image::canvas($width200, $height200);
                $image200 = Image::make($image_base64)->resize($width200, $height200, function ($c) {
                    $c->aspectRatio();
                    $c->upsize();
                });
                $img200->insert($image200, 'center');
                $img200->save($resize200);
    
                $width800 = ($widthreal / $heightreal) * 800;
                $height800 = $width800 / ($widthreal / $heightreal);
    
                $img800 = Image::canvas($width800, $height800);
                $image800 = Image::make($image_base64)->resize($width800, $height800, function ($c) {
                    $c->aspectRatio();
                    $c->upsize();
                });
                $img800->insert($image800, 'center');
                $img800->save($resize800);
                $user ->image = $fileName;
            }
        }
        $user->save();

        $token = JWTAuth::fromUser($user);
        $user = new UserResource ($user);
        return response()->json(['userData'=>$user,'token'=>$token,'message'=>trans('messages.user data updated successfully'),'statusCode'=>200]);
    }


    /////////////// public function send reset email ////////
    public function sendResetPasswordEmail(Request $request){
        try{
            $tempPassword = mt_rand(100000, 999999);
            $user = User::where('email', $request->email)->first();
            $user->password = Hash::make($tempPassword);
            $user->save();
            
            ////// send reset password email////////
            $data = ['tempPassword'=>$tempPassword];
            Mail::send('emails/reset-pasword', $data, function($msg) use ($user) {
                $msg->to($user->email, 'Fitgate')->subject('reset pasword');
                $msg->from(config('mail.from.address'),config('mail.from.name'));
            });
            
            $token = JWTAuth::fromUser($user);
            $user = new UserResource ($user);
            return response()->json(['message'=>trans('messages.reset password email sent successfully'),'statusCode'=>200,'userData'=>$user,'token'=>$token]);
        }catch(\Exception $e) {
            return response()->json(['message'=>'email not found','statusCode'=>404]);
        }
    }
    
    ////////////// public function return all users list ////////
    public function usersList(){
        try{
            $users = UserResource::collection(User::where('id','!=',1)->get());
            return response()->json(['usersData'=>$users,'message'=>trans('messages.list of all users'),'statusCode'=>200]);
        }catch(\Exception $e) {
            dd($e);
            return response()->json(['message'=>'no data found','statusCode'=>404]);
        }
    }
    
    
    
}
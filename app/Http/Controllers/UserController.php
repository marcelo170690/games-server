<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserUpdate;
use App\User;
use Illuminate\Http\Request;
use App\Http\Requests\UserStore;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api')->only('index', 'update');
    }

    public function index(Request $request)
    {
        return DB::table('users')
            ->where([
                ['first_name', 'like', "%$request->first_name%"],
                ['last_name', 'like', "%$request->last_name%"]
            ]
            )
            ->select('id', 'first_name', 'last_name', 'photo', 'username')
            ->get();
    }

    public function store(UserStore $request)
    {
        //guardomos la imagen en carpeta photo
        $img = $request->photo;
        $filename = Str::random(15).'.jpg';
        $exploded = explode(',',$img);
//        $decode = base64_decode($exploded[1]);
//        $path = public_path().'/photo/'.$filename;
//        file_put_contents($path, $decode);

        //guardamos la imagen y rotamos
        $data = base64_decode($exploded[1]); // base64 decoded image data
        $source_img = imagecreatefromstring($data);
        $rotated_img = imagerotate($source_img, $request->degrees, 0); // rotate with angle 90 here
        $file = 'photo/'.$filename;
        $imageSave = imagejpeg($rotated_img, $file, 50);
        imagedestroy($source_img);

        $user = new User();
        $user->username = $request->username;
        $user->first_name = strtoupper($request->first_name);
        $user->last_name = strtoupper($request->last_name);
        $user->photo = '/photo/'.$filename;
        $user->password = Hash::make($request->password);
        $user->save();

        $token = $user->createToken('Laravel Password Grant Client')->accessToken;

        return response(array(
            'user' => $user,
            'access_token' => $token,
        ), 200);
    }

    public function show($id)
    {

    }

    public function update(UserUpdate $request, $id)
    {
        $idUser = Auth::user()->id;
        $user = User::where('id', $idUser)->first();
        if ($request->photo){
            $beforePhoto = $user->photo;

            $filename = Str::random(15).'.jpg';
            $exploded = explode(',',$request->photo);

            $data = base64_decode($exploded[1]); // base64 decoded image data
            $source_img = imagecreatefromstring($data);
            $rotated_img = imagerotate($source_img, $request->degrees, 0); // rotate with angle 90 here
            $file = 'photo/'.$filename;
            $imageSave = imagejpeg($rotated_img, $file, 50);
            imagedestroy($source_img);

            $user->photo = '/photo/'.$filename;

            unlink(public_path().$beforePhoto);
        }

        $user->username = $request->username;
        $user->first_name = strtoupper($request->first_name);
        $user->last_name = strtoupper($request->last_name);
        $user->password = Hash::make($request->password);
        $user->save();

        return $user;
    }

    public function destroy($id)
    {

    }
}

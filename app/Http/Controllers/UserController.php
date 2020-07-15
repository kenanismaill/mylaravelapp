<?php

namespace App\Http\Controllers;

use App\User;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function SignUp(Request $request)
    {
        $this->validate($request, [
            'email'=>'required|email|unique:users',
            'first_name'=>'required|max:100',
            'password'=>'required|min:4'
        ]);
        $email= $request['email'];
        $first_name= $request['first_name'];
        $password=bcrypt( $request['password']);
        $user=new User();
        $user->email =$email;
        $user->first_name =$first_name;
        $user->password =$password;
        $user->save();
        Auth::login($user);
        return redirect()->route('dashboard');
    }

    public function SignIn(Request $request)
    {

        $this->validate($request, [
            'email'=>'required|email',
            'password'=>'required',
        ]);
        if (Auth::attempt(['email'=>$request['email'],'password'=>$request['password']])){
            return redirect()->route('dashboard');
        }
        return redirect()->back();
    }

    public function getloggout()
    {
        Auth::logout();
        return view('welcome');
    }

    public function useraccount()
    {
        return view('account',['user'=>Auth::user()]);
    }

    public function updateaccount(Request $request)
    {
        $this->validate($request,[
            'first_name'=>'required|max:100',

        ]);

        $user= Auth::user();
        $user->first_name = $request['first_name'];
        $user->update();
        $file=$request->file('image');
        $filename=$request['first_name']. '-'.$user->id.'.jpg';
        if ($file)
        {
            Storage::disk('local')->put($filename,File::get($file));
        }
        return redirect()->route('account');
    }

    public function getuserImage($filename)
    {
        $file=Storage::disk('local')->get($filename);
        return Response($file,200);
    }
}

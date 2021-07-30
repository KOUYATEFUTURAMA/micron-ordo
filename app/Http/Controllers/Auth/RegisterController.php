<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use function bcrypt;
use function redirect;
use function view;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }
    
    public function confirmationCompte($id, $token){
        $user = User::where('id', $id)->where('confirmation_token', $token)->first();
        if($user){
            return view('auth.register', compact('id', 'token'));
        }else{
            return redirect('/login');
        }
    }
    
    public function updatePassword(Request $request){
        $data = $request->all();
        $request->validate([
                    'password' => 'required|min:8|regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\x])(?=.*[!$@%]).*$/|confirmed|',
                ]);
        
        $user = User::where('id', $data['id'])->where('confirmation_token', $data['confirmation_token'])->first();
        if($user){
            $user->update([
                    'confirmation_token' => null,
                    'password' => bcrypt($data['password']),
                ]);
            return redirect('/login')->with('success', 'Votre compte a bien été confirmé. Veillez vous connectez');
        }else{
                        
        }
    }

}

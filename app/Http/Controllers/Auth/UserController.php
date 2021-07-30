<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Notifications\UserRegistred;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $menuPrincipal = "Auth";
        $titleControlleur = "Gestion des utilisateurs";
        $btnModalAjout = "TRUE";
        return view('auth.user.index', compact('btnModalAjout', 'menuPrincipal', 'titleControlleur'));
    }

    public function listeUser() {
        $users = User::select('users.*',DB::raw('DATE_FORMAT(users.last_login_at, "%d-%m-%Y &agrave; %H:%i") as last_login'))
                        ->orderBy('users.user_name', 'ASC')
                        ->where([['users.deleted_at', NULL],['users.id','!=' ,1]])
                        ->get();

       $jsonData["rows"] = $users->toArray();
       $jsonData["total"] = $users->count();
       
        return response()->json($jsonData);
    }
    
    public function profil() {
        $user = User::select('users.*',DB::raw('DATE_FORMAT(users.last_login_at, "%d-%m-%Y &agrave; %H:%i") as last_login'),DB::raw('DATE_FORMAT(users.created_at, "%d-%m-%Y &agrave; %H:%i") as created'))
                ->where('users.id', Auth::user()->id)
                ->first();

        $menuPrincipal = "Auth";
        $titleControlleur = "Profil utilisateur";
        $btnModalAjout = "FALSE";
        return view('auth.user.profil', compact('user','btnModalAjout', 'menuPrincipal', 'titleControlleur'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $jsonData = ["code" => 1, "msg" => "Enregistrement effectu&eacute; avec succ&egrave;s."];
        if ($request->isMethod('post') && $request->input('user_name')) {

            $data = $request->all();
          
            $User = User::where('email', $data['email'])->first();
            
            if($User){
                return response()->json(["code" => 0, "msg" => "Ce compte existe d&eacute;j&agrave;. V&eacute;rifier l'adresse mail", "data" => NULL]);
            }
            
            try {
          
                    $user = new User;
                    $user->user_name = $data['user_name'];
                    $user->role = $data['role'];
                    $user->contact = $data['contact'];
                    $user->email = $data['email'];
                    $user->password = bcrypt(Str::random(10)); 
                    $user->confirmation_token = str_replace('/', '', bcrypt(Str::random(16)));
                    $user->created_by = Auth::user()->id;
                    $user->save();
                    
                    if($user){
                        $user->notify(new UserRegistred()); 
                    }
                    
                    
                    $jsonData["data"] = json_decode($user);
                    return response()->json($jsonData);
                } catch (Exception $exc) {
                    $jsonData["code"] = -1;
                    $jsonData["data"] = NULL;
                    $jsonData["msg"] = $exc->getMessage();
                    return response()->json($jsonData);
                } 
        }
        return response()->json(["code" => 0, "msg" => "Saisie invalide", "data" => NULL]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $jsonData = ["code" => 1, "msg" => "Modification effectu&eacute;e avec succ&egrave;s."];

        $user = User::find($id);
        
        if ($user) {
            $data = $request->all();
            
            try {
              
                if($data['email'] != $user->email){
                    $User = User::where('email', $data['email'])->first();
            
                    if($User){
                        return response()->json(["code" => 0, "msg" => "Ce compte existe d&eacute;j&agrave;. V&eacute;rifier l'adresse mail", "data" => NULL]);
                    }
                    $user->user_name = $data['user_name'];
                    $user->role = $data['role'];
                    $user->contact = $data['contact'];
                    $user->email = $data['email'];
                    $user->password = bcrypt(Str::random(10)); 
                    $user->confirmation_token = str_replace('/', '', bcrypt(Str::random(16)));
                    
                    $user->updated_by = Auth::user()->id;
                    $user->save(); 
                    
                    $user->notify(new UserRegistred()); 
                }else{
                    $user->user_name = $data['user_name'];
                    $user->role = $data['role'];
                    $user->contact = $data['contact'];
                    $user->email = $data['email'];
                    
                    $user->updated_by = Auth::user()->id;
                    $user->save(); 
                }
                
                $jsonData["data"] = json_decode($user);
                return response()->json($jsonData);
            } catch (Exception $exc) {
                $jsonData["code"] = -1;
                $jsonData["data"] = NULL;
                $jsonData["msg"] = $exc->getMessage();
                return response()->json($jsonData);
            }
        }
        return response()->json(["code" => 0, "msg" => "Echec de modification", "data" => NULL]);
    }

    public function updateProfil(Request $request, $id){

        $user = User::find($id);
       
        if($user){
            $data = $request->all();
                
            $validator = Validator::make($data,[
                'user_name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255'],
                'contact' => ['required', 'string', 'max:255']
            ]);
       
            if($validator->fails()) {
                return Redirect::back()->withErrors($validator);
            }
           
            $user->user_name = $data['user_name'];
            $user->email = $data['email'];
            $user->contact = $data['contact'];

            if(isset($data['password']) && !empty($data['password'])){
                $validator = Validator::make($data,[
                    'password' => ['confirmed','min:8','regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\x])(?=.*[!$@%]).*$/'],
                    'password_confirmation' => ['min:8','regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\x])(?=.*[!$@%]).*$/']
                ]);

                if($validator->fails()) {
                    return Redirect::back()->withErrors($validator);
                }
               $user->password = bcrypt($data['password']);  
            }

            $user->save();
            
            return redirect()->route('auth.user.profil');
       }
    }

    //Réinitialisation du mot de passe par l'administrateur
    public function resetPasswordManualy(Request $request){
   
         $jsonData = ["code" => 1, "msg" => " Opération effectuée avec succès"];
            
            $user = User::find($request->get('userId'));
            $password = "";
            if($user && $user->statut_compte == 1){ 
                try {
                     //Geration du passsword à 8 chiffre
                    $ranges = array(range('a', 'z'), range('A', 'Z'), range(1, 9));
                    $password = '';
                    for ($i = 0; $i < 8; $i++) {
                        $rkey = array_rand($ranges);
                        $vkey = array_rand($ranges[$rkey]);
                        $password.= $ranges[$rkey][$vkey];
                    }
                    $user->password = bcrypt($password);
                    $user->updated_by = $user->id;
                    $user->save();
                   $to_name = $user->user_name;
                    $to_email = $user->email;
                    $data = array("name"=>$user->user_name, "body" => "Vous avez démandé à rénitialiser votre mot de passe. Votre nouveau mot de passse est : ".$password." Votre login reste le même : ".$user->email);
  
                    Mail::send('auth/user/mail', $data, function($message) use ($to_name, $to_email) {
                    $message->to($to_email, $to_name)
                    ->subject('Rénitialisation de votre mot de passe Smart-Ordo');
                    $message->from('tranxpert@smartyacademy.com','Smart-Ordo');
                    });

                    $jsonData["data"] = json_decode($user);
                    return response()->json($jsonData);
                } catch (Exception $exc) {
                   $jsonData["code"] = -1;
                   $jsonData["data"] = NULL;
                   $jsonData["msg"] = $exc->getMessage();
                   return response()->json($jsonData); 
                }
            }
            return response()->json(["code" => 0, "msg" => "Ce compte n'existe pas ou a été fermé !", "data" => NULL]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $jsonData = ["code" => 1, "msg" => " Op&eacute;ration effectu&eacute;e avec succ&egrave;s."];
        $user = User::find($id);
        
        if($user){
            try {
                if($user->statut_compte == 1){
                      $user->statut_compte = FALSE;
                }else{
                       $user->statut_compte = TRUE; 
                }
                $user->save();
                $jsonData["data"] = json_decode($user);
                return response()->json($jsonData);
            } catch (Exception $exc) {
                $jsonData["code"] = -1;
                $jsonData["data"] = NULL;
                $jsonData["msg"] = $exc->getMessage();
                return response()->json($jsonData);
            }
        }
        return response()->json(["code" => 0, "msg" => "Utilisateur introuvable", "data" => NULL]);
    }
}

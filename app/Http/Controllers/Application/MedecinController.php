<?php

namespace App\Http\Controllers\Application;


use App\Models\User;
use PHPUnit\Exception;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\Application\Medecin;
use App\Http\Controllers\Controller;
use App\Notifications\UserRegistred;
use Illuminate\Support\Facades\Auth;

class MedecinController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $specialites = DB::table('specialites')->orderBy('libelle_specialite', 'ASC')->get();
        $localites = DB::table('localites')->orderBy('libelle_localite', 'ASC')->get();
        $hopitaux = DB::table('hopitals')->orderBy('nom_hopital', 'ASC')->get();

        $menuPrincipal = "Médecin";
        $titleControlleur = "Liste des médecins";
        $btnModalAjout = "TRUE";

        return view('application.medecin.index', compact('hopitaux', 'localites', 'specialites', 'menuPrincipal', 'titleControlleur', 'btnModalAjout'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function listeMedecin()
    {
        $medecins = Medecin::with('localite')
                                ->select('medecins.*',DB::raw('DATE_FORMAT(medecins.date_naissance, "%d-%m-%Y") as date_naissances'))
                                ->orderBy('nom', 'ASC')
                                ->get();

       $jsonData["rows"] = $medecins->toArray();
       $jsonData["total"] = $medecins->count();
       return response()->json($jsonData);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $jsonData = ["code" => 1, "msg" => "Enregistrement effectué avec succès."];
        if ($request->isMethod('post') && $request->input('nom')) {

                $data = $request->all();

            try {

                //Création du profil du medecin
                $user = new User;
                $user->user_name = $data['nom'];
                $user->email = $data['email'];
                $user->contact = $data['contact'];
                $user->role = "Medecin";
                $user->password = bcrypt(Str::random(10));
                $user->confirmation_token = str_replace('/', '', bcrypt(Str::random(16)));
                $user->created_by = Auth::user()->id;
                $user->save();

            //création du medecin dans la table medecin
            if($user){
                $medecin = new Medecin;
                $medecin->nom = $data['nom'];
                $medecin->contact = $data['contact'];
                $medecin->email = $data['email'];
                $medecin->localite_id = $data['localite_id'];
                $medecin->date_naissance =  Carbon::createFromFormat('d-m-Y', $data['date_naissance']);
                $medecin->hopitaux = array_map(function($id) { return intval($id); }, $request->hopitaux);
                $medecin->specialites = array_map(function($id) { return intval($id); }, $request->specialites);
                $medecin->user_id = $user->id;
                $medecin->created_by = Auth::user()->id;
                $medecin->save();

                if($medecin){
                   // $user->notify(new UserRegistred());
                }else{
                    return response()->json(["code" => 0, "msg" => "Probleme lors de l'envoi du mail", "data" => NULL]);
                }

                $jsonData["data"] = json_decode($medecin);
                return response()->json($jsonData);
            }else{
                return response()->json(["code" => 0, "msg" => "Probleme lors de la création du compte", "data" => NULL]);
            }

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
     * @param  \App\Models\Medecin  $medecin
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $jsonData = ["code" => 1, "msg" => "Modification effectuée avec succès."];

        $medecin = Medecin::find($id);

        if ($medecin) {
            $data = $request->all();

            try {

                $medecin->nom = $data['nom'];
                $medecin->contact = $data['contact'];
                $medecin->email = $data['email'];
                $medecin->localite_id = $data['localite_id'];
                $medecin->date_naissance =  Carbon::createFromFormat('d-m-Y', $data['date_naissance']);
                $medecin->hopitaux = array_map(function($id) { return intval($id); }, $request->hopitaux);
                $medecin->specialites = array_map(function($id) { return intval($id); }, $request->specialites);
                $medecin->updated_by = Auth::user()->id;
                $medecin->save();

                $user = User::find($medecin->user_id);
                $user->user_name = $data['nom'];
                $user->contact = $data['contact'];

                if($user->email != $data['email']){
                    $user->email = $data['email'];
                    $user->password = bcrypt(Str::random(10));
                    $user->confirmation_token = str_replace('/', '', bcrypt(Str::random(16)));
                    $user->updated_by = Auth::user()->id;
                    $user->save();
                    $user->notify(new UserRegistred());
                }else{
                    $user->email = $data['email'];
                    $user->updated_by = Auth::user()->id;
                    $user->save();
                }

                $jsonData["data"] = json_decode($medecin);
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
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Medecin  $medecin
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $medecin = Medecin::find($id);
        $user = User::find($medecin->user_id);
        $jsonData = ["code" => 1, "msg" => " Opération effectuée avec succès."];
            if($medecin){
                try {

                    $user->update(['deleted_by' => Auth::user()->id]);
                    $medecin->update(['deleted_by' => Auth::user()->id]);
                    $user->delete();
                    $medecin->delete();
                    $jsonData["data"] = json_decode($medecin);
                    return response()->json($jsonData);

                } catch (Exception $exc) {
                   $jsonData["code"] = -1;
                   $jsonData["data"] = NULL;
                   $jsonData["msg"] = $exc->getMessage();
                   return response()->json($jsonData);
                }
            }
        return response()->json(["code" => 0, "msg" => "Echec de suppression", "data" => NULL]);
    }
}

<?php

namespace App\Http\Controllers\Parametre;

use App\Http\Controllers\Controller;
use App\Models\Parametre\Localite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LocaliteController extends Controller
{
    /** 
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $menuPrincipal = "Parametre";
        $titleControlleur = "Localité";
        $btnModalAjout = "FALSE";

        return view('parametre.localite.index', compact('menuPrincipal', 'titleControlleur', 'btnModalAjout'));
    }

    public function listeLocalite()
    {
        $localites = DB::table('localites')
                        ->select('localites.*')
                        ->orderBy('libelle_localite', 'ASC')
                        ->get();

       $jsonData["rows"] = $localites->toArray();
       $jsonData["total"] = $localites->count();
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
        if ($request->isMethod('post') && $request->input('libelle_localite')) {

                $data = $request->all(); 

            try {
               
                $Localite = Localite::where('libelle_localite', $data['libelle_localite'])->first();
                if($Localite!=null){
                    return response()->json(["code" => 0, "msg" => "Cet enregistrement existe déjà dans la base", "data" => NULL]);
                }

                $localite = new Localite;
                $localite->libelle_localite = $data['libelle_localite'];
                $localite->save();
                $jsonData["data"] = json_decode($localite);
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
     * @param  \App\Models\Localite  $localite
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $jsonData = ["code" => 1, "msg" => "Modification effectuée avec succès."];

        $localite = Localite::find($id);

        if($localite){
            try {

                $localite->update([
                    'libelle_localite' => $request->get('libelle_localite'),
                ]);

                $jsonData["data"] = json_decode($localite);
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Localite  $localite
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $localite = Localite::find($id);

        $jsonData = ["code" => 1, "msg" => " Opération effectuée avec succès."];
            if($localite){
                try {
               
                $localite->delete();
                $jsonData["data"] = json_decode($localite);
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
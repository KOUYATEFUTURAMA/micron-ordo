<?php

namespace App\Http\Controllers\Parametre;

use App\Http\Controllers\Controller;
use App\Models\Parametre\Specialite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SpecialiteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $menuPrincipal = "Parametre";
        $titleControlleur = "Spécialites";
        $btnModalAjout = "FALSE";

        return view('parametre.specialite.index', compact('menuPrincipal', 'titleControlleur', 'btnModalAjout'));
    }

    public function listeSpecialite()
    {
        $specialites = Specialite::orderBy('libelle_Specialite', 'ASC')
                                    ->get();

       $jsonData["rows"] = $specialites->toArray();
       $jsonData["total"] = $specialites->count();
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
        if ($request->isMethod('post') && $request->input('libelle_specialite')) {

                $data = $request->all();

            try {

                $specialite = new Specialite;
                $specialite->libelle_specialite = $data['libelle_specialite'];
                $specialite->save();
                $jsonData["data"] = json_decode($specialite);
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
     * @param  \App\Models\Specialite  $specialite
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $jsonData = ["code" => 1, "msg" => "Modification effectuée avec succès."];

        $specialite = Specialite::find($id);

        if($specialite){
             $data = $request->all();
            try {

                $specialite->libelle_specialite = $data['libelle_specialite'];
                $specialite->save();

                $jsonData["data"] = json_decode($specialite);
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
     * @param  \App\Models\Specialite  $specialite
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $specialite = Specialite::find($id);

        $jsonData = ["code" => 1, "msg" => " Opération effectuée avec succès."];
            if($specialite){
                try {

                $specialite->delete();
                $jsonData["data"] = json_decode($specialite);
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

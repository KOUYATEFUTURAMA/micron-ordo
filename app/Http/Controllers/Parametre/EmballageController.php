<?php

namespace App\Http\Controllers\Parametre;

use App\Http\Controllers\Controller;
use App\Models\Parametre\Emballage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EmballageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $menuPrincipal = "Parametre";
        $titleControlleur = "Emballage";
        $btnModalAjout = "FALSE";

        return view('parametre.emballage.index', compact('menuPrincipal', 'titleControlleur', 'btnModalAjout'));
    }

    public function listeEmballage()
    {
        $emballages = DB::table('emballages')
                        ->select('emballages.*')
                        ->orderBy('libelle_emballage', 'ASC')
                        ->get();

       $jsonData["rows"] = $emballages->toArray();
       $jsonData["total"] = $emballages->count();
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
        if ($request->isMethod('post') && $request->input('libelle_emballage')) {

                $data = $request->all();

            try {

                $emballage = new Emballage;
                $emballage->libelle_emballage = $data['libelle_emballage'];
                $emballage->save();
                $jsonData["data"] = json_decode($emballage);
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
     * @param  \App\Models\Emballage  $Emballage
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $jsonData = ["code" => 1, "msg" => "Modification effectuée avec succès."];

        $emballage = Emballage::find($id);

        if($emballage){
             $data = $request->all();
            try {

                $emballage->libelle_emballage = $data['libelle_emballage'];
                $emballage->save();

                $jsonData["data"] = json_decode($emballage);
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
     * @param  \App\Models\Emballage  $Emballage
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $emballage = Emballage::find($id);

        $jsonData = ["code" => 1, "msg" => " Opération effectuée avec succès."];
            if($emballage){
                try {

                $emballage->delete();
                $jsonData["data"] = json_decode($emballage);
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

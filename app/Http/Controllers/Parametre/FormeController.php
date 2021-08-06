<?php

namespace App\Http\Controllers\Parametre;

use App\Http\Controllers\Controller;
use App\Models\Parametre\Forme;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FormeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $menuPrincipal = "Parametre";
        $titleControlleur = "Forme pharmaceutique";
        $btnModalAjout = "FALSE";

        return view('parametre.forme.index', compact('menuPrincipal', 'titleControlleur', 'btnModalAjout'));
    }

    public function listeForme()
    {
        $formes = DB::table('formes')
                        ->select('formes.*')
                        ->orderBy('libelle_forme', 'ASC')
                        ->get();

       $jsonData["rows"] = $formes->toArray();
       $jsonData["total"] = $formes->count();
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
        if ($request->isMethod('post') && $request->input('libelle_forme')) {

                $data = $request->all();

            try {

                $forme = new Forme;
                $forme->libelle_forme = $data['libelle_forme'];
                $forme->save();
                $jsonData["data"] = json_decode($forme);
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
     * @param  \App\Models\Forme  $Forme
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $jsonData = ["code" => 1, "msg" => "Modification effectuée avec succès."];

        $forme = Forme::find($id);

        if($forme){
             $data = $request->all();
            try {

                $forme->libelle_forme = $data['libelle_forme'];
                $forme->save();

                $jsonData["data"] = json_decode($forme);
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
     * @param  \App\Models\Forme  $Forme
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $forme = Forme::find($id);

        $jsonData = ["code" => 1, "msg" => " Opération effectuée avec succès."];
            if($forme){
                try {

                $forme->delete();
                $jsonData["data"] = json_decode($forme);
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

<?php

namespace App\Http\Controllers\Parametre;

use App\Http\Controllers\Controller;
use App\Models\Parametre\ModeAdministration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ModeAdministrationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $menuPrincipal = "Parametre";
        $titleControlleur = "Mode administration";
        $btnModalAjout = "FALSE";

        return view('parametre.mode.index', compact('menuPrincipal', 'titleControlleur', 'btnModalAjout'));
    }

    public function listeModeAdministation()
    {
        $modes = DB::table('mode_administrations')
                        ->select('mode_administrations.*')
                        ->orderBy('libelle_mode', 'ASC')
                        ->get();

       $jsonData["rows"] = $modes->toArray();
       $jsonData["total"] = $modes->count();
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
        if ($request->isMethod('post') && $request->input('libelle_mode')) {

                $data = $request->all();

            try {

                $modeAdministration = new ModeAdministration;
                $modeAdministration->libelle_mode = $data['libelle_mode'];
                $modeAdministration->save();
                $jsonData["data"] = json_decode($modeAdministration);
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
     * @param  \App\Models\ModeAdministration  $modeAdministration
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $jsonData = ["code" => 1, "msg" => "Modification effectuée avec succès."];

        $modeAdministration = ModeAdministration::find($id);

        if($modeAdministration){
             $data = $request->all();
            try {

                $modeAdministration->libelle_mode = $data['libelle_mode'];
                $modeAdministration->save();

                $jsonData["data"] = json_decode($modeAdministration);
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
     * @param  \App\Models\ModeAdministration  $modeAdministration
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $modeAdministration = ModeAdministration::find($id);

        $jsonData = ["code" => 1, "msg" => " Opération effectuée avec succès."];
            if($modeAdministration){
                try {

                $modeAdministration->delete();
                $jsonData["data"] = json_decode($modeAdministration);
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

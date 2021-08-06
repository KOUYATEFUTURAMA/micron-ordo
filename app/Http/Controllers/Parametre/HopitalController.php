<?php

namespace App\Http\Controllers\Parametre;

use App\Http\Controllers\Controller;
use App\Models\Parametre\Hopital;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Image;

class HopitalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $localites = DB::table('localites')->select('localites.*')->orderBy('libelle_localite', 'ASC')->get();

        $menuPrincipal = "Parametre";
        $titleControlleur = "Hopital";
        $btnModalAjout = "TRUE";

        return view('parametre.hopital.index', compact('localites', 'menuPrincipal', 'titleControlleur', 'btnModalAjout'));
    }
 
    public function listeHopital()
    {
        $hopitals = Hopital::with('localite')
                                ->select('hopitals.*')
                                ->orderBy('nom_hopital', 'ASC')
                                ->get();

       $jsonData["rows"] = $hopitals->toArray();
       $jsonData["total"] = $hopitals->count();
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
        if ($request->isMethod('post') && $request->input('nom_hopital')) {

                $data = $request->all(); 

            try {

                $hopital = new Hopital;
                $hopital->nom_hopital = $data['nom_hopital'];
                $hopital->contact_hopital = $data['contact_hopital'];
                $hopital->adresse_hopital = $data['adresse_hopital'];
                $hopital->localite_id = $data['localite_id'];
                $hopital->contact2 = isset($data['contact2']) && !empty($data['contact2']) ? $data['contact2'] : null;
                $hopital->faxe = isset($data['faxe']) && !empty($data['faxe']) ? $data['faxe'] : null;
                $hopital->boite_postale = isset($data['boite_postale']) && !empty($data['boite_postale']) ? $data['boite_postale'] : null;
                $hopital->email = isset($data['email']) && !empty($data['email']) ? $data['email'] : null;
                $hopital->longitude = isset($data['longitude']) && !empty($data['longitude']) ? $data['longitude'] : null;
                $hopital->latitude = isset($data['latitude']) && !empty($data['latitude']) ? $data['latitude'] : null;
                

                //Image traitement
                if(isset($data['logo']) && !empty($data['logo'])){
                    $logo = $data['logo'];

                    $file_extention = strtolower($logo->getClientOriginalExtension());
                    $file_name = rand(11111, 99999).time().'.'. $file_extention; 

                    $image_resize  = Image::make($logo->getRealPath());
               
                    if (!file_exists(public_path('/storage/logo/'))) {
                        mkdir(public_path('/storage/logo/'), 666, true);
                    }

                    $image_resize->save(public_path('/storage/logo/'.$file_name),40);

                    $hopital->logo = '/storage/logo/'.$file_name; 
                }
               
                $hopital->save();

                $jsonData["data"] = json_decode($hopital);
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
     * @param  \App\Models\Pharmacie  $pharmacie
     * @return \Illuminate\Http\Response
     */
    public function hopitalUpdate(Request $request)
    {
        $jsonData = ["code" => 1, "msg" => "Modification effectuée avec succès."];

        $hopital = Hopital::find($request->get("idHopital"));

        if ($hopital) {

                $data = $request->all(); 

            try {

                $hopital->nom_hopital = $data['nom_hopital'];
                $hopital->contact_hopital = $data['contact_hopital'];
                $hopital->adresse_hopital = $data['adresse_hopital'];
                $hopital->localite_id = $data['localite_id'];
                $hopital->contact2 = isset($data['contact2']) && !empty($data['contact2']) ? $data['contact2'] : null;
                $hopital->faxe = isset($data['faxe']) && !empty($data['faxe']) ? $data['faxe'] : null;
                $hopital->boite_postale = isset($data['boite_postale']) && !empty($data['boite_postale']) ? $data['boite_postale'] : null;
                $hopital->email = isset($data['email']) && !empty($data['email']) ? $data['email'] : null;
                $hopital->longitude = isset($data['longitude']) && !empty($data['longitude']) ? $data['longitude'] : null;
                $hopital->latitude = isset($data['latitude']) && !empty($data['latitude']) ? $data['latitude'] : null;
                

                //Image traitement
                if(isset($data['logo']) && !empty($data['logo'])){
                    $logo = $data['logo'];

                    $file_extention = strtolower($logo->getClientOriginalExtension());
                    $file_name = rand(11111, 99999).time().'.'. $file_extention; 

                    $image_resize  = Image::make($logo->getRealPath());
               
                    if (!file_exists(public_path('/storage/logo/'))) {
                        mkdir(public_path('/storage/logo/'), 666, true);
                    }

                    $image_resize->save(public_path('/storage/logo/'.$file_name),40);

                    $hopital->logo = '/storage/logo/'.$file_name; 
                }
                $hopital->save();

                $jsonData["data"] = json_decode($hopital);
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
     * @param  \App\Models\Pharmacie  $pharmacie
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $hopital = Hopital::find($id);

        $jsonData = ["code" => 1, "msg" => " Opération effectuée avec succès."];
            if($hopital){
                try {
               
                $hopital->delete();
                $jsonData["data"] = json_decode($hopital);
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

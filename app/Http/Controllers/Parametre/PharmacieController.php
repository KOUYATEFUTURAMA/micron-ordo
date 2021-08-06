<?php

namespace App\Http\Controllers\Parametre;

use App\Http\Controllers\Controller;
use App\Models\Parametre\Pharmacie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Image;

class PharmacieController extends Controller
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
        $titleControlleur = "Pharmacie";
        $btnModalAjout = "TRUE";

        return view('parametre.pharmacie.index', compact('localites', 'menuPrincipal', 'titleControlleur', 'btnModalAjout'));
    }
 
    public function listePharmacie()
    {
        $pharmacies = Pharmacie::with('localite')
                                ->select('pharmacies.*')
                                ->orderBy('nom_pharmacie', 'ASC')
                                ->get();

       $jsonData["rows"] = $pharmacies->toArray();
       $jsonData["total"] = $pharmacies->count();
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
        if ($request->isMethod('post') && $request->input('nom_pharmacie')) {

                $data = $request->all(); 

            try {

                $pharmacie = new Pharmacie;
                $pharmacie->nom_pharmacie = $data['nom_pharmacie'];
                $pharmacie->contact_pharmacie = $data['contact_pharmacie'];
                $pharmacie->responsable = $data['responsable'];
                $pharmacie->contact_responsable = $data['contact_responsable'];
                $pharmacie->adresse_pharmacie = $data['adresse_pharmacie'];
                $pharmacie->localite_id = $data['localite_id'];
                $pharmacie->contact2 = isset($data['contact2']) && !empty($data['contact2']) ? $data['contact2'] : null;
                $pharmacie->faxe = isset($data['faxe']) && !empty($data['faxe']) ? $data['faxe'] : null;
                $pharmacie->boite_postale = isset($data['boite_postale']) && !empty($data['boite_postale']) ? $data['boite_postale'] : null;
                $pharmacie->email = isset($data['email']) && !empty($data['email']) ? $data['email'] : null;
                $pharmacie->longitude = isset($data['longitude']) && !empty($data['longitude']) ? $data['longitude'] : null;
                $pharmacie->latitude = isset($data['latitude']) && !empty($data['latitude']) ? $data['latitude'] : null;
                

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

                    $pharmacie->logo = '/storage/logo/'.$file_name; 
                }
               
                $pharmacie->save();
                $jsonData["data"] = json_decode($pharmacie);
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
    public function pharmacieUpdate(Request $request)
    {
        $jsonData = ["code" => 1, "msg" => "Modification effectuée avec succès."];

        $pharmacie = Pharmacie::find($request->get("idPharmacie"));

        if ($pharmacie) {

                $data = $request->all(); 

            try {

                $pharmacie->nom_pharmacie = $data['nom_pharmacie'];
                $pharmacie->contact_pharmacie = $data['contact_pharmacie'];
                $pharmacie->responsable = $data['responsable'];
                $pharmacie->contact_responsable = $data['contact_responsable'];
                $pharmacie->adresse_pharmacie = $data['adresse_pharmacie'];
                $pharmacie->localite_id = $data['localite_id'];
                $pharmacie->contact2 = isset($data['contact2']) && !empty($data['contact2']) ? $data['contact2'] : null;
                $pharmacie->faxe = isset($data['faxe']) && !empty($data['faxe']) ? $data['faxe'] : null;
                $pharmacie->boite_postale = isset($data['boite_postale']) && !empty($data['boite_postale']) ? $data['boite_postale'] : null;
                $pharmacie->email = isset($data['email']) && !empty($data['email']) ? $data['email'] : null;
                $pharmacie->longitude = isset($data['longitude']) && !empty($data['longitude']) ? $data['longitude'] : null;
                $pharmacie->latitude = isset($data['latitude']) && !empty($data['latitude']) ? $data['latitude'] : null;
                

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

                    $pharmacie->logo = '/storage/logo/'.$file_name; 
                }
                $pharmacie->save();

                $jsonData["data"] = json_decode($pharmacie);
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
        $pharmacie = Pharmacie::find($id);

        $jsonData = ["code" => 1, "msg" => " Opération effectuée avec succès."];
            if($pharmacie){
                try {
               
                $pharmacie->delete();
                $jsonData["data"] = json_decode($pharmacie);
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

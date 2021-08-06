<?php

namespace App\Http\Controllers\Parametre;

use App\Http\Controllers\Controller;
use App\Models\Parametre\Medicament;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Image;

class MedicamentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = DB::table('categories')->select('categories.*')->where('categorie_id',null)->orderBy('libelle_categorie', 'ASC')->get();
        $modes = DB::table('mode_administrations')->select('mode_administrations.*')->orderBy('libelle_mode', 'ASC')->get();
        $emballages = DB::table('emballages')->select('emballages.*')->orderBy('libelle_emballage', 'ASC')->get();
        $formes = DB::table('formes')->select('formes.*')->orderBy('libelle_forme', 'ASC')->get();

        $menuPrincipal = "Parametre";
        $titleControlleur = "Médicament";
        $btnModalAjout = "TRUE";

        return view('parametre.medicament.index', compact('categories','modes','emballages','formes', 'menuPrincipal', 'titleControlleur', 'btnModalAjout'));
    }
 
    public function listeMedicament()
    {
        $medicaments = Medicament::with('categorie','sous_categorie','forme','emballage','mode')
                                ->select('medicaments.*')
                                ->orderBy('denomination', 'ASC')
                                ->get();

       $jsonData["rows"] = $medicaments->toArray();
       $jsonData["total"] = $medicaments->count();
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
        if ($request->isMethod('post') && $request->input('denomination')) {

                $data = $request->all(); 

            try {

                $medicament = new Medicament;
                $medicament->denomination = $data['denomination'];
                $medicament->composition_quantitative = $data['composition_quantitative'];
                $medicament->categorie_id = $data['categorie_id'];
                $medicament->forme_id = $data['forme_id'];
                $medicament->emballage_id = $data['emballage_id'];
                $medicament->mode_administration_id = $data['mode_administration_id'];
                $medicament->description = isset($data['description']) && !empty($data['description']) ? $data['description'] : null;
                $medicament->numero_autorisation = isset($data['numero_autorisation']) && !empty($data['numero_autorisation']) ? $data['numero_autorisation'] : null;
                $medicament->sous_categorie_id = isset($data['sous_categorie_id']) && !empty($data['sous_categorie_id']) ? $data['sous_categorie_id'] : null;

                //Image traitement
                if(isset($data['image']) && !empty($data['image'])){
                    $image = $data['image'];

                    $file_extention = strtolower($image->getClientOriginalExtension());
                    $file_name = rand(11111, 99999).time().'.'. $file_extention; 

                    $image_resize  = Image::make($image->getRealPath());
               
                    if (!file_exists(public_path('/storage/image/'))) {
                        mkdir(public_path('/storage/image/'), 666, true);
                    }

                    $image_resize->save(public_path('/storage/image/'.$file_name),40);

                    $medicament->image = '/storage/image/'.$file_name; 
                }
               
                $medicament->save();

                $jsonData["data"] = json_decode($medicament);
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
    public function medicamentUpdate(Request $request)
    {
        $jsonData = ["code" => 1, "msg" => "Modification effectuée avec succès."];

        $medicament = Medicament::find($request->get("idMedicament"));

        if ($medicament) {

                $data = $request->all(); 

            try {

                 $medicament->denomination = $data['denomination'];
                $medicament->composition_quantitative = $data['composition_quantitative'];
                $medicament->categorie_id = $data['categorie_id'];
                $medicament->forme_id = $data['forme_id'];
                $medicament->emballage_id = $data['emballage_id'];
                $medicament->mode_administration_id = $data['mode_administration_id'];
                $medicament->description = isset($data['description']) && !empty($data['description']) ? $data['description'] : null;
                $medicament->numero_autorisation = isset($data['numero_autorisation']) && !empty($data['numero_autorisation']) ? $data['numero_autorisation'] : null;
                $medicament->sous_categorie_id = isset($data['sous_categorie_id']) && !empty($data['sous_categorie_id']) ? $data['sous_categorie_id'] : null;

                //Image traitement
                if(isset($data['image']) && !empty($data['image'])){
                    $image = $data['image'];

                    $file_extention = strtolower($image->getClientOriginalExtension());
                    $file_name = rand(11111, 99999).time().'.'. $file_extention; 

                    $image_resize  = Image::make($image->getRealPath());
               
                    if (!file_exists(public_path('/storage/image/'))) {
                        mkdir(public_path('/storage/image/'), 666, true);
                    }

                    $image_resize->save(public_path('/storage/image/'.$file_name),40);

                    $medicament->image = '/storage/image/'.$file_name; 
                }
               
                $medicament->save();

                $jsonData["data"] = json_decode($medicament);
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
        $medicament = Medicament::find($id);

        $jsonData = ["code" => 1, "msg" => " Opération effectuée avec succès."];
            if($medicament){
                try {
               
                $medicament->delete();
                $jsonData["data"] = json_decode($medicament);
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

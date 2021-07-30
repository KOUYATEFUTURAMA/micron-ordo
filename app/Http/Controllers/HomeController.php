<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $menuPrincipal = "Accueil";
        $titleControlleur = "Tableau de bord";
        $btnModalAjout = "FALSE";

        if(Auth::user()->pharmacie_id==null && Auth::user()->hopital_id==null){
            return view('admin-home', compact('menuPrincipal', 'titleControlleur', 'btnModalAjout'));
        }
        if(Auth::user()->pharmacie_id !=null){
            return view('pharmacie-home', compact('menuPrincipal', 'titleControlleur', 'btnModalAjout'));
        }
        if(Auth::user()->hopital_id != null){
            return view('hopital-home', compact('menuPrincipal', 'titleControlleur', 'btnModalAjout'));
        }
    }
}

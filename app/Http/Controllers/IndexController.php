<?php 
namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class IndexController extends BaseController
{

    // les annonces triées par ordre décroissant d'identifiant et les affiche par groupe de 3 sur la page d'accueil du site.
    public function showIndex()
	{
		$id = '[0-9]+';
		$annonces = Annonce::orderBy('id', 'desc')->paginate(3);
        Return View::make('index.index')->with('annonces', $annonces);
	}
}

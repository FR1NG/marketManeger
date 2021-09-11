<?php

namespace App\Http\Controllers;

use App\Models\article;
use App\Models\fournisseur;
use Illuminate\Http\Request;

class AchatController extends Controller
{
    public function create()
    {
        $articles = article::select('id', 'name')
            ->get();
        $fournisseurs = fournisseur::select('id', 'name')
            ->get();
        $response = [
            'articles' => $articles,
            'fournisseurs' => $fournisseurs
        ];
        return response()->json($response);
    }
}

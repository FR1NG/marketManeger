<?php

namespace App\Http\Controllers;

use App\Models\fournisseur;
use Illuminate\Http\Request;

class FournisseurController extends Controller
{
    /*
    *==========================================
    *this function for gettin list of providers
    *==========================================
    */
    public function getData(Request $requesr){
        $query = fournisseur::query();
        if ($requesr->search){
            $column_to_search = [
                'name',
                'phone',
                'address',
                'email',
                'note'
            ];
            $search = '%'. $requesr->search .'%';
            foreach($column_to_search as $column){
                $query->orWhere($column,'LIKE',$search);
            }
        }
        $fournisseurs = $query->paginate(10);
        return $fournisseurs;
    }

    /*
    *======================================
    *this function for storing new provider
    *======================================
    */
    public function store(Request $request){
        $request->validate([
            'name'=>'required|max:100',
            'phone'=>'numeric',
            'email'=>'email',
            'address'=>'max:255',
            'nore'=>'max:255'
        ]);
        $fournisseur = new fournisseur();
        $fournisseur->name = $request->name;
        $fournisseur->phone = $request->phone;
        $fournisseur->email = $request->email;
        $fournisseur->address = $request->address;
        $fournisseur->note = $request->note;
        $fournisseur->save();
        return response()->json(["message"=>"fournisseur a été ajouté avec succès"],200);
    }

    /*
    *=================================
    *this function for delete provider
    *=================================
    */
    public function delete(Request $requesr){
        $fournisseur = fournisseur::find($requesr->id);
        if($fournisseur){
            $process = $fournisseur->delete();
            if($process){
                return response()->json(['message'=>'fournisseur a été supprimé'],200);
            }
            else {
                return response()->json(['message'=>'il y a un problème lors de la suppression du fournisseur'],500);
            }
        }
        else {
            return response()->json(['message'=>'fournisseur introuvable'],404);
        }
    }

    /*
    *======================================
    *this function for getting one provider
    *======================================
    */
    public function details(Request $request){
        $fournisseur = fournisseur::find($request->id);
        if($fournisseur){
            return response()->json($fournisseur);
        }
        else {
            return response()->json(['message'=>'fournisseur introuvable'],404);
        }
    }

    /*
    *===================================
    *this function for updating provider
    *===================================
    */
    public function update(Request $request){
        $request->validate([
            'name'=>'required|max:100',
            'phone'=>'numeric',
            'email'=>'email',
            'address'=>'max:255',
            'nore'=>'max:255'
        ]);
        $provider = fournisseur::find($request->id);
        if($provider){
            $provider->name = $request->name;
            $provider->phone = $request->phone;
            $provider->email = $request->email;
            $provider->address = $request->address;
            $provider->note = $request->note;
            $process = $provider->update();
            if($process){
                return response()->json(['message'=>'Le fournisseur a été mis à jour avec succès'],200);
            }
        }
        else
        {
            return response()->json(['message'=> "Fournisseur introuvable"],404);
        }
    }
}

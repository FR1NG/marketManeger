<?php

namespace App\Http\Controllers;

use App\Models\employe;
use App\Models\market;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmployeController extends Controller
{

    private $market_id;

    public function __construct()
    {

        $this->middleware(function ($request, $next) {
            if (Auth::user()->hasRole('admin')) {
                $this->market_id = $request->market_id;
            } else {
                $this->market_id = Auth::user()->market->id;
            }

            return $next($request);
        });
    }
    /*
    *======================================
    *this function for storing new employe
    *======================================
    */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:100|min:3',
            'cin' => 'required|max:50|min:3',
            'cnss' => 'required|max:100',
            'phone' => 'numeric|digits:10',
            'salery' => 'numeric|required',
            'quality' => 'required|max:100',
            'email' => 'nullable|email',
            'address' => 'required|max:255|min:3',
            'nore' => 'max:255'
        ]);
        $employe = new employe();
        $employe->market_id = $this->market_id;
        $employe->name = $request->name;
        $employe->cin = $request->cin;
        $employe->cnss = $request->cnss;
        $employe->phone = $request->phone;
        $employe->email = $request->email;
        $employe->salery = $request->salery;
        $employe->quality = $request->quality;
        $employe->address = $request->address;
        $employe->note = $request->note;
        $employe->save();
        return response()->json(["message" => "employé a été ajouté avec succès"], 200);
    }

    /*
    *==========================================
    *this function for gettin list of employes
    *==========================================
    */
    public function index(Request $requesr)
    {
        $query = employe::query();
        $query->where('market_id', '=', $this->market_id);
        if ($requesr->search) {
            $column_to_search = [
                'name',
                'cin',
                'cnss',
                'phone',
                'email',
                'salery',
                'quality',
                'address',
                'note'
            ];
            $search = '%' . $requesr->search . '%';
            foreach ($column_to_search as $column) {
                $query->orWhere($column, 'LIKE', $search);
            }
        }
        $employe = $query->paginate(10);
        return $employe;
    }


    /*
    *======================================
    *this function for getting one employe
    *======================================
    */
    public function details(Request $request)
    {
        $employe = employe::find($request->id);
        if ($employe) {
            return response()->json($employe);
        } else {
            return response()->json(['message' => 'employe introuvable'], 404);
        }
    }

    /*
    *===================================
    *this function for updating employe
    *===================================
    */
    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|max:100',
            'cin' => 'required|max:50',
            'cnss' => 'required|max:100',
            'phone' => 'numeric',
            'salery' => 'numeric|required',
            'quality' => 'required|max:100',
            'email' => 'email',
            'address' => 'max:255',
            'nore' => 'max:255'
        ]);
        $employe = employe::find($request->id);
        if ($employe) {
            $employe->name = $request->name;
            $employe->cin = $request->cin;
            $employe->cnss = $request->cnss;
            $employe->phone = $request->phone;
            $employe->email = $request->email;
            $employe->salery = $request->salery;
            $employe->quality = $request->quality;
            $employe->address = $request->address;
            $employe->note = $request->note;
            $process = $employe->update();
            if ($process) {
                return response()->json(['message' => 'L\'employé a été mis à jour avec succès'], 200);
            }
        } else {
            return response()->json(['message' => "Employé introuvable"], 404);
        }
    }

    /*
    *=================================
    *this function for delete employe
    *=================================
    */
    public function delete(Request $requesr)
    {
        $employe = employe::find($requesr->id);
        if ($employe) {
            $process = $employe->delete();
            if ($process) {
                return response()->json(['message' => 'L\'employé a été supprimé'], 200);
            } else {
                return response()->json(['message' => 'il y a un problème lors de la suppression du fournisseur'], 500);
            }
        } else {
            return response()->json(['message' => 'Employé introuvable'], 404);
        }
    }
}

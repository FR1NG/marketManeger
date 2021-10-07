<?php

namespace App\Http\Controllers;

use App\Models\article;
use App\Models\articleEnBranchement;
use App\Models\branchement;
use App\Models\employe;
use App\Models\employesEnBranchement;
use App\Models\marketArticle;
use App\Models\marketCategory;
use App\Models\marketCity;
use App\Models\warehouse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BranchementController extends Controller
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


    public function index(Request $request)
    {
        $query = branchement::query();
        $query->where('market_id', '=', $this->market_id);
        $query->with(['marketArticle:id,display_name', 'city:id,name']);
        if ($request->search) {
            $search = '%' . $request->search . '%';
            $columns = [
                'contract_number',
                'client_name',
                'address',
                'intervention',
                'estimate_number',
                'phone',
                'diameter',
                'caliber',
                'nature',
                'arrival_date',
                'motive',
            ];

            foreach ($columns as $column) {
                $query->orWhere($column, 'LIKE', $search);
            }
        }
        $branchements = $query->orderBy('created_at', 'DESC')->paginate(10);
        return response()->json(['branchements' => $branchements], 200);
    }

    public function store(Request $request)
    {
        $branchement = new branchement();
        $request->validate([
            'market_article_id' => 'required|numeric',
            'type' => 'required|in:normal,social',
            'city' => 'required|numeric',
            'contract_number' => 'required|max:255',
            'client_name' => 'required|max:100',
            'address' => 'required|max:255',
            'intervention' => 'max:100',
            'estimate_number' => 'required|max:100',
            'phone' => 'required|numeric|digits:10',
            'diameter' => 'max:255',
            'caliber' => 'max:255',
            'nature' => 'max:255',
            'arrival_date' => 'date',
            'motive' => 'max:255',
        ]);

        $branchement->market_id = $this->market_id;
        $branchement->market_article_id = $request->market_article_id;
        $branchement->type = $request->type;
        $branchement->city_id = $request->city;
        $branchement->contract_number = $request->contract_number;
        $branchement->client_name = $request->client_name;
        $branchement->address = $request->address;
        $branchement->intervention = $request->intervention;
        $branchement->estimate_number = $request->estimate_number;
        $branchement->phone = $request->phone;
        $branchement->diameter = $request->diameter;
        $branchement->caliber = $request->caliber;
        $branchement->nature = $request->nature;
        $branchement->arrival_date = $request->arrival_date;
        $branchement->motive = $request->motive;

        $process = $branchement->save();

        if ($process) {
            return response()->json(['message' => "Branchement a été créé avec succès", "branchement_id" => $branchement->id], 200);
        } else {
            return response()->json(['message' => "Branchement n'a pas été créée"], 500);
        }
    }

    public function details(Request $request)
    {
        $branchement = branchement::where('id', '=', $request->id)
            ->where('market_id', '=', $this->market_id)
            ->with(['items:id,price,article_id,branchement_id', 'items.article:id,name', 'employees.employe:id,name,quality', 'city:id,name', 'marketArticle:id,display_name,unit_price', 'charges'])
            ->first();
        if (!$branchement) {
            // return response()->json(['message' => 'Branchement inrouvable'], 404);
            return abort(404);
        }
        return response()->json(['branchement' => $branchement], 200);
    }

    public function getArticles()
    {
        $articles = article::select('id', 'name')->get();

        return response()->json(['articles' => $articles]);
    }

    public function getEmployees()
    {
        $employees = employe::select('id', 'name')
            ->where('market_id', '=', $this->market_id)
            ->get();

        return response()->json(['employees' => $employees]);
    }

    public function addArticles(Request $request)
    {
        $errors = 0;
        foreach ($request->items as $item) {
            $warehouse = warehouse::where('article_id', '=', $item['id'])
                ->where('market_id', '=', $this->market_id)
                ->where('quantity', '>', 0)
                ->orderBy('created_at', 'ASC')
                ->first();
            if ($warehouse) {
                $existed = articleEnBranchement::where('branchement_id', '=', $request->branchement_id)->where('article_id', '=', $item['id'])->first();
                if (!$existed) {
                    $itemInBranchement = new articleEnBranchement();
                    $itemInBranchement->branchement_id = $request->branchement_id;
                    $itemInBranchement->article_id = $item['id'];
                    $itemInBranchement->price = $warehouse->price;
                    $itemInBranchement->warehouse_id = $warehouse->id;
                    $saving = $itemInBranchement->save();
                    if ($saving) {
                        $warehouse->quantity -= 1;
                        $warehouse->update();
                    }
                }
            } else {
                // return response()->json(['message' => 'Cet article n\'existe pas dans l\'entrepôt'], 500);
                $errors++;
            }
        }
        if ($errors > 0) {
            return response()->json(['message' => $errors . ' Pièces n\'existe pas dans l\'entrepôt'], 405);
        } else {
            return response()->json(['message' => 'Les pièces ont été ajoutées avec succès'], 200);
        }
    }


    public function addEmployees(Request $request)
    {
        $request->validate([
            'branchement_id' => 'required|numeric',
            'employe_id' => 'required|numeric',
        ]);
        $existed = employesEnBranchement::where('branchement_id', '=', $request->branchement_id)->where('employe_id', '=', $request->employe_id)->first();
        if ($existed) {

            return response()->json(['message' => 'cet employé est déjà ajouté'], 500);
        } else {
            $eib = new employesEnBranchement();
            $eib->branchement_id = $request->branchement_id;
            $eib->employe_id = $request->employe_id;
            $process = $eib->save();
            if ($process) {
                return response()->json(['message' => 'l\'employé a été ajouté avec succès'], 200);
            }
        }
    }

    public function getItemPrice(Request $request)
    {
        $item = warehouse::where('article_id', '=', $request->id)
            ->with(['article:id,name'])
            ->where('quantity', '>', 0)
            ->orderBy('created_at', 'ASC')
            ->first();
        if ($item) {
            return response()->json(['item' => $item], 200);
        } else {
            return response()->json(['message' => 'cet article n\'est pas disponible en entrepôt'], 400);
        }
    }

    public function create()
    {
        $categories  = marketCategory::where('market_id', '=', $this->market_id)
            ->select(['id', 'name'])
            ->get();

        $cities  = marketCity::where('market_id', '=', $this->market_id)
            ->select(['id', 'name'])
            ->get();

        return response()->json(['categories' => $categories, 'cities' => $cities]);
    }

    public function getBranchementArticles(Request $request)
    {
        $articles  = marketArticle::where('market_category_id', '=', $request->id)
            ->select(['id', 'display_name'])
            ->get();
        return response()->json(['articles' => $articles]);
    }

    public function delete(Request $request)
    {
        $branchement = branchement::findOrFail($request->id);
        $branchement->delete();

        if ($request->change_warehouse) {
            $articles = articleEnBranchement::where('branchement_id', '=', $request->id)->get();
            foreach ($articles as $article) {
                $warehouse = warehouse::where('id', '=', $article->warehouse_id)->first();
                $article->delete();
                $warehouse->quantity += 1;
                $warehouse->update();
            }
        }
        return response()->json(['message' => 'Branchement a été supprimé avec succès']);
    }
}

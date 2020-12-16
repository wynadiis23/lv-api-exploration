<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\FilmCategory;
use Illuminate\Support\Facades\DB;

class ApiController extends Controller
{
    //get list category with sum of the certain category
    public function getListCountCategory()
    {
        $listCatCount = DB::table('category')
                        ->join('film_category', 'film_category.category_id', '=', 'category.category_id')
                        ->select(DB::raw('category.name, count(*)'))
                        ->groupBy('category.name')
                        ->get();
        
        return response()->json([
            'success' => true,
            'message' => 'Jumlah berdasarkan kategory film',
            'data' => $listCatCount
        ]);
    }
}

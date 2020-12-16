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
                        ->select(DB::raw('category.name, count(*)'))
                        ->innerJoin()
    }
}

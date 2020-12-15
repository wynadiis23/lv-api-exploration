<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Film;
use Illuminate\Support\Facades\DB;

class FilmController extends Controller
{
    //
    public function getLengthGroupBy ()
    {
        $length = DB::table('film')
            ->select(DB::raw('length, count(length)'))
            ->groupBy('length')
            ->orderByRaw('length ASC')
            ->get();

        return response()->json([
            'success' => true,
            'message' => 'list of film length and count',
            'data' => $length
        ]);
    }
}

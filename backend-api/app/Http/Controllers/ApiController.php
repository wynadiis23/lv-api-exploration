<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\FilmCategory;
use App\Models\Payment;
use App\Models\Customer;


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

    //get customer total amount payment per id
    public function getTotalMostAmountPaymentId()
    {
        $listTotalAmount = DB::table('customer')
                            ->join('payment', 'customer.customer_id', '=', 'payment.customer_id')
                            ->select(DB::raw('customer.customer_id, customer.first_name, customer.last_name, SUM(payment.amount)'))
                            ->groupBy('customer.customer_id')
                            ->orderByDesc(DB::raw('SUM(payment.amount)'))
                            ->limit(5)
                            ->get();

        return response()->json([
            'success' => true,
            'message' => 'Amount of payment per ID',
            'data' => $listTotalAmount
        ]);

    }

    //total payment
    public function getTotalPayment()
    {
        $totalPayment = DB::table('payment')
                        ->select(DB::raw('SUM(amount)'))
                        ->get();

        return response()->json([
            'success' => true,
            'message' => 'Total payment',
            'data' => $totalPayment
        ]);
    }
}

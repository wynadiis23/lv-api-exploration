<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\FilmCategory;
use App\Models\Payment;
use App\Models\Customer;
use App\Models\Rental;

use Illuminate\Support\Facades\Validator;
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

    //get customer's country list
    public function getCustomerCountryList()
    {
        $customerCountryList = DB::table('country')
                                ->join('city', 'country.country_id', '=', 'city.country_id')
                                ->join('address', 'city.city_id', '=', 'address.city_id')
                                ->join('customer', 'customer.address_id', '=', 'address.address_id')
                                ->select(DB::raw('country.country, COUNT(customer.*)'))
                                ->groupBy('country.country')
                                ->orderBy('country')
                                ->get();

        return response()->json([
            'success' => true,
            'message' => 'Customers country list',
            'data' => $customerCountryList
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

    //rental API
    public function  getRentalCount()
    {
        $totalRental = DB::table('rental')
                    ->select(DB::raw('COUNT(rental_id)'))
                    ->get();

        return response()->json([
            'success' => true,
            'message' => 'Total rental',
            'data' => $totalRental
        ]);
    }
    //rental count perday
    public function getRentalCountPerDay(Request $req)
    {
        //set validation
        $validator = Validator::make($req->all(), [
            'year' => 'required',
        ]);
        $countPerDay = DB::table('rental')
                    ->select(DB::raw('DATE(rental_date), COUNT(rental_id)'))
                    ->whereYear('rental_date', '=', $req->year)
                    ->groupBy(DB::raw('DATE(rental_date)'))
                    ->orderBy(DB::raw('DATE(rental_date)'))
                    ->get();

        return response()->json([
            'success' => true,
            'message' => 'Rental count perday',
            'data' => $countPerDay
        ]);
    }
    
}

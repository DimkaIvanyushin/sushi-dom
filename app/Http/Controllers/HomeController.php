<?php

namespace App\Http\Controllers;

use App\Like;
use App\Product;
use App\Category;
use App\Order;
use App\User;
use App\Http\Requests;
use Illuminate\Http\Request;
use DB;
use Auth;


class HomeController extends Controller
{
    public function __construct()
    {
    
    }

    public function index()
    {
        return view('welcome', [
            'products' => Product::simplePaginate(24),
            'categories' => Category::get()
        ]);   
    }
}
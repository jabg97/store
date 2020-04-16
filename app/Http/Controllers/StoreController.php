<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Model\Product;
use Illuminate\Support\Facades\View;

class StoreController extends Controller
{
    public function __construct()
    {
    }

    public function index()
    {
        $products = Product::paginate(6);
        return View::make('store.index')->with(compact('products'));
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\menu;
use Illuminate\Http\Request;
use App\Functions;
class HomeController extends Controller
{

    public function index(Request $request)
    {
        return view('welcome', [
            'menu' => Functions::showCategories(),
            'bestseller' => Functions::bestseller(),
            'sel_lout' => Functions::sel_lout(),
            'new_products' => Functions::new_product(),
            'totals' => Functions::getTottals(),
            'fields' => Functions::getFields()
        ]);
    }
}

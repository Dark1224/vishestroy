<?php

namespace App\Http\Controllers;

use App\Functions;
use App\Models\menu;
use App\Models\products;
use App\values;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function get_category($id){
        $menu_info = menu::find($id);
        $filter = values::where('fieldId', 1)->get();

        if (!Functions::hasChildren($id)){
            $products = products::where('category', $id)->orderBy('name')->simplePaginate(16);
            return view('category', [
                'menu' => Functions::showCategories() ,
                'menu_info' => $menu_info,
                "products" => $products,
                'totals' => Functions::getTottals(),
                'fields' => Functions::getFields(),
                'manufacturer' => $filter
                ]);
        } else{
            return view('parentC', ['menu' => Functions::showCategories() ,'menu_info' => $menu_info, 'children' => Functions::getChildrenCategory($id), 'totals' => Functions::getTottals(),'fields' => Functions::getFields(), 'manufacturer' => $filter]);
        }
    }
    public function scopeFilter($q)
    {
        if (request('price_from')) {
            $q->where('price', '>=', request('min_price'))->simplePaginate(9);
        }
        if (request('color')) {
            $q->where('price', '<=', request('max_price'))->simplePaginate(9);
        }

        return $q;
    }
    public function filter_products(Request $request){
        $products = products::all();
        $fields = values::where('fieldId', 2)->get();
        $res_fields = [];
        foreach($fields as $key => $val){
            $res_fields[$val->id] = $val->name;
        }
        if ($request->category_id) {
            if($request->category_id == 'bestseller'){
                $products = $products->where('bestseller', 1);
            }elseif ($request->category_id == 'sel_lout'){
                $products = $products->where('sel_lout', 1);
            }elseif ($request->category_id == 'new'){
                $products = $products->where('new', 1);
            }else{
                $products = $products->where('category', $request->category_id);
            }
        }
        if ($request->min_price) {
            $products = $products->where('price', '>=', $request->min_price);
        }
        if ($request->max_price) {
            $products = $products->where('price', '<=', $request->max_price);
        }
        if ($request->manufacturer) {
            $products = $products->whereIn('manufacturer', $request->manufacturer);
        }
        return Response([$products, $res_fields]);
    }
}

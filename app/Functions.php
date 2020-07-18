<?php


namespace App;
use App\Models\menu;
use App\Models\products;
use Illuminate\Support\Facades\Auth;

class Functions
{
    public static function get_product($id)
    {
        if($id == 0) return;
        $fields = values::where('fieldId', 2)->get();
        $res_fields = [];
        foreach($fields as $key => $val){
            $res_fields[$val->id] = $val->name;
        }
        $fields = Functions::getFields();
        $product = products::find($id);
        if(isset($product->manufacturer) && $product->manufacturer != null && $product->manufacturer != 0){
            $product->manufacturer = $fields[$product->manufacturer];
        }else{
            $product->manufacturer = '-';
        }
        if($product->unit != 0){
            $product->unit = $fields[$product->unit];
        }else{
            $product->unit = '-';
        }
        return $product;
    }


    public static function hasChildren($id){
        $menu =  menu::where('parent_id', $id)->orderBy('id')->get();
        if($menu->count() > 0){
            return true;
        }
        return false;
    }

    public static function getChildrenCategory($id, $arr = []){
        $menu = menu::where('parent_id', $id)->orderBy('id')->get();
        foreach($menu as $key => $val){
            $arr['children'][] = $val;
            if(functions::hasChildren($val->id)){
                functions::getChildrenCategory($val->id, $arr);
            }
        }
        return $arr;
    }
    public static function showCategories(){


        $parent =  menu::where('parent_id', 0)->get();
        foreach($parent as $key => $val){
            $main_menu[] = functions::getChildrenCategory($val->id, ['parent' => $val]);
        }
        if(empty($main_menu)){
            $main_menu = array();
        }
        return $main_menu;
    }
    public static function get_comparison_products($id){
        $product = products::find($id);
        return $product;
    }
    public static function getFields(){
        $fields = values::all();
        $data = [];
        foreach ($fields as $key => $val){
            $data[$val->id] = $val->name;
        }
        return $data;
    }
    public static function getTottals(){
        $total_qty = 0;
        $total_price = 0;

        if (Auth::check()) {
            $user = User::find(Auth::id());
            $product = json_decode($user->cart);
            if($product !== null && $product !== ''){
                foreach($product as $key => $val){
                    $prd = Functions::get_comparison_products($val->product_id);
                    $total_price += $prd->price * $val->qty;
                    $total_qty += $val->qty;
                }
            }
        }else{
            if(session()->has('cart')){
                $product = json_decode(session()->get('cart'));
            }else{
                $product = null;
            }
            if($product !== null){
                foreach($product as $key => $val){
                    $prd = Functions::get_comparison_products($val->product_id);
                    if($prd != null){
                        $total_price +=  $prd->price * $val->qty;
                        $total_qty += $val->qty;
                    }
                }
            }
        }
        return ['total_price' => $total_price, 'total_qty' => $total_qty];
    }
    public static function bestseller() {
        $products = products::where('bestseller', 1)->take(5)->orderBy('id')->get();
        return $products;
    }
    public static function sel_lout() {
        $products = products::where('sel_lout', 1)->take(5)->orderBy('id')->get();
        return $products;
    }
    public static function new_product() {
        $products = products::where('new', 1)->take(5)->orderBy('id')->get();
        return $products;
    }
    public static function getBuyHistory(){
        if (Auth::check()) {
            $user = User::find(Auth::id());
            $checkout = $user->checkout;
            return $checkout;
        }
    }
}

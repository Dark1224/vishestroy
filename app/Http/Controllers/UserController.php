<?php

namespace App\Http\Controllers;

use App\Functions;
use App\Models\Delivery;
use App\Models\products;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use App\User;
use App\BitrixQuery;

class UserController extends Controller
{
    public function addToCart(Request $request){
        $r_products = products::find($request->product);
        if (Auth::check()) {
            $user = User::find(Auth::id());
            $product = json_decode($user->cart, true);
            if($product == null){
                $product = [];
            }
            $key = array_search($request->product, array_column($product, 'product_id'));

            if($key === false) {
                $product[] = ['product_id' => $request->product, 'qty' => $request->qty];
                $user->cart = json_encode($product);
            }else{
                $product[$key]['qty'] = intval($product[$key]['qty'])  +  intval($request->qty);
                $user->cart = json_encode($product);
            }
            $user->save();
            echo $r_products->price;
        }else{
           $product = json_decode($request->session()->get('cart'), true);
           if($product == null){
               $product = [];
           }
            $key = array_search($request->product, array_column($product, 'product_id'));
            if($key === false){
                $product[] = ['product_id' => $request->product, 'qty' => $request->qty];
                $request->session()->put('cart', json_encode($product));
            }else{
                $product[$key]['qty'] = intval($product[$key]['qty'])  +  intval($request->qty);
                $request->session()->put('cart', json_encode($product));
            }
            echo $r_products->price;

        }
    }
    public function get_comparison_products($id){
        $product = products::find($id);
        return $product;
    }
    public function addToWhishList(Request $request){
        if (Auth::check()) {
            $user = User::find(Auth::id());
            $product = json_decode($user->wish_list, true);
            $product[] = $request->product;
            $user->wish_list = json_encode($product);
            $user->save();
            echo 1;
        }else{
            if($request->session()->has('wish_list')){
                $product = json_decode($request->session()->get('wish_list'));
            }else{
                $product = [];
            }
            $product[] = $request->product;
            $request->session()->put('wish_list', json_encode($product));
            echo 1;
        }
    }
    public function addToComparison(Request $request){
            if($request->session()->has('comparison')){
                $product = json_decode($request->session()->get('comparison'), true);
            }else{
                $product = [];
            }
            $product[] = $request->product;
            $request->session()->put('comparison', json_encode($product));
            echo 1;
    }
    public function comparison_page(Request $request){
        if($request->session()->has('comparison')){
            $comparison = json_decode($request->session()->get('comparison'));
        }else{
            $comparison = null;
        }
        $comparison_arr = [];
        if($comparison !== null){
            foreach($comparison as $key => $val){
                $val = $this->get_comparison_products($val);
                if($val !== null){
                    $comparison_arr[] = $val;
                }
            }
        }

        return view('comparison', ['menu' => Functions::showCategories(),'fields' => Functions::getFields(), 'totals' => Functions::getTottals() ,'comparison' => $comparison_arr]);
    }
    public function cart_page(Request $request){
        $product_arr = [];
        $total_qty = 0;
        $total_price = 0;

        if (Auth::check()) {
            $user = User::find(Auth::id());
            $product = json_decode($user->cart);
            if($product !== null && $product !== ''){
                foreach($product as $key => $val){
                    $prd = $this->get_comparison_products($val->product_id);
                    $product_arr[$key]['product'] = $prd;
                    $total_price += $prd->price * $val->qty;
                    $product_arr[$key]['qty'] = $val->qty;
                    $total_qty += $val->qty;
                }
            }
        }else{
            if($request->session()->has('cart')){
                 $product = json_decode($request->session()->get('cart'));
            }else{
                $product = null;
            }
            if($product !== null){
                foreach($product as $key => $val){
                    $prd = $this->get_comparison_products($val->product_id);
                    if($prd != null){
                        $product_arr[$key]['product'] = $prd;
                        $product_arr[$key]['qty'] = $val->qty;
                        $total_price +=  $prd->price * $val->qty;
                        $total_qty += $val->qty;
                    }
                }
            }
        }

        return view('cart', [
            'menu' => Functions::showCategories(),
            'fields' => Functions::getFields(),
            'totals' => Functions::getTottals(),
            'products' => $product_arr,
            'total_qty' => $total_qty,
            'total_price' => $total_price
        ]);
    }

    public static function removeFromCart(Request $request){
        if ($request->product == 'all') {
            if (Auth::check()) {
                $user = User::find(Auth::id());
                $product = [];
                $user->cart = json_encode($product);
                $user->save();
                echo 1;
            }else{
                $product = [];
                $request->session()->put('cart', json_encode($product));
                echo 1;
            }
        }
        if (Auth::check()) {
            $user = User::find(Auth::id());
            $product = json_decode($user->cart, true);
            unset($product[$request->product]);
            $user->cart = json_encode($product);
            $user->save();
            echo 1;
        }else{

            $product = json_decode($request->session()->get('cart'), true);
            $price = products::where('id', $product[$request->product]['product_id'])->get('price');
            $main_res = ['qty' => $product[$request->product]['qty'], 'price' => $price[0]->price];

            unset($product[$request->product]);
            // $product = [];
             $request->session()->put('cart', json_encode($product));
             return Response($main_res);
        }
    }

    public function getPersonalPage(){
        $orders = Delivery::where('user_id',Auth::id())->simplePaginate(10);

        return view('user.dashboard', [
            'menu' => Functions::showCategories(),
            'totals' => Functions::getTottals(),
            'fields' => Functions::getFields(),
            'user' => User::find(Auth::id()),
            'orders' => $orders
            ]);
    }
    public function getOrderByUid(Request $request){
        $order = Delivery::where('uid', $request->uid)->get()[0];
       $products = json_decode($order->products, true);
        foreach ( $products as $key => $val){
            $product = Functions::get_product($val['id']);
            $products[$key]['products'] = $product;
        }
        $order->products = json_encode($products);
        return Response(['result'=>$order]);
    }
    public function saveConfig(Request $request){
        $user = User::find(Auth::id());
        if(
               !empty($request->individual['name']) && $request->individual['name'] != ''
            && !empty($request->individual['surname']) && $request->individual['surname'] != ''
            && !empty($request->individual['email']) && $request->individual['email'] != ''
            && !empty($request->individual['tel']) && $request->individual['tel'] != ''
        ){
            BitrixQuery::callMethod("crm.lead.update", [
                'id' => $user->bx_id,
                'fields' => [
                    'TITLE' => $request->individual['name']. ' ' . $request->individual['surname'],
                    'NAME' => $request->individual['name'],
                    'LAST_NAME' => $request->individual['surname'],
                    'EMAIL' => [ 'VALUE' => $request->individual['email'], 'VALUE_TYPE' => 'WORK' ]
                ]
            ]);
            $user->name =      $request->individual['name'];
            $user->last_name = $request->individual['surname'];
            $user->email =     $request->individual['email'];
            $user->tel =       $request->individual['tel'];
            $user->avatar =    $request->image;
            
        }else{
            return Response(['error' => 'Не все поля заполненны']);
        }
        if(
            !empty($request->legal['surname']) && $request->legal['surname'] != ''
            && !empty($request->legal['name']) && $request->legal['name'] != ''
            && !empty($request->legal['email']) && $request->legal['email'] != ''
            && !empty($request->legal['tel']) && $request->legal['tel'] != ''
            && !empty($request->legal['additional_tel']) && $request->legal['additional_tel'] != ''
            && !empty($request->legal['organization_type']) && $request->legal['organization_type'] != ''
            && !empty($request->legal['organization_name']) && $request->legal['organization_name'] != ''
//            && !empty($request->legal['okpo']) && $request->legal['okpo'] != ''
            && !empty($request->legal['postal_address']) && $request->legal['postal_address'] != ''
            && !empty($request->legal['adress']) && $request->legal['adress'] != ''
            && !empty($request->legal['director']) && $request->legal['director'] != ''
            && !empty($request->legal['bank']) && $request->legal['bank'] != ''
            && !empty($request->legal['bik']) && $request->legal['bik'] != ''
            && !empty($request->legal['ks']) && $request->legal['ks'] != ''
            && !empty($request->legal['rs']) && $request->legal['rs'] != ''
        ){
            $user->name =                $request->legal['name'];
            $user->last_name =           $request->legal['surname'];
            $user->email =               $request->legal['email'];
            $user->tel =                 $request->legal['tel'];
            $user->additional_tel =      $request->legal['additional_tel'];
            $user->org_type =            $request->legal['organization_type'];
            $user->org_name =            $request->legal['organization_name'];
            $user->okpo =                $request->legal['okpo'];
            $user->postal_address =      $request->legal['postal_address'];
            $user->leagal_address =      $request->legal['adress'];
            $user->director =            $request->legal['director'];
            $user->bank =                $request->legal['bank'];
            $user->bik =                 $request->legal['bik'];
            $user->ks =                  $request->legal['ks'];
            $user->rs =                  $request->legal['rs'];
        }

        $user->save();
            return Response(['success' => 'true']);
    }

    public function removeFromWishlist(Request $request){
        if (Auth::check()) {
            $user = User::find(Auth::id());
            $product = json_decode($user->wish_list, true);
            $product = array_diff($product, [$request->product]);
            $user->wish_list = json_encode($product);
            $user->save();
            echo 1;
        }else{
            $product = json_decode($request->session()->get('wish_list'), true);
            $product = \array_diff($product, [$request->product]);
             $request->session()->put('wish_list', json_encode($product));
            echo 1;
        }
    }
    public function removeFromComparison(Request $request){
            $product = json_decode($request->session()->get('comparison'), true);
            $product = \array_diff($product, [$request->product]);
             $request->session()->put('comparison', json_encode($product));
            echo 1;
    }
    public function wishlist_page(Request $request){
        $product_arr = [];

        if (Auth::check()) {
            $user = User::find(Auth::id());
            $product = json_decode($user->wish_list);
            if($product !== null && $product !== ''){
                foreach($product as $key => $val){
                    $prd = $this->get_comparison_products($val);
                    $product_arr[$key]['product'] = $prd;
                }
            }
        }else{
            if($request->session()->has('wish_list')){
                 $product = json_decode($request->session()->get('wish_list'));
            }else{
                $product = null;
            }
            if($product !== null){
                foreach($product as $key => $val){
                    $prd = $this->get_comparison_products($val);
                    if($prd != null){
                        $product_arr[$key]['product'] = $prd;
                    }
                }
            }
        }

        return view('wishlist', ['menu' => Functions::showCategories(),'fields' => Functions::getFields(), 'products' => $product_arr, 'totals' => Functions::getTottals()]);
    }

    public function getAllFromCache(Request $request){
        $wishlist = [];
        $comparison = [];
        $cart = [];
        if (Auth::check()) {
            $user = User::find(Auth::id());
            if(json_decode($user->wish_list, true) !== null && json_decode($user->wish_list) !== ''){
                foreach(json_decode($user->wish_list, true) as $key => $val){
                    $wishlist[] = $this->get_comparison_products($val);
                }
            }
            if(json_decode($user->cart, true) !== null && json_decode($user->cart) !== ''){
                foreach(json_decode($user->cart, true) as $key => $val){
                    $prd = $this->get_comparison_products($val['product_id']);
                    $qrt = $val['qty'];
                    if($prd != null){
                        $cart[$key]['product'] = $prd;
                        $cart[$key]['qty'] = $qrt;
                    }
                }
            }

        }else{
            if ($request->session()->has('wish_list')) {

                $product = json_decode($request->session()->get('wish_list'), true);

                if($product !== null){
                    foreach($product as $key => $val){
                        $prd = $this->get_comparison_products($val);
                        if($prd != null){
                            $wishlist[] = $prd;
                        }
                    }
                }
            }
            if ($request->session()->has('cart')) {
                $cart_arr = json_decode($request->session()->get('cart'));
                if($cart_arr !== null){
                    foreach($cart_arr as $key => $val){
                        $prd = $this->get_comparison_products($val->product_id);
                        $qrt = $val->qty;
                        if($prd != null){
                            $cart[$key]['product'] = $prd;
                            $cart[$key]['qty'] = $qrt;
                        }
                    }
                }
            }
        }
        if ($request->session()->has('comparison')) {
            if(json_decode($request->session()->get('comparison'), true) !== null){
                foreach(json_decode($request->session()->get('comparison'), true) as $key => $val){
                    $comparison[] = $this->get_comparison_products($val);
                }
            }
        }
        return Response (array('wishlist' => $wishlist, 'comparison' => $comparison, 'cart' => $cart));
    }
}

<?php

namespace App\Http\Controllers;

use App\Functions;
use App\Models\Delivery;
use App\Models\products;
use App\values;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use App\User;
use Mail;
use App\BitrixQuery;

class PagesController extends Controller
{
  public static $email = '';
    public function about_delivery(){
        return view('about_delivery',  [
            'menu' => Functions::showCategories(),
            'totals' => Functions::getTottals(),
            'fields' => Functions::getFields()
        ]);
    }
    public function payment(){
        return view('payment',  [
            'menu' => Functions::showCategories(),
            'totals' => Functions::getTottals(),
            'fields' => Functions::getFields()
        ]);
    }
    public function getAbout(){
        return view('aboutUs',  [
            'menu' => Functions::showCategories(),
            'totals' => Functions::getTottals(),
            'fields' => Functions::getFields()
        ]);
    }
    public function success(Request $request){
      echo $request->orderId;

      $endpoint2 = "https://3dsec.sberbank.ru/payment/rest/getReceiptStatus.do?userName=gig-stroy-api&password=gig-stroy&orderId=$request->orderId";
      $curl2 = curl_init();
      curl_setopt_array($curl2, array(
        CURLOPT_URL => $endpoint2,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_TIMEOUT => 30000,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => array(
          // Set Here Your Requesred Headers
          'Content-Type: application/x-www-form-urlencoded',
        ),
      ));
      $response2 = curl_exec($curl2);
      $err2 = curl_error($curl2);
      curl_close($curl2);

      if ($err2) {
        echo "cURL Error #:" . $err2;
      } else {
        Mail::send('emails.receipt', ['response' => $response2], function ($message) {
          $message->from('gig-stroy@mail.ru', 'Sender');
          $message->to(User::find(Auth::id())->email, 'Receiver')->subject('Чек');
        });
      }

    }
    
    public function pay(Request $request){
        $request->price = floatval($request->price) * 100;
        $endpoint = "https://3dsec.sberbank.ru/payment/rest/register.do?userName=gig-stroy-api&password=gig-stroy&currency=643&orderNumber=$request->uid&amount=$request->price&language=ru&returnUrl=https://gig-stroy.ru/success";
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $endpoint,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_TIMEOUT => 30000,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                // Set Here Your Requesred Headers
                'Content-Type: application/x-www-form-urlencoded',
            ),
        ));
        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
         if(isset(json_decode($response)->errorCode)) {
           $order = Delivery::where('uid', $request->uid)->first();
           $orderUpdate = Delivery::find($order->id);
           if ($orderUpdate->uuid !== "" && $orderUpdate->formUrl !== "") {
             return Response(['redirect' => $orderUpdate->formUrl]);
           }
           else return Response(['success' => $response]);
         }
         else {
           $this->changeDeliveryFields($request, $response);
           return Response(['success' => $response]);
         }
        }
    }

    public function changeDeliveryFields($request, $response) {
      $order = Delivery::where('uid', $request->uid)->first();
      $orderUpdate = Delivery::find($order->id);
      $orderUpdate->uuid = json_decode($response)->orderId;
      $orderUpdate->formUrl = json_decode($response)->formUrl;
      $orderUpdate->save();
    }

    public function getBestsellerPage(){
        return view('bestseller', [
            'menu' => Functions::showCategories(),
            'totals' => Functions::getTottals(),
            'fields' => Functions::getFields(),
            'products' => Functions::bestseller(),
            'manufacturer' => $filter = values::where('fieldId', 1)->get()
        ]);
    }

    public function getSelLoutPage(){
        return view('new', [
            'menu' => Functions::showCategories(),
            'totals' => Functions::getTottals(),
            'fields' => Functions::getFields(),
            'products' => Functions::sel_lout(),
            'manufacturer' => $filter = values::where('fieldId', 1)->get()
        ]);
    }

    public function getNewPage(){
        return view('selLout', [
            'menu' => Functions::showCategories(),
            'totals' => Functions::getTottals(),
            'fields' => Functions::getFields(),
            "products" =>  Functions::new_product(),
            'manufacturer' => $filter = values::where('fieldId', 1)->get()
        ]);
    }
    public function agreement_page (){
        return view('agreement', [
            'menu' => Functions::showCategories(),
            'totals' => Functions::getTottals(),
            'fields' => Functions::getFields()

        ]);
    }
    public function getMaxPrice (Request $request){
        $max = products::where('category', $request->category_id)->max('price');
        return Response(['success' => $max]);
    }

    public function get_comparison_products($id){
        $product = products::find($id);
        return $product;
    }
    public function getCheckoutPage(Request $request){
        if($request->session()->has('checkout_products')){

        }else{
            return redirect('/cart');
        }
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
            $user = [];
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
        $buyHistory = Functions::getBuyHistory();
        return view('checkout', [
            'menu' => Functions::showCategories(),
            'totals' => Functions::getTottals(),
            'fields' => Functions::getFields(),
            'user' => $user,
            'products' => $product_arr,
            'total_qty' => $total_qty,
            'total_price' => $total_price

        ]);

    }

    public function addProductsToSession(Request $request){
        $request->session()->put('checkout_products', $request->data);
        return Response(['success'=>true]);
    }
    public function addInfoToSession(Request $request){
        $request->session()->put('checkout_info', $request->data);
        return Response(['success'=>true]);
    }
    public function addDeliveryToSession(Request $request){
        $request->session()->put('checkout_delivery', $request->data);
        return Response(['success'=>true]);
    }


    public function getDeliveryPage(Request $request){
        $checkout_products = [];
        if($request->session()->has('checkout_products')){
            $checkout_products = $request->session()->get('checkout_products');
        }else{
            return redirect('/cart');
        }
        if($request->session()->has('checkout_info')){

        }else{
            return redirect('/checkout');
        }
        $total_price = 0;
        foreach (json_decode($checkout_products) as $product){
            $product_info = products::find($product->id);
            $total_price += floatval($product_info->price) * intval($product->qty);
        }
        $checkout_delivery = [];
        if($request->session()->has('checkout_delivery')){
            $checkout_delivery = json_decode($request->session()->get('checkout_delivery'), true)[0];
        }
//        dd($checkout_delivery);
        return view('delivery', [
            'menu' => Functions::showCategories(),
            'totals' => Functions::getTottals(),
            'fields' => Functions::getFields(),
            'total_price' => $total_price,
            'checkout_delivery' => $checkout_delivery
        ]);
    }
    public function getEndPage(Request $request){
        if($request->session()->has('checkout_products')){
            $checkout_products = $request->session()->get('checkout_products');
        }else{
            return redirect('/cart');
        }
        if($request->session()->has('checkout_delivery') && !empty($request->session()->get('checkout_delivery'))){

        }else{
            return redirect('/delivery');
        }
        $checkout_products = json_decode($request->session()->get('checkout_products'));
        $checkout_info = json_decode($request->session()->get('checkout_info'));
        $checkout_delivery = json_decode($request->session()->get('checkout_delivery'));
        $order_number = $checkout_delivery[0]->order_num;
        $total_price = 0;
        $total_qty = 0;
        $delivery_price = floatval($checkout_delivery[0]->delivery_price);

        self::$email = $checkout_info[0]->email;

        foreach ($checkout_products as $product){
            $product_info = products::find($product->id);
            $total_price += floatval($product_info->price) * intval($product->qty);
            $total_qty++;
        }
        
        $user_id = 0;
        if (Auth::check()) {
            $user_id = Auth::id();
        }
        $Delivery = Delivery::updateOrCreate(
            ['uid' => $order_number],
            [
                'user_id' => $user_id,
                'user_info' => $request->session()->get('checkout_info'),
                'delivery_info' => $request->session()->get('checkout_delivery'),
                'products' => $request->session()->get('checkout_products'),
                'total_price' => floatval($total_price) + floatval($delivery_price),
                'status' => 'Не оплаченно'
            ]
        );
        $request->session()->remove('checkout_info');
        $request->session()->remove('checkout_delivery');
        $request->session()->remove('checkout_products');
        if (Auth::check()) {
            $user = User::find(Auth::id());
            $product = [];
            $user->cart = json_encode($product);
            $user->save();
        }else{
            $product = [];
            $request->session()->put('cart', json_encode($product));
        }
        if (Auth::check()) {
            Mail::send('emails.message', ['order_number' => $order_number, 'delivery_price' => $delivery_price, 'total_qty' => $total_qty, 'total_price' => $total_price], function ($message) {
              $message->from('gig-stroy@mail.ru', 'Гиг Строй');
              $message->to(User::find(Auth::id())->email, 'Receiver')->subject('Ваш заказ принят!');
            });
        } else {
          Mail::send('emails.message', ['order_number' => $order_number, 'delivery_price' => $delivery_price, 'total_qty' => $total_qty, 'total_price' => $total_price], function ($message) {
            $message->from('gig-stroy@mail.ru', 'Гиг Строй');
            $message->to(self::$email, 'Receiver')->subject('Ваш заказ принят!');
          });
        }

        $id = BitrixQuery::callMethod("crm.lead.list", [
          'filter' => [
            'EMAIL' => self::$email
          ]
        ]);
        if (!isset($id)) {
          BitrixQuery::callMethod("crm.lead.add", [
            'fields' => [
              'TITLE' => $checkout_info[0]->name. " " .$checkout_info[0]->surname,
              'NAME' => $checkout_info[0]->surname,
              'LAST_NAME' => $checkout_info[0]->name,
              'PHONE' => [ ['VALUE' => $checkout_info[0]->tel, 'VALUE_TYPE' => 'WORK'] ],
              'EMAIL' => [ ['VALUE' => self::$email, 'VALUE_TYPE' => 'WORK'] ],
            ]
          ]);
        }
        
        return view('end', [
            'menu' => Functions::showCategories(),
            'totals' => Functions::getTottals(),
            'fields' => Functions::getFields(),
            'order_number' => $order_number,
            'delivery_price' => $delivery_price,
            'total_qty' => $total_qty,
            'total_price' => $total_price,
        ]);
    }
    public function ourContacts(Request $request){
        return view('ourContacts', [
            'menu' => Functions::showCategories(),
            'totals' => Functions::getTottals(),
            'fields' => Functions::getFields()

        ]);
    }
}

//
//array:1 [▼
//  0 => {#318 ▼
//    +"name": "Garik"
//    +"surname": "Grigoryan"
//    +"email": "garik9666@gmail.com"
//    +"tel": "041969620"
//    +"pay": "1"
//  }
//]
//array:1 [▼
//  0 => {#319 ▼
//    +"locality": "Московская область"
//    +"house": "14"
//    +"corps": "1"
//    +"apartment": "2"
//    +"receiver_name": ""
//    +"receiver_surname": ""
//    +"receiver_phone": ""
//    +"delivery_additional_info": "Позвонить"
//    +"coordinates": "56.161479, 37.174945"
//    +"delivery_price": "3840"
//  }
//]
//123

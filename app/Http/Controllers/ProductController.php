<?php

namespace App\Http\Controllers;

use App\Models\menu;
use App\Models\products;
use App\User;
use App\values;
use Illuminate\Http\Request;
use App\Functions;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;
use App\BitrixQuery;

class ProductController extends Controller
{


    public function addReview(Request $request){
        $validator = Validator::make($request->all(), [
            'rate' => ['required'],
            'review' => ['required']
        ], [
            'rate.required' => 'Оценка обязательна',
            'review.required' => 'Отзыв обязателен'
        ]);
        if ($validator->fails())
        {
            return response()->json(['errors'=>$validator->errors()]);
        }

        $cahce_rate = json_decode($request->session()->get('rate'));
        if($cahce_rate == ''){
            $cahce_rate = [];
        }
        if(!in_array($request->rate, $cahce_rate)) {
            $product = products::find($request->product_id);
            $rate = json_decode($product->rate);
            $rate[] = $request->rate;
            $total_rate = $this::rate($rate);
            $product->rate = json_encode($rate);;
            $cahce_rate[] = $request->rate;
            $request->session()->put('rate', json_encode($cahce_rate));
            // Cache::forever('rate', json_encode($cahce_rate));
            $user = User::find(Auth::id());
            $comment = json_decode($product->comments);
            $comment[] = ['user_id' => Auth::id(), 'rate' => $request->rate, 'review' => $request->review, 'date' => date('d.m.Y')];
            $product->comments = json_encode($comment);
            $product->save();
            return response()->json(['success' => $user, 'total_rate' => $total_rate, 'date' => date('d.m.Y')]);
        }else{
            return response()->json(['fail' => 'user already has commented this product']);
        }
    }
    public function get_product($id)
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

    public function add_product_to_bitrix(Request $request)
    {
      $data = json_decode($request->data);

      $product = products::find($data[0]->product_id);
      
      $contactID = BitrixQuery::callMethod("crm.contact.add", [
        'fields' => [
          'NAME' => $data[0]->name,
          'PHONE' => [ ['VALUE' => $data[0]->tel, 'VALUE_TYPE' => 'WORK'] ],
        ]
      ]);

      $dealID = BitrixQuery::callMethod("crm.deal.add", [
        'fields' => [
          'TITLE' => $data[0]->name,
          'CONTACT_ID' => $contactID,
          'OPPORTUNITY' => $product->price*$product->in_package,
          'CURRENCY_ID' => 'RUB',
          'UF_CRM_1585319762' => $product->name,
          'UF_CRM_1585319835' => $product->price,
          'UF_CRM_1585319890' => $product->in_package,
        ]
      ]);

      BitrixQuery::callMethod("crm.deal.contact.add", [
        'id' => $dealID,
        'fields' => [
          'CONTACT_ID' => $contactID,
        ]
      ]);
    }

    public function product_page($id)
    {
        $buy_whit = [];
        $similar = [];
        $product = products::find($id);
        if($product->buy_with != 'null') {
            foreach (json_decode($product->buy_with) as $key => $val) {
                $buy_whit[] = $this->get_product($val);
            }
        }
        if($product->similar != 'null'){
            foreach (json_decode($product->similar) as $key => $val){
                $similar[] = $this->get_product($val);
            }
        }
        $rate = $this::rate(json_decode($product->rate));
        $comments = json_decode($product->comments, true);
        $comments_arr = [];
        $comments = $comments == null ? [] : $comments;
        foreach ($comments as $key => $val){
            if(is_array($val)){
                $comments[$key]['user_id'] = User::find($val['user_id']);
            }else{
                $comments[$key]['user_id'] = User::find($val->user_id);
            }
        }
        return view('product', ['menu' => Functions::showCategories(), 'totals' => Functions::getTottals(),'fields' => Functions::getFields(), 'rate' => $rate, "product" => $product, 'buy_whit' => $buy_whit, 'similar' => $similar, 'comments' => $comments]);
    }
    public function rate($arr){
        if(is_array($arr)){
            $rate_length = count($arr);
            $total_rate = 0;
            foreach ($arr as $key => $val){
                $total_rate += $val;
            }
            return $total_rate / $rate_length;
        }else{
            return 0;
        }

    }
    public function addRate(Request $request){
        $cahce_rate = json_decode($request->session()->get('rate'));
        if(empty($cahce_rate) || $cahce_rate == ''){
            $product = products::find($request->id);
            $rate = json_decode($product->rate);
            $rate[] = $request->rate;
            $product->rate = json_encode($rate);
            $product->save();
            $cahce_rate[] = $request->rate;
            $request->session()->put('rate', json_encode($cahce_rate));
            // Cache::forever('rate',json_encode($cahce_rate));
            return  $request->rate;
        }
        if(!in_array($request->rate, $cahce_rate)){
            $product = products::find($request->id);
            $rate = json_decode($product->rate);
            $rate[] = $request->rate;
            $total_rate = $this::rate($rate);
            $product->rate = json_encode($rate);;
            $product->save();
            $cahce_rate[] = $request->rate;
            // Cache::forever('rate',json_encode($cahce_rate));
            $request->session()->put('rate', json_encode($cahce_rate));
            echo $total_rate;
        }else{
            echo false;
        }
    }

    public function searchProduct(Request $request){
        return Response(products::query()->where('name', 'LIKE', "%{$request->name}%")->orWhere('article', 'LIKE', "%{$request->name}%")->get());
    }



}

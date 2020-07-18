<?php


namespace App\Listeners;
use App\Models\products;
use App\User;
use Illuminate\Auth\Events\Login;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
class SaveCart
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    private $request;
    public function __construct(Request $request)
    {
        //
        $this->request = $request;
    }
    public function get_comparison_products($id){
        $product = products::find($id);
        return $product;
    }
    /**
     * Handle the event.
     *
     * @param  Login  $event
     * @return void
     */
    public function handle(Login $event)
    {
        $user_id = $event->user->id;
        $user = User::find($user_id);
        if($user != null){
            $product = json_decode($user->cart, true);
            if($product == null){
                $product = [];
            }

            if ($this->request->session()->has('cart')) {
                $cart_arr = json_decode($this->request->session()->get('cart'));
                if($cart_arr !== null){
                    foreach($cart_arr as $key => $val){
                        $prd = $val->product_id;
                        $qrt = $val->qty;
                        if($prd != null){
                            $cart[$key]['product'] = $prd;
                            $cart[$key]['qty'] = $qrt;
                            $key = array_search($prd, array_column($product, 'product_id'));

                            if($key === false) {
                                $product[] = ['product_id' => $prd, 'qty' => $qrt];
                            }else{
                                $product[$key]['qty'] = intval($product[$key]['qty'])  +  intval($qrt);
                            }
                        }
                    }
                    $user->cart = json_encode($product);
                    $user->save();
                }
            }
        }
    }
}

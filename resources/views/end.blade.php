@extends('layouts.app')

@section('content')
<article>
    <div class="container-fluid">
    	<div class="row justify-content-center">
    		<div class="col-lg-10 col-md-12">
                <div class="row checkout_range_links">
                    <div class="col-lg-3 col-md-3">
                        <a href="/cart" class="checkout_range_link rlink_1"><span class="checkout_numbers plnumber_1 active_plnumber">1</span>Корзина <i class="checkout_next_step_icon fas fa-chevron-right"></i></a>
                    </div>
                    <div class="col-lg-3 col-md-3">
                        <a href="/checkout" class="checkout_range_link rlink_2"><span class="checkout_numbers plnumber_2 active_plnumber">2</span>Личные данные <i class="checkout_next_step_icon fas fa-chevron-right"></i></a>
                    </div>
                    <div class="col-lg-3 col-md-3">
                        <a href="/delivery" class="checkout_range_link rlink_3 to_delivery"><span class="checkout_numbers plnumber_3 active_plnumber">3</span>Способ доставки <i class="checkout_next_step_icon fas fa-chevron-right"></i></a>
                    </div>
                    <div class="col-lg-3 col-md-3">
                        <a href="/end" class="checkout_range_link rlink_4 to_delivery to_end"><span class="checkout_numbers active_plnumber plnumber_4">4</span>Завершение <i class="checkout_last_step_icon fas fa-check"></i></a>
                    </div>
                </div>
            </div>
            <div class="col-lg-5 col-md-6 order_info_container">
                <div class="order_info">
                    <h3 class="checkout_page_headers">Ваш заказ принят</h3>
                    <p class="thanks_for_shopping">Спасибо за покупку !</p>
                    <p>Вы получите письмо на ваш адрес электронной почты с подробной информацией о заказе.</p>
                    <div class="purchase_number_container"><p>Номер вашего заказа: <span id="purchase_number"> {{$order_number}}</span></p></div>
                    <div class="product_position_number"><p>Количество позиций товаров: <span id="position_number"> {{$total_qty}}</span></p></div>
                    <div class="end_purchase_price_container"><p>Стоимость покупки: <span id="end_purchase_price"> {{$total_price}}<span> ₽</span></span></p></div>
                    <div class="end_delivery_price_container"><p>Стоимость доставки: <span id="end_delivery_price"> {{$delivery_price}}<span> ₽</span></span></p></div>
                    <div class="end_total_container"><p>Итого: <span id="end_total"> {{$delivery_price + $total_price}}<span> ₽</span></span></p></div>
                </div>
                @if (Route::has('login'))
                    @auth
                        <div class="to_orders m-auto">Перейти к заказам </div>
                 @else

                    @endauth
                 @endif

            </div>

    	</div>
    </div>
</article>
@endsection

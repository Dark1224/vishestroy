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
                        <a href="/delivery" class="checkout_range_link rlink_3 to_delivery"><span class="checkout_numbers active_plnumber plnumber_3">3</span>Способ доставки <i class="checkout_next_step_icon fas fa-chevron-right"></i></a>
                    </div>
                    <div class="col-lg-3 col-md-3">
                        <a href="/end" class="checkout_range_link rlink_4 to_delivery to_end"><span class="checkout_numbers plnumber_4">4</span>Завершение <i class="checkout_last_step_icon fas fa-check"></i></a>
                    </div>
                </div>
            </div>
            <div class="col-lg-5 col-md-6 col-sm-12 col-12 checkout_block_2">
                <h3 class="checkout_page_headers">Способы получения</h3>
                <nav>
                    <div class="checkout_nav_tabs nav nav-tabs" id="nav-tab" role="tablist">
                        <a class="checkout_nav_link nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home3" role="tab" aria-controls="nav-home3" aria-selected="true">Доставка</a>
                        <a class="checkout_nav_link nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile3" role="tab" aria-controls="nav-profile3" aria-selected="false">Самовывоз</a>
                    </div>
                </nav>
                <div class="checkout_tab_content tab-content" id="nav-tabContent">
                    <div class="checkout_tab_pane tab-pane fade show active" id="nav-home3" role="tabpanel" aria-labelledby="nav-home-tab">
                        <div class="row">

                            <div class="col-12 tab_pane_content">
                                <label for="locality"><span style="color: red;">*</span> Населенный пункт<input id="locality" type="text" name="locality" value="{{isset($checkout_delivery['locality']) ? $checkout_delivery['locality'] : ''}}"></label>
                                <span class="invalid-feedback" role="alert">
                                    <strong></strong>
                                </span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 tab_pane_content">
                                <label for="street"><span style="color: red;">*</span> Улица<input id="street" type="text" name="street" value="{{isset($checkout_delivery['street']) ? $checkout_delivery['street'] : ''}}"></label>
                                <span class="invalid-feedback" role="alert">
                                    <strong></strong>
                                </span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-4 tab_pane_content">
                                <label for="house"><span style="color: red;">*</span> Дом<input id="house" type="text" name="house" value="{{isset($checkout_delivery['house']) ? $checkout_delivery['house'] : ''}}"></label>
                                <span class="invalid-feedback" role="alert">
                                    <strong></strong>
                                </span>
                            </div>
                            <div class="col-4 tab_pane_content">
                                <label for="corps"><span style="color: red;">*</span> Корпус<input id="corps" type="text" name="corps" value="{{isset($checkout_delivery['corps']) ? $checkout_delivery['corps'] : ''}}"></label>
                                <span class="invalid-feedback" role="alert">
                                    <strong></strong>
                                </span>
                            </div>
                            <div class="col-4 tab_pane_content">
                                <label for="apartment"><span style="color: red;">*</span> Квартира<input id="apartment" type="text" name="apartment" value="{{isset($checkout_delivery['apartment']) ? $checkout_delivery['apartment'] : ''}}"></label>
                                <span class="invalid-feedback" role="alert">
                                    <strong></strong>
                                </span>
                            </div>
                        </div>
                         <div class="row">
                            <div class="col-6 tab_pane_content">
                                <label for="receiver_surname">Фамилия получателя<input id="receiver_surname" type="text" name="receiver_surname" value="{{isset($checkout_delivery['receiver_surname']) ? $checkout_delivery['receiver_surname'] : ''}}"></label>
                                <span class="invalid-feedback" role="alert">
                                    <strong></strong>
                                </span>
                            </div>
                            <div class="col-6 tab_pane_content">
                                <label for="receiver_name">Имя получателя<input id="receiver_name" type="text" name="receiver_name" value="{{isset($checkout_delivery['receiver_name']) ? $checkout_delivery['receiver_name'] : ''}}"></label>
                                <span class="invalid-feedback" role="alert">
                                    <strong></strong>
                                </span>
                            </div>
                        </div>
                        <div class="row">
                             <div class="col-12 tab_pane_content">
                                <label for="receiver_phone">Телефон получателя<input id="receiver_phone" type="text" name="receiver_phone" value="{{isset($checkout_delivery['receiver_phone']) ? $checkout_delivery['receiver_phone'] : ''}}"></label>
                                <span class="invalid-feedback" role="alert">
                                    <strong></strong>
                                </span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 tab_pane_content">
                                <label for="delivery_additional_info"> Дополнительная информация<textarea id="delivery_additional_info" rows="5" value="{{isset($checkout_delivery['delivery_additional_info']) ? $checkout_delivery['delivery_additional_info'] : ''}}"></textarea></label>
                                <span class="invalid-feedback" role="alert">
                                    <strong></strong>
                                </span>
                            </div>
                        </div>
                        <div class="row">
                            <input type="hidden" class="total_val" value="{{$total_price}}">
                            <input type="hidden" class="on" value="{{isset($checkout_delivery['order_num']) ? $checkout_delivery['order_num'] : time()}}">
                            <div class="col-12 delivery_price_container"><p id="delivery_price_text">Стоимость доставки: <span id="delivery_price">
                                        @if(isset($checkout_delivery['delivery_price']))
                                            {{$checkout_delivery['delivery_price']}}
                                        @else
                                            {{ $total_price >= 30000 ? 0 : 900}}
                                        @endif
                                    </span> <span id="del_price_currency">₽</span></p></div>
                        </div>
                    </div>

                    <div class="checkout_tab_pane tab-pane fade" id="nav-profile3" role="tabpanel" aria-labelledby="nav-profile-tab">
                        <div class="row">
                            <div class="col-12 tab_pane_content pickup_adress_container"><input id="pickup_button" type="checkbox" name="pickup_button"> Москва, Химкинский бульвар, 13</div>
                        </div>
                         <div class="row pai_container">
                            <div class="col-12 tab_pane_content">
                                <label for="pickup_additional_info"> Дополнительная информация<textarea id="pickup_additional_info" rows="5"></textarea></label>
                                <span class="invalid-feedback" role="alert">
                                    <strong></strong>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-5 col-md-6 col-sm-12 col-12 checkout_block_3">
                <h3 class="checkout_page_headers">Указать адрес на карте</h3>
                 <div class="row coordinates_container">
                     <div class="col-12 tab_pane_content">
                        <label for="suggest"> Координаты<input id="suggest" type="text" name="coordinates" value="{{isset($checkout_delivery['coordinates']) ? $checkout_delivery['coordinates'] : ''}}"></label>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 map_container" id="map_container" style="width:auto; height:376px">
{{--                            <script type="text/javascript" charset="utf-8" async src="https://api-maps.yandex.ru/services/constructor/1.0/js/?um=constructor%3A76c9ff177db84ffe452e14abcdb9dc716a0e7a0190eaa31d42b25885cce3ebd9&amp;width=auto&amp;height=376&amp;lang=ru_RU&amp;scroll=true"></script>--}}
                    </div>
                </div>
            </div>
		</div>
        <div class="row justify-content-center next_step_btn_container">
            <div class="col-10 btn_container">
                <div class="next_step_button to_end">Далее <i class="further_icon fas fa-arrow-right"></i></div>
            </div>
        </div>
	</div>
</article>
@endsection

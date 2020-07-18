@extends('layouts.app')

@section('content')

    <article>
        <div class="container-fluid">
            <div class="page_header row justify-content-center">
                <div class="col-lg-10 col-md-12 col-sm-12">
                    <h1 class="page_header">Сравнение</h1>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-lg-10 col-md-12 col-sm-12">
                    <div class="comparision_container row justify-content-center">
                    @foreach($comparison as $key => $val)
                        <div class="comparision_content position-relative">
                            <div class="comparision_close_btn_block" data-id="{{$val->id}}">
                                <i title="Закрыть" class="comparision_close_btn fas fa-times"></i>
                            </div>
                            <div class="quick_view_block_1">
                                <span title="Добавить в избранное" class="qv_add_to_favorites" data-id="{{$val->id}}">В избранное<i class="qv_add_to_favorites_icon far fa-heart"></i></span>
                                <span title="Добавить в сравнение" class="qv_add_to_comparision" data-id="{{$val->id}}">В сравнение<i class="qv_add_to_comparison_icon fas fa-sync-alt"></i></span>
                                <span class="qv_vendor_code">
									<span class="qv_w_vendor_code">Артикул:</span>
									<span class="qv_vc">{{$val->aritcle}}</span>
								</span>
                                <h5 class="qv_product_name">{{$val->name}}</h5>
                            </div>
                            <div class="quick_view_block_2">
                                     <div class="pp_types main">
                                        @if($val->bestseller)
                                            <div class="pc_hit">Хит продаж!</div>
                                        @endif
                                        @if($val->sel_lout)
                                            <div class="pc_sale">Распродажа!</div>
                                        @endif
                                        @if($val->new)
                                            <div class="pc_new">Новинка!</div>
                                        @endif
                                    </div>
                                <div class="qv_big_img_block">
                                    <img src="{{json_decode($val->img_path)[0]}}">
                                </div>
                                <div class="qv_mini_img_block">
                                    @foreach(json_decode($val->img_path) as $img_key => $img_val)
                                        <div class="qv_mini_img img_1"><img src="{{$img_val}}" alt="{{$val->name}}" title="{{$val->name}}"></div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="quick_view_block_3">
                                <div class="short_description_block">
                                    <ul>
                                        <li><span class="des_a des_a_1">Производитель</span><span class="des_q des_q_1">{{ $val->manufacturer ? $fields[$val->manufacturer] : '-' }}</span></li>
                                        <li><span class="des_a des_a_2">Есть в наличии ?</span><span class="des_q des_q_2">{{$val->available === 1 ? 'да' : 'нет'}}</span></li>
                                        <li><span class="des_a des_a_4">Ед. измерения</span><span class="des_q des_q_3">{{ $fields[$val->unit] }}.</span></li>
                                        <li><span class="des_a des_a_3">В упаковке, шт.</span><span class="des_q des_q_4">{{$val->in_package}}</span></li>
                                        @foreach(json_decode($val->additional) as $add_key => $add_val)
                                            <li><span class="des_a des_a_5">{{$add_val->desc}}</span><span class="des_q des_q_5">{{$add_val->val}}</span></li>
                                        @endforeach
                                    </ul>
                                </div>
                                <div class="pp_buy_card">
                                    <div class="pp_deliveri_pickup_container">
                                        <div class="pp_delivery"><i class="pp_delivery_icon fas fa-truck-moving"></i>Доставка: <span class="pp_delivery_tod_tom">{{$val->delivery}}</span></div>
                                        <div class="pp_pickup"><i class="pp_pickup_icon fas fa-map-marker-alt"></i>Самовывоз: <a class="pp_pickup_link" href="#" title="Самовывоз"><span class="pp_pickup_tod_tom">{{$val->pickup}}</span></a></div>
                                    </div>
                                    <div class="pp_price_block">
                                        <div class="pp_piece_price">@if($val->old_price != 0)<del class="pp_old_price">{{$val->old_price}}<span class="pp_price_currency">р.</span></del>@endif <span class="pp_price">{{$val->price}}<span class="pp_price_currency">р.</span></span><span class="pp_piece">/ {{ $fields[$val->unit] }}.</span></div>

                                        <div class="pp_package_price">@if($val->old_price != 0)<del class="pp_old_package_price">{{$val->old_price * $val->in_package}}<span class="pp_package_price_currency">р.</span></del>@endif <span class="pp_package_price">{{$val->price * $val->in_package}}<span class="pp_price_currency">р.</span></span><span class="pp_package">/ уп.</span></div>
                                    </div>
                                    <div class="quantity_block">
                                        <span class="quantity_arrow_minus"><i class="fas fa-minus"></i></span>
                                        <input class="quantity_number" disabled="disabled" type="number" data-value="{{$val->in_package}}" value="{{$val->in_package}}" size="9999">
                                        <span class="quantity_arrow_plus"><i class="fas fa-plus"></i></span>
                                    </div>
                                    <div class="add_to_cart_block">
                                        <div class="pp_add-to-cart_btn" title="Добавить в корзину" data-id="{{$val->id}}">В корзину</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="com_btn_container col-lg-10 col-md-12 col-sm-12">
                    <div class="com_clear_btn"><i class="com_clear_icon fas fa-trash-alt"></i>Очистить все</div>
                </div>
            </div>
        </div>
    </article>
@endsection

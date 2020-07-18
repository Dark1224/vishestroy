@extends('layouts.app')

@section('content')
    <article>
        <div class="container-fluid">
            <div class="page_header row justify-content-center">
                <div class="col-lg-10 col-md-12 col-sm-12">
                    <h1 class="page_header">{{$product->name}}</h1>
                </div>
            </div>
            <div class="product_page row">
                <div class="col-lg-6 col-md-7">
                    <div class="product_info col-12 p-0">
							<span class="vendor_code">
								<span class="w_vendor_code">Артикул:</span>
								<span class="pp_vc">{!! str_replace('"', '', $product->article) !!}</span>
							</span>
                        <span >
								<span data-id="{{$product->id}}" data-rate="{{$rate}}">
                                    @for($i = 1; $i <= 5; $i++)
                                        <i class="{{ $rate >= $i ? 'fa' : 'far'}} fa-star" style="{{ $rate >= $i ? 'color: #f18701' : ''}}" data-id="{{$i}}"></i>
                                    @endfor
                                </span>
								<span class="rating"><a href="#profile-tab"><span class="number_of_rated">{{count($comments)}}</span> отзыв</a></span>

							</span>
                    </div>
                    <div class="row">
                        <div class="mini_img_block col-md-2 col-sm-2 col-2">
                            @foreach(json_decode($product->img_path) as $img_key => $img_val)
                            <div class="mini_img img_{{$img_key}}"><img src="{{$img_val}}" alt="" title=""></div>
                            @endforeach
                        </div>
                        <div class="big_img_block col-md-10 col-sm-10 col-10">
                            <div class="tile" data-scale="2.0" data-image="{{json_decode($product->img_path)[0]}}"></div>
                            <div class="pp_types">
                                @if($product->bestseller)
                                    <div class="pc_hit">Хит продаж!</div>
                                @endif
                                @if($product->sel_lout)
                                    <div class="pc_sale">Распродажа!</div>
                                @endif
                                @if($product->new)
                                    <div class="pc_new">Новинка!</div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-5">
                    <div class="pp_ib_block p-0 col-md-12">
                        <div class="add-to_page_block">
                            <span title="Добавить в избранное" class="pp_add_to_favorites dont_rm" data-id="{{$product->id}}">В избранное<i class="pp_add_to_favorites_icon far fa-heart"></i></span>
                            <span title="Добавить в сравнение" class="pp_add_to_comparision" data-id="{{$product->id}}">В сравнение<i class="pp_add_to_comparison_icon fas fa-sync-alt"></i></span>
                        </div>
                        <div class="pp_buy_card">
                            <div class="pp_deliveri_pickup_container">
                                <div class="pp_delivery"><i class="pp_delivery_icon fas fa-truck-moving"></i>Доставка: <span class="pp_delivery_tod_tom">{{$product->delivery}}</span></div>
                                <div class="pp_pickup"><i class="pp_pickup_icon fas fa-map-marker-alt"></i>Самовывоз: <a class="pp_pickup_link" href="#" title="Самовывоз"><span class="pp_pickup_tod_tom">{{$product->pickup}}</span></a></div>
                            </div>
                            <div class="pp_price_block">
                                <div class="pp_piece_price">@if($product->old_price != 0)<del class="pp_old_price">{{$product->old_price}}<span class="pp_price_currency">р.</span></del>@endif <span class="pp_price">{{$product->price}}<span class="pp_price_currency">р.</span></span><span class="pp_piece">/ {{ $fields[$product->unit] }}.</span></div>

                                <div class="pp_package_price"> @if($product->old_price != 0)<del class="pp_old_package_price">{{$product->old_price * $product->in_package}}<span class="pp_package_price_currency">р.</span></del>@endif <span class="pp_package_price">{{$product->price * $product->in_package}}<span class="pp_price_currency">р.</span></span><span class="pp_package">/ уп.</span></div>
                            </div>
                            <div class="quantity_block">
                                <span class="quantity_arrow_minus"><i class="fas fa-minus"></i></span>
                                <input class="quantity_number" type="number" disabled="disabled" data-value="{{$product->in_package}}" value="{{$product->in_package}}" size="9999">
                                <span class="quantity_arrow_plus"><i class="fas fa-plus"></i></span>
                            </div>
                            <div class="add_to_cart_block">
                                <div class="pp_add-to-cart_btn" data-id="{{$product->id}}" title="Добавить в корзину">В корзину</div>
                                <div class="pp_quick_order_btn" title="Быстрый заказ"  data-id="{{$product->id}}">Быстрый заказ</div>
                            </div>
                        </div>
                        <div class="short_description_block">
                            <ul>
                                <li><span class="des_a des_a_1">Производитель</span><span class="des_q des_q_1">{{ $product->manufacturer ? $fields[$product->manufacturer] : '-' }}</span></li>
                                <li><span class="des_a des_a_2">Есть в наличии ?</span><span class="des_q des_q_2">{{$product->available === 1 ? 'да' : 'нет'}}</span></li>
                                <li><span class="des_a des_a_4">Ед. измерения</span><span class="des_q des_q_3">{{ $fields[$product->unit] }}.</span></li>
                                <li><span class="des_a des_a_3">В упаковке, {{ $fields[$product->unit] }}.</span><span class="des_q des_q_4">{{ $product->in_package }}</span></li>
                                @foreach(json_decode($product->additional) as $additional_key => $additional_val)
                                <li><span class="des_a des_a_5">{{$additional_val->desc}}</span><span class="des_q des_q_5">{{$additional_val->val}}</span></li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="container-fluid">
                    <div class="row pp_nav_tabs justify-content-center">
                        <div class="col-lg-10">
                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link pp_nav_link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Описание</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link pp_nav_link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Отзывы</a>
                                </li>
                            </ul>
                            <div class="tab-content pp_tab_content" id="myTabContent">
                                <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">{{$product->description}}</div>
                                <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                                    <div class="review_list">
                                        @if (Route::has('login'))
                                            @auth
                                                <form>
                                                    <div>
                                                     <span class="invalid-feedback" style="display: block;" role="alert">
                                                        <strong class="rate"></strong>
                                                     </span>
                                                    <p>
                                                        <span style="color: red;">*</span>
                                                        Рейтинг
                                                        <span class="rating">
                                                            <span data-id="{{$product->id}}" data-rate="">
                                                                 @for($i = 1; $i <= 5; $i++)
                                                                    <i class="far fa-star" style="" data-id="{{$i}}"></i>
                                                                 @endfor
                                                                <input type="hidden" name="rate">
                                                            </span>
                                                        </span>

                                                    </p>

                                                    </div>
                                                    <label for="review_textarea"><span style="color: red;">*</span>Отзыв</label>
                                                    <span class="invalid-feedback" style="display: block;" role="alert">
                                                        <strong class="review"></strong>
                                                     </span>
                                                    <textarea class="form-control" id="review_textarea" rows="3" name="review"></textarea>
                                                    <div class="leave_review_btn" data-id="{{$product->id}}"><i class="review_icon fas fa-comment-dots"></i>Оставить отзыв</div>
                                                </form>
                                            @else
                                                <div class="alert alert-danger" role="alert">
                                                    Для того чтобы оставить отзыв войдите или зарегистрируйтесь.
                                                </div>
                                            @endauth
                                        @endif
                                        <div class="comments_section">
                                            @foreach($comments as $key => $val)
                                            <div class="new_review row align-items-center">
                                                <div class="review_l col-md-3 col-sm-4">
                                                    <div class="user_name">{{$val['user_id']->name}} {{$val['user_id']->last_name}}</div>
                                                    <div class="rate">
                                                        @for($i = 1; $i <= 5; $i++)
                                                            <i class="{{$i <= $val['rate'] ? 'fa' : 'far'}} fa-star" style="{{$i <= $val['rate'] ? 'color: #f18701' : ''}}" data-id="{{$i}}"></i>
                                                        @endfor
                                                    </div>
                                                    <div class="review_date">{{$val['date']}}</div>
                                                    <div class="avatar_container"><img id="user_avatar" src="{{$val['user_id']->avatar}}"></div>
                                                </div>
                                                <div class="review_r col-md-9 col-sm-8">
                                                    <p class="user_review">{{$val['review']}}</p>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class=" row justify-content-center">
                    <div class="col-lg-10">
                        @if(!empty($buy_whit) && $buy_whit[0] != null)
                            <h3 class="pp_h3">С этим товаром покупают</h3>
                            <div class="product_types row">
                                    @foreach($buy_whit as $key => $val)
                                    <div class="product_card col">
                                        <i title="Добавить в избранное" class="pc_add_to_favorites dont_rm far fa-heart"  data-id="{{$val->id}}"></i>
                                        <i title="Добавить в сравнение" class="pc_add_to_comparison dont_rm fas fa-sync-alt"  data-id="{{$val->id}}"></i>
                                        <i title="Быстрый просмотр" class="pc_quick-view far fa-plus-square"  data-id="{{$val->id}}"></i>
                                        <span class="pc_vendor_code">Артикул:<span class="pc_vc">{!! str_replace('"', '', $val->article) !!}</span></span>
                                        <div class="types">
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
                                        <a href="/product/{{$val->id}}"><img class="product_card_img" title="{{$val->name}}" src="{{json_decode($val->img_path)[0]}}" alt=""></a>
                                        <div class="card_body">
                                            <a href="/product/{{$val->id}}"><h5 title="{{$val->name}}">{{$val->name}}</h5></a>
                                            <hr>
                                            <p class="pc_delivery"><i class="pc_delivery_icon fas fa-truck-moving"></i>Доставка: <span class="pc_delivery_tod_tom">{{$val->delivery}}</span></p>
                                            <p class="pc_pickup"><i class="pc_pickup_icon fas fa-map-marker-alt"></i>Самовывоз: <a class="pc_pickup_link" href="#" title="Самовывоз"><span class="pc_pickup_tod_tom">{{$val->pickup}}</span></a></p>
                                            <div class="pc_price_block">
                                                <div class="pc_piece_price">
                                                    @if($val->old_price != 0)
                                                    <del class="pc_old_price">{{$val->old_price}}<span class="pc_price_currency">р.</span></del>
                                                    @endif
                                                    <span class="pc_price">{{$val->price}}<span class="pc_price_currency">р.</span></span>
                                                    <span class="pc_piece">/ {{ $val->unit }}.</span
                                                    ></div>
                                            </div>
                                            <div class="pc_add_to_cart_btn" title="Добавить в корзину">
                                                <span data-id="{{$val->id}}"><i class="pc_add_to_cart_icon"></i>В корзину</span>
                                                <div class="pc_quantity_block">
                                                    <input class="pc_quantity_number" type="number" disabled="disabled" data-value="{{$val->in_package}}" value="{{$val->in_package}}" size="9999">
                                                    <div class="quantity_arrows">
                                                        <span class="pc_quantity_arrow_plus" title="Увеличить">▲</span>
                                                        <span class="pc_quantity_arrow_minus" title="Уменьшить">▼</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                            </div>
                        @endif
                    </div>
                </div>
                <div class=" row justify-content-center">
                    <div class="col-lg-10">
                        @if(!empty($similar) && $similar[0] != null)
                            <h3 class="pp_h3">Похожие товары</h3>
                            <div class="product_types row">
                                @foreach($similar as $key => $val)
                                    <div class="product_card col">
                                        <i title="Добавить в избранное" class="pc_add_to_favorites dont_rm far fa-heart"  data-id="{{$val->id}}"></i>
                                        <i title="Добавить в сравнение" class="pc_add_to_comparison dont_rm fas fa-sync-alt"  data-id="{{$val->id}}"></i>
                                        <i title="Быстрый просмотр" class="pc_quick-view far fa-plus-square"  data-id="{{$val->id}}"></i>
                                        <span class="pc_vendor_code">Артикул:<span class="pc_vc">{!! str_replace('"', '', $val->article) !!}</span></span>
                                        <div class="types">
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
                                        <a href="/product/{{$val->id}}"><img class="product_card_img" title="{{$val->name}}" src="{{json_decode($val->img_path)[0]}}" alt=""></a>
                                        <div class="card_body">
                                            <a href="/product/{{$val->id}}"><h5 title="{{$val->name}}">{{$val->name}}</h5></a>
                                            <hr>
                                            <p class="pc_delivery"><i class="pc_delivery_icon fas fa-truck-moving"></i>Доставка: <span class="pc_delivery_tod_tom">{{$val->delivery}}</span></p>
                                            <p class="pc_pickup"><i class="pc_pickup_icon fas fa-map-marker-alt"></i>Самовывоз: <a class="pc_pickup_link" href="#" title="Самовывоз"><span class="pc_pickup_tod_tom">{{$val->pickup}}</span></a></p>
                                            <div class="pc_price_block">
                                                <div class="pc_piece_price">@if($val->old_price != 0)<del class="pc_old_price">{{$val->old_price}}<span class="pc_price_currency">р.</span></del>@endif <span class="pc_price">{{$val->price}}<span class="pc_price_currency">р.</span></span><span class="pc_piece">/{{ $val->unit }}.</span></div>
                                            </div>
                                            <div class="pc_add_to_cart_btn" title="Добавить в корзину">
                                                <span data-id="{{$val->id}}"><i class="pc_add_to_cart_icon"></i>В корзину</span>
                                                <div class="pc_quantity_block">
                                                    <input class="pc_quantity_number" type="number" disabled="disabled" data-value="{{$val->in_package}}" value="{{$val->in_package}}" size="9999">
                                                    <div class="quantity_arrows">
                                                        <span class="pc_quantity_arrow_plus" title="Увеличить">▲</span>
                                                        <span class="pc_quantity_arrow_minus" title="Уменьшить">▼</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </article>
@endsection

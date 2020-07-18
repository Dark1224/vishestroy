@extends('layouts.app')

@section('content')

    <article>
        <div class="container-fluid">
            <div class="page_header row justify-content-center">
                <div class="col-lg-10 col-md-12 col-sm-12">
                    <h1 class="page_header">Главная</h1>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="advertising col-xl-4 col-lg-4 col-md-4 col-12">
                    <a href="/about_us">
                        <div class="advretising_img">
                            <div class="advertasing_txt">
                                <h3>ЦЕНТР ОПТОВОЙ ТОРГОВЛИ</h3>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="carousel_block col-lg-6 col-md-8">
                    <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                        <ol class="carousel-indicators">
                            <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                            <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                        </ol>
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <a href="/sel_lout">
                                <img class="d-block w-100" src="/img/bg-pictures/gig-stroy-slide-1.jpg" alt="First slide">
                                </a>
                            </div>
                            <div class="carousel-item">
                                <img class="d-block w-100" src="/img/bg-pictures/gig-stroy-slide-2.jpg" alt="Second slide">
                            </div>
                        </div>
                        <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="sr-only">Previous</span>
                        </a>
                        <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="sr-only">Next</span>
                        </a>
                    </div>
                </div>
            </div>
            <div class="article row justify-content-center">
                <div class="col-lg-10 col-md-12">
                    <div class="col-lg-12 p-0">
                        <div class="container-fluid p-0">
                            @if($bestseller->count() > 0)
                            <div class="col-xl-12 p-0">
                                <h3 class="products_header">Хиты продаж</h3>
                                <a id="view_all" href="/bestseller">Посмотреть все товары</a>
                                <div class="product_types row">
                                    @foreach($bestseller as $bestseller_key => $bestseller_val)
                                    <div class="product_card col">
                                        <i title="Добавить в избранное" class="pc_add_to_favorites  far dont_rm fa-heart" data-id="{{$bestseller_val->id}}"></i>
                                        <i title="Добавить в сравнение" class="pc_add_to_comparison fas fa-sync-alt" data-id="{{$bestseller_val->id}}"></i>
                                        <i title="Быстрый просмотр" class="pc_quick-view far fa-plus-square" data-id="{{$bestseller_val->id}}"></i>
                                        <span class="pc_vendor_code">Артикул:<span class="pc_vc">{!! str_replace('"', '', $bestseller_val->article) !!}</span></span>
{{--                                        TO DO add article from db and admin panel --}}
                                        <div class="types">
                                            @if($bestseller_val->bestseller)
                                            <div class="pc_hit">Хит продаж!</div>
                                            @endif
                                            @if($bestseller_val->sel_lout)
                                            <div class="pc_sale">Распродажа!</div>
                                            @endif
                                            @if($bestseller_val->new)
                                            <div class="pc_new">Новинка!</div>
                                            @endif
                                        </div>
                                        <a href="/product/{{$bestseller_val->id}}"><img class="product_card_img" title="{{$bestseller_val->name}}" src="{{json_decode($bestseller_val->img_path)[0]}}" alt=""></a>
                                        <div class="card_body">
                                            <a href="/product/{{$bestseller_val->id}}"><h5 title="{{$bestseller_val->name}}">{{$bestseller_val->name}}</h5></a>
                                            <hr>
                                            <p class="pc_delivery"><i class="pc_delivery_icon fas fa-truck-moving"></i>Доставка: <span class="pc_delivery_tod_tom">{{$bestseller_val->delivery}}</span></p>
                                            <p class="pc_pickup"><i class="pc_pickup_icon fas fa-map-marker-alt"></i>Самовывоз: <a class="pc_pickup_link" href="#" title="Самовывоз"><span class="pc_pickup_tod_tom">{{$bestseller_val->pickup}}</span></a></p>
                                            <div class="pc_price_block">
                                                <div class="pc_piece_price">
                                                    @if($bestseller_val->old_price != 0)
                                                    <del class="pc_old_price">{{$bestseller_val->old_price}}<span class="pc_price_currency">р.</span></del>
                                                    @endif
                                                    <span class="pc_price">{{$bestseller_val->price}}<span class="pc_price_currency">р.</span></span>
                                                    <span class="pc_piece">/ {{ $fields[$bestseller_val->unit] }}.</span>
                                                </div>
                                            </div>
                                            <div class="pc_add_to_cart_btn" title="Добавить в корзину">
                                                <span class="add_to_cart" data-id="{{$bestseller_val->id}}">В корзину</span>
                                                <div class="pc_quantity_block">
                                                    <input class="pc_quantity_number" type="number" disabled="disabled" data-value="{{$bestseller_val->in_package}}" value="{{$bestseller_val->in_package}}" size="9999">
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
                            </div>
                            @endif
                            @if($sel_lout->count() > 0)

                            <div class="col-xl-12 p-0">
                                <div class="home_adv_block"><a href="../category/40"><img src="/img/bg-pictures/gig-stroy-legrand-advertasing.jpg"></a></div>
                            </div>

                            <div class="col-xl-12 p-0">
                                <h3 class="products_header">Распродажа</h3>
                                <a id="view_all" href="/sel_lout">Посмотреть все товары</a>
                                <div class="product_types row">
                                @foreach($sel_lout as $sel_lout_key => $sel_lout_val)
                                    <div class="product_card col">
                                        <i title="Добавить в избранное" class="pc_add_to_favorites dont_rm far fa-heart" data-id="{{$sel_lout_val->id}}"></i>
                                        <i title="Добавить в сравнение" class="pc_add_to_comparison fas fa-sync-alt" data-id="{{$sel_lout_val->id}}"></i>
                                        <i title="Быстрый просмотр" class="pc_quick-view far fa-plus-square" data-id="{{$sel_lout_val->id}}"></i>
                                        <span class="pc_vendor_code">Артикул:<span class="pc_vc">{!! str_replace('"', '', $sel_lout_val->article) !!}</span></span>
                                        <div class="types">
                                            @if($sel_lout_val->bestseller)
                                                <div class="pc_hit">Хит продаж!</div>
                                            @endif
                                            @if($sel_lout_val->sel_lout)
                                                <div class="pc_sale">Распродажа!</div>
                                            @endif
                                            @if($sel_lout_val->new)
                                                <div class="pc_new">Новинка!</div>
                                            @endif
                                        </div>
                                        <a href="/product/{{$sel_lout_val->id}}"><img class="product_card_img" title="{{$sel_lout_val->name}}" src="{{json_decode($sel_lout_val->img_path)[0]}}" alt=""></a>
                                        <div class="card_body">
                                            <a href="/product/{{$sel_lout_val->id}}"><h5 title="{{$sel_lout_val->name}}">{{$sel_lout_val->name}}</h5></a>
                                            <hr>
                                            <p class="pc_delivery"><i class="pc_delivery_icon fas fa-truck-moving"></i>Доставка: <span class="pc_delivery_tod_tom">{{$sel_lout_val->delivery}}</span></p>
                                            <p class="pc_pickup"><i class="pc_pickup_icon fas fa-map-marker-alt"></i>Самовывоз: <a class="pc_pickup_link" href="#" title="Самовывоз"><span class="pc_pickup_tod_tom">{{$sel_lout_val->pickup}}</span></a></p>
                                            <div class="pc_price_block">
                                                <div class="pc_piece_price"><del class="pc_old_price">{{$sel_lout_val->old_price}}<span class="pc_price_currency">р.</span></del> <span class="pc_price">{{$sel_lout_val->price}}<span class="pc_price_currency">р.</span></span><span class="pc_piece">/ {{ $fields[$sel_lout_val->unit] }} .</span></div>
                                            </div>
                                            <div class="pc_add_to_cart_btn" title="Добавить в корзину">
                                                <span class="add_to_cart" data-id="{{$sel_lout_val->id}}">В корзину</span>
                                                <div class="pc_quantity_block">
                                                    <input class="pc_quantity_number" type="number" disabled="disabled" data-value="{{$sel_lout_val->in_package}}" value="{{$sel_lout_val->in_package}}" size="9999">
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
                            </div>
                            @endif
                            @if($new_products->count() > 0)
                            <div class="col-xl-12 p-0">
                                <h3 class="products_header">Новинки</h3>
                                <a id="view_all" href="/new">Посмотреть все товары</a>
                                <div class="product_types row">
                                    @foreach($new_products as $new_products_key => $new_products_val)
                                        <div class="product_card col">
                                            <i title="Добавить в избранное" class="pc_add_to_favorites dont_rm far fa-heart" data-id="{{$new_products_val->id}}"></i>
                                            <i title="Добавить в сравнение" class="pc_add_to_comparison fas fa-sync-alt" data-id="{{$new_products_val->id}}"></i>
                                            <i title="Быстрый просмотр" class="pc_quick-view far fa-plus-square" data-id="{{$new_products_val->id}}"></i>
                                            <span class="pc_vendor_code">Артикул:<span class="pc_vc">{!! str_replace('"', '', $new_products_val->article) !!}</span></span>
                                            <div class="types">
                                                @if($new_products_val->bestseller)
                                                    <div class="pc_hit">Хит продаж!</div>
                                                @endif
                                                @if($new_products_val->sel_lout)
                                                    <div class="pc_sale">Распродажа!</div>
                                                @endif
                                                @if($new_products_val->new)
                                                    <div class="pc_new">Новинка!</div>
                                                @endif
                                            </div>
                                            <a href="/product/{{$new_products_val->id}}"><img class="product_card_img" title="{{$new_products_val->name}}" src="{{json_decode($new_products_val->img_path)[0]}}" alt=""></a>
                                            <div class="card_body">
                                                <a href="/product/{{$new_products_val->id}}"><h5 title="{{$new_products_val->name}}">{{$new_products_val->name}}</h5></a>
                                                <hr>
                                                <p class="pc_delivery"><i class="pc_delivery_icon fas fa-truck-moving"></i>Доставка: <span class="pc_delivery_tod_tom">{{$new_products_val->delivery}}</span></p>
                                                <p class="pc_pickup"><i class="pc_pickup_icon fas fa-map-marker-alt"></i>Самовывоз: <a class="pc_pickup_link" href="#" title="Самовывоз"><span class="pc_pickup_tod_tom">{{$new_products_val->pickup}}</span></a></p>
                                                <div class="pc_price_block">
                                                    <div class="pc_piece_price">
                                                        @if($new_products_val->old_price > 0)
                                                        <del class="pc_old_price">{{$new_products_val->old_price}}<span class="pc_price_currency">р.</span></del>
                                                        @endif
                                                        <span class="pc_price">{{$new_products_val->price}}<span class="pc_price_currency">р.</span></span><span class="pc_piece">/ {{ $fields[$new_products_val->unit]}}.</span></div>
                                                </div>
                                                <div class="pc_add_to_cart_btn" title="Добавить в корзину">
                                                    <span class="add_to_cart" data-id="{{$new_products_val->id}}">В корзину</span>
                                                    <div class="pc_quantity_block">
                                                        <input class="pc_quantity_number" type="number" disabled="disabled" data-value="{{$new_products_val->in_package}}" value="{{$new_products_val->in_package}}" size="9999">
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
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </article>
@endsection

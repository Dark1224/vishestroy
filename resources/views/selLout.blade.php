@extends('layouts.app')

@section('content')
    <article>
    <div class="container-fluid">
        <div class="page_header row justify-content-center">
            <div class="col-lg-10 col-md-12 col-sm-12">
                <h1 class="page_header">Распродажа</h1>
            </div>
        </div>
        <div class="article row justify-content-center">
            <div class="aside col-xl-2 col-lg-3">
                <p class="filter_header filter_1">ЦЕНА</p>
                <input type="text" class="js-range-slider" name="my_range" style="display: none" value="" />
                <p class="filter_header filter_2">ПРОИЗВОДИТЕЛЬ</p>
                 <div class="brand_filters">
                    @foreach($manufacturer as $key => $val)
                        @foreach($products as $products_key => $products_val)
                            @if($products_val->manufacturer == $val->id)
                                <label class="b_filter">
                                    <input type="checkbox" class="manufacturer" value="{{$val->id}}">
                                    <span class="checkmark"></span>
                                    {{$val->name}}
                                </label>
                                @break
                             @endif
                        @endforeach
                    @endforeach

                </div>
            </div>
            <div class="col-xl-8 col-lg-9">
                <div class="product_types row">
                    @foreach($products as $products_key => $products_val)
                            <div class="product_card col">
                                <i title="Добавить в избранное" class="pc_add_to_favorites dont_rm far fa-heart" data-id="{{$products_val->id}}"></i>
                                <i title="Добавить в сравнение" class="pc_add_to_comparison dont_rm fas fa-sync-alt" data-id="{{$products_val->id}}"></i>
                                <i title="Быстрый просмотр" class="pc_quick-view far fa-plus-square" data-id="{{$products_val->id}}"></i>
                                <span class="pc_vendor_code">Артикул:<span class="pc_vc">{!! str_replace('"', '', $products_val->article) !!}</span></span>
                                <div class="types">
                                    @if($products_val->bestseller)
                                        <div class="pc_hit">Хит продаж!</div>
                                    @endif
                                    @if($products_val->sel_lout)
                                        <div class="pc_sale">Распродажа!</div>
                                    @endif
                                    @if($products_val->new)
                                        <div class="pc_new">Новинка!</div>
                                    @endif
                                </div>
                                <a href="/product/{{$products_val->id}}">
                                    <img class="product_card_img" title="{{$products_val->name}}" src="{{json_decode($products_val->img_path)[0]}}" alt="">
                                </a>
                                <div class="card_body">
                                    <a href="/product/{{$products_val->id}}"><h5 title="{{$products_val->name}}">{{$products_val->name}}</h5></a>
                                    <hr>
                                    <p class="pc_delivery"><i class="pc_delivery_icon fas fa-truck-moving"></i>Доставка: <span class="pc_delivery_tod_tom">{{$products_val->delivery}}</span></p>
                                    <p class="pc_pickup"><i class="pc_pickup_icon fas fa-map-marker-alt"></i>Самовывоз: <a class="pc_pickup_link" href="#" title="Самовывоз"><span class="pc_pickup_tod_tom">{{$products_val->pickup}}</span></a></p>
                                    <div class="pc_price_block">
                                        <div class="pc_piece_price">
                                            @if($products_val->old_price != 0)
                                            <del class="pc_old_price">{{$products_val->old_price}}<span class="pc_price_currency">р.</span></del>
                                            @endif
                                            <span class="pc_price">{{$products_val->price}}
                                                <span class="pc_price_currency">р.</span>
                                            </span>
                                            <span class="pc_piece">/ {{ $fields[$products_val->unit] }}.</span>
                                        </div>
                                    </div>
                                    <div class="pc_add_to_cart_btn" title="Добавить в корзину">
                                        <span class="add_to_cart" data-id="{{$products_val->id}}">В корзину</span>
                                        <div class="pc_quantity_block">
                                            <input class="pc_quantity_number" type="number" disabled="disabled" data-value="{{$products_val->in_package}}" value="{{$products_val->in_package}}" size="9999">
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
        </div>
    </div>
</article>
@endsection

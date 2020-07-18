@extends('layouts.app')

@section('content')

<article>
    <div class="container-fluid">
        <div class="cart_page row">
            <div class="col-xl-10">
                <div class="row mb-5">
                    <div class="col-xl-12">
                        <div class="title_page">
                            <h1 class="page_header">Избранное</h1>
                        </div>
                    </div>
                </div>
                <div class="row products justify-content-center">
                    <div class="col-lg-12 col-sm-12">
                        <div class="row justify-content-center">
                            @foreach($products as $key => $val)

                                <div class="product_types row">
                                    <div class="product_card col">
                                        <i title="Добавить в избранное" class="pc_add_to_favorites far fa-heart whish_list" data-id="{{$val['product']->id}}"></i>
                                        <i title="Добавить в сравнение" class="pc_add_to_comparison fas fa-sync-alt whish_list" data-id="{{$val['product']->id}}"></i>
                                        <i title="Быстрый просмотр" class="pc_quick-view far fa-plus-square" data-id="{{$val['product']->id}}"></i>
                                        <span class="pc_vendor_code">Артикул:<span class="pc_vc">{!! str_replace('"', '', $val['product']->article) !!}</span></span>
                                        <div class="types">
                                            @if($val['product']->bestseller)
                                                <div class="pc_hit">Хит продаж!</div>
                                            @endif
                                            @if($val['product']->sel_lout)
                                                <div class="pc_sale">Распродажа!</div>
                                            @endif
                                            @if($val['product']->new)
                                                <div class="pc_new">Новинка!</div>
                                            @endif
                                        </div>
                                        <a href="/product/{{$val['product']->id}}"><img class="product_card_img" title="{{$val['product']->name}}" src="{{json_decode($val['product']->img_path)[0]}}" alt=""></a>
                                        <div class="card_body">
                                            <a href="/product/{{$val['product']->id}}"><h5 title="{{$val['product']->name}}">{{$val['product']->name}}</h5></a>
                                            <hr>
                                            <p class="pc_delivery"><i class="pc_delivery_icon fas fa-truck-moving"></i>Доставка: <span class="pc_delivery_tod_tom">{{$val['product']->delivery}}</span></p>
                                            <p class="pc_pickup"><i class="pc_pickup_icon fas fa-map-marker-alt"></i>Самовывоз: <a class="pc_pickup_link" href="#" title="Самовывоз"><span class="pc_pickup_tod_tom">{{$val['product']->pickup}}</span></a></p>
                                            <div class="pc_price_block">
                                                <div class="pc_piece_price">@if($val['product']->old_price != 0)<del class="pc_old_price">{{$val['product']->old_price}}<span class="pc_price_currency">р.</span></del>@endif <span class="pc_price">{{$val['product']->price}}<span class="pc_price_currency">р.</span></span><span class="pc_piece">/ {{ $fields[$val['product']->unit] }}.</span></div>
                                            </div>
                                            <div class="pc_add_to_cart_btn" title="Добавить в корзину">
                                                <span class="add_to_cart" data-id="{{$val['product']->id}}">В корзину</span>
                                                <div class="pc_quantity_block">
                                                    <input class="pc_quantity_number" type="number" disabled="disabled" data-value="{{$val['product']->in_package}}" value="{{$val['product']->in_package}}" size="9999">
                                                    <div class="quantity_arrows">
                                                        <span class="pc_quantity_arrow_plus" title="Увеличить">▲</span>
                                                        <span class="pc_quantity_arrow_minus" title="Уменьшить">▼</span>
                                                    </div>
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
        </div>
    </div>
</article>
@endsection

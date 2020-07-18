@extends('layouts.app')

@section('content')
    <article>
        <div class="container-fluid">
            <div class="cart_page row">
                <div class="col-xl-10">
                    <div class="row mb-5">
                        <div class="col-12">
                            <div class="title_page">
                                <h3 class="page_header">Корзина</h3>
                            </div>
                        </div>
                    </div>
                    <div class="row products justify-content-center">
                        <div class="col-lg-8 col-sm-12">
                            <div class="row justify-content-around">
                                @foreach($products as $key => $val)
                                <div class="col-sm-12 col-5">
                                    <div class="row about_product">
                                        <div class="col-sm-4">
                                            <p class="title_table">{{$val['product']->name}}</p>
                                            <img src="{{json_decode($val['product']->img_path)[0]}}" style="width: 80px;">
                                        </div>
                                        <div class="col-sm-2">
                                            <p class="title_table">Цена</p>
                                            <p><span class="price_one_product">{{$val['product']->price}}</span>р.</p>
                                        </div>
                                        <div class="col-sm-3">
                                            <p class="title_table">Кол-во</p>
                                            <div class="quantity">
                                                <i class="fas fa-minus mr-2"></i>
                                                <input class="form-control" disabled type="text" data-id="{{$val['product']->id}}" data-value="{{$val['product']->in_package}}" value="{{$val['qty']}}">
                                                <i class="fas fa-plus ml-2"></i>
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <p class="title_table">Стоимость</p>
                                            <p><span class="total_one_product">{{$val['product']->price * $val['qty']}}</span>р.</p>
                                        </div>
                                        <div class="col-sm-1 pl-0">
                                            <p class="title_table"> </p>
                                            <div class="icons">
                                                <i class="fas fa-trash-alt ml-2 remove_one_product" data-id="{{$key}}"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6 col-sm-6">
                            <div class="buy_block">
                                <p class="mb-3">Общее кол-во товаров: <span class="amaount">{{$total_qty}}</span></p>
                                <p class="mb-5">Общая стоимость: <span class="total">{{$total_price}}</span> р.</p>
                                <span class="text-center checkout_button">{!! !empty($products) ? '<a href="/checkout" class="form-control checkout">Оформить заказ</a>' : '<button disabled class="form-control checkout">Оформить заказ</button>' !!}</span>
                                <button class="remove_basket">Очистить корзину</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </article>
@endsection

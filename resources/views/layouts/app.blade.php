<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <title>{{ config('app.name', 'Laravel') }}</title>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no, maximum-scale=1" />
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta name="robots" content="all">
    <meta name="keywords" content="гиг-строй, гиг строй, стройматериалы, стройматериалы оптом, купить стройматериалы, gig stroy">
    <link href="https://fonts.googleapis.com/css?family=Roboto+Condensed:400,700&display=swap" rel="stylesheet">
    <link rel="icon" href="/images/icons/icon.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ion-rangeslider/2.3.0/css/ion.rangeSlider.min.css"/>

    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
<header>
    <div class="container-fluid">
        <div class="top_header row justify-content-center">
            <div class="">
                <div class="top_header_logo col-lg-3">
                    <a href="/"><img src="/images/logo/Gyg-Stroy-logo.png" alt="gig-stroy-logo" title="Гиг-Строй"></a>
                </div>
            </div>
            <div class="top_nav col-lg-9">
                <ul>
                    <li><a class="comparisions" href="/comparison" title="Сравнение">Сравнение</a></li>
                    <li><a class="favorites" href="/wishlist" title="Избранное">Избранное</a></li>

                    <li>
                        <a class="top_header_cart" href="/cart" title="Корзина">
                            <i class="fas fa-shopping-cart"></i>
                            <span id="cart">В корзине</span>
                            <span id="cart_info"></span>
                            <span id="number_of_products">{{$totals['total_qty']}}</span>
                            <span id="th_w_products">товаров</span>
                            <span id="th_w_summ">на сумму</span>
                            <span id="th_total_amount">{{$totals['total_price']}}</span>
                            <span id="th_cart_currency">₽</span>
                        </a>

                    </li>
                    @if (Route::has('login'))
                            @auth
                            <li>
                                <a class="reg" href="/personalArea">Личный кабинет</a>
                                <span class="separator"> / </span>
                                <a class="reg" href="{{ route('logout') }}">Выход</a>
                            </li>
                        @else
                            <li>
                                <a class="entry" href="{{ route('login') }}" title="Вход">Вход</a>
                                <span class="separator">&nbsp;/&nbsp;</span>
                                @if (Route::has('register'))
                                    <a class="reg" href="{{ route('register') }}">Регистрация</a>
                                @endif
                            </li>
                            @endauth
                    @endif

                </ul>
            </div>
        </div>
        <div class="header row justify-content-center">
            <div class="logo col-lg-2 col-md-3">
                <a href="/"><img src="/images/logo/Gyg-Stroy-logo.png" alt="gig-stroy-logo" title="Гиг-Строй"></a>
            </div>
            <div class="phone_number col-lg-4 col-md-4">
                <a href="tel:+78004441143"><i class="header_phone_icon fas fa-phone-volume"></i>+7 800 444 11 43</a>
                <a href="tel:+79255195766"><i class="header_phone_icon fas fa-phone-volume"></i>+7 925 519 57 66</a>
            </div>
            <div class="header_search col-lg-4 col-md-5 position-relative">
                <input name="header_search" placeholder="Поиск..." autocomplete="off">
                <span id="hs_btn"><i class="fas fa-caret-right"></i></span>
                <div class="search_section position-absolute">
                    <ul>

                    </ul>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="product_categories_block col-xl-12">
                <ul class="product_categories">
                    @foreach($menu as $menu_key => $menu_val)
                        <li class="product_category">
                            <a class="product_category_link" href="/category/{{$menu_val['parent']->id}}">{{$menu_val['parent']->name}}</a>
                            @if(isset($menu_val['children']))
                                <ul class="subcategry_popup sub_1">
                                    @foreach($menu_val['children'] as $child_key => $child_val)
                                    <li class="subcategory"><a href="/category/{{$child_val->id}}">{{$child_val->name}}</a></li>
                                    @endforeach
                                </ul>
                            @endif
                        </li>
                    @endforeach

                </ul>
            </div>
        </div>
        <div class="mobile_header row">
            <div class="mobile_logo col-4">
                <a href="/" title="Гиг Строй"><img src="/images/logo/Gyg-Stroy-logo.png"></a>
            </div>
            <div class="mobile_nav col-8">
                <div class="header_entry_mobile">
                    <a href="/personalArea" title="Вход"><i class="fas fa-user"></i></a>
                </div>
                <div class="header_call_mobile">
                    <a href="tel:+78004441143" title="Звонок"><i class="fas fa-mobile-alt"></i></a>
                </div>
                <div class="header_search_mobile">
                    <i title="Поиск" class=" fas fa-search"></i>
                </div>
                <div class="header_cart_mobile">
                    <a href="/cart" title="Корзина"><i class="fas fa-shopping-cart"></i><span class="mobile_cart_product_number">{{$totals['total_qty']}}</span></a>
                </div>
                <div class="mobile-category_hamburger">
                    <i class="menu_icon fas fa-bars"></i>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="mobile_search_block col-12">
                <input name="header_search" placeholder="Поиск..." autocomplete="off">
                <div class="search_section position-absolute">
                    <ul>

                    </ul>
                </div>
            </div>
        </div>
<!--         <div class="row p-0">
            <div class="col-12 attention">
                <p class>МАГАЗИН НАХОДИТСЯ В СТАДИИ РАЗРАБОТКИ</p>
            </div>
        </div> -->
    </div>
    <div class="container-fluid">
        <div class="mobile_categories_block">
            <div class="mobile_categories">
                <ul>
                    @foreach($menu as $menu_key => $menu_val)
                        <li class="mobile_category">
                            <h5>{{$menu_val['parent']->name}}</h5>
                            @if(isset($menu_val['children']))
                                <ul>
                                    @foreach($menu_val['children'] as $child_key => $child_val)
                                        <li class="mobile_subcategory"><a href="/category/{{$child_val->id}}">{{$child_val->name}}</a></li>
                                    @endforeach
                                </ul>
                            @endif
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</header>


    @yield('content')


<footer>
    <div class="quick_order_popup_block">

    </div>




    <div class="container-fluid">
        <div class="advantages row justify-content-center">
            <div class="adw_items col-lg-2 col-md-6 col-sm-6 m-0">
                <img src="/images/icons/assortment.png"><h5>Ассортимент</h5><p>Широкий ассортимент товаров для строительства и ремонта</p>
            </div>
            <div class="adw_items col-lg-2 col-md-6 col-sm-6 m-0">
                <img src="/images/icons/price.png"><h5>Выгодные цены</h5><p>Лучшие товары от популярных производителей по оптовым ценам</p>
            </div>
            <div class="adw_items col-lg-2 col-md-6 col-sm-6 m-0">
                <img src="/images/icons/quality.png"><h5>Гарантия качества</h5><p>Контроль качества по всем заявленным междуныродным стандартам</p>
            </div>
            <div class="adw_items col-lg-2 col-md-6 col-sm-6 m-0">
                <img src="/images/icons/delivery.png"><h5>Доставка</h5><p>Доставим ваш заказ быстро и вовремя, 99.8% заказов доставляем точно в срок</p>
            </div>
            <div class="adw_items col-lg-2 col-md-6 col-sm-6 m-0">
                <img src="/images/icons/service.png"><h5>Заботливый сервис</h5><p>Индивидуальный подход к каждому клиенту и гибкая система скидок</p>
            </div>
        </div>
        <div class="footer row justify-content-center">
            <div class="f_block fb_1 col-lg-3 col-md-6 col-sm-6">
                <ul>
                    <li><a href="/about_us">О нас</a></li>
                    <li><a href="/payment">Оплата</a></li>
                    <li><a href="/about-delivery">Доставка</a></li>
                    <li><a href="/personalArea">Личный кабинет</a></li>
                    <li><a href="">Акции</a></li>
                </ul>
            </div>
            <div class="f_block fb_2 col-lg-3 col-md-6 col-sm-6">
                <ul>
                    <li><a href="">Оптовикам</a></li>
                    <li><a href="">Возврат товара</a></li>
                    <li><a href="">Карта сайта</a></li>
                    <li><a href="">Отзывы</a></li>
                    <li><a href="/agreement">Политика конфиденциальности</a></li>
                </ul>
            </div>
            <div class="f_block fb_4 col-lg-4 col-md-6 col-sm-6">
                <ul>
                    <li><a class="comparisions" href="/comparison" title="Сравнение">Сравнение</a><li>
                    <li><a class="favorites" href="/wishlist" title="Избранное">Избранное</a></li>
                    <li><a href="">Наши контакты</a></li>
                    <li><a class="email" href="mailto:gig-stroy@mail.ru" title="Сравнение">Email: gig-stroy@mail.ru</a><li>
                </ul>
            </div>
        </div>
        <div class="fb_block row justify-content-center">
            <div class="developed_by col-lg-3 col-md-6 col-sm-6">
                <h5>© Created by</h5>
                <a href="http://neoteric-software.com"><img src="/images/logo/neoteric_Software_logo.svg" title="Neoteric Software"></a>
            </div>
            <!-- <div class="our_partners col-lg-2 col-md-6 col-sm-6">
                <h5>Наши партнеры</h5>
                <a href=""><img src="/images/logo/cashpowood-logo.png" title="Cashpo Wood"></a>
            </div> -->
            <div class="payment-methods col-lg-3 col-md-6 col-sm-6">
                <h5>К оплате принимаем</h5>
                <a href=""><img src="/images/payment-methods.png" title="Способы оплаты"></a>
            </div>
            <div class="all_rights col-lg-4 col-md-12 col-sm-12">
                <p>Все материалы, представленные на сайте, являются собственностью их владельца и охраняются международными правовыми конвенциями. Эти материалы предназначены только для ознакомления.</p>
            </div>
        </div>
    </div>
</footer>


<div class="quick_view_popup_block">
<div class="quick_view_content col-12 col-sm-7 col-md-7">

</div>
</div>
<!-- <div class="share_icons_block">
    <div class="share_icons">
        <div class="share-link sl_1">
            <a href="https://www.facebook.com/sharer/sharer.php?u=https://gig-stroy.ru/ru/post/156185/" 
            class="social-icons_item-link social-icons__item-link_normal social-icons__item-link_facebook" 
            title="Опубликовать в VK" onclick="window.open(this.href, 'Опубликовать в VK', 
            'width=640,height=436,toolbar=0,status=0'); return false"><img src="/images/icons/vk-icon.png">
            </a>
        </div>
        <div class="share-link sl_2">
            <a href="https://www.facebook.com/sharer/sharer.php?u=https://gig-stroy.ru/ru/post/156185/" 
            class="social-icons_item-link social-icons__item-link_normal social-icons__item-link_facebook" 
            title="Опубликовать в Instagram" onclick="window.open(this.href, 'Опубликовать в Instagram', 
            'width=640,height=436,toolbar=0,status=0'); return false"><img src="/images/icons/instagram-icon.png">
            </a>
        </div>
        <div class="share-link sl_3">
            <a href="https://www.facebook.com/sharer/sharer.php?u=https://gig-stroy.ru/ru/post/156185/" 
            class="social-icons_item-link social-icons__item-link_normal social-icons__item-link_facebook" 
            title="Опубликовать в WhatsApp" onclick="window.open(this.href, 'Опубликовать в WhatsApp', 
            'width=640,height=436,toolbar=0,status=0'); return false"><img src="/images/icons/whatsup.png">
            </a>
        </div>
        <div class="share-link sl_4">
            <a href="https://www.facebook.com/sharer/sharer.php?u=https://gig-stroy.ru/ru/post/156185/" 
            class="social-icons_item-link social-icons__item-link_normal social-icons__item-link_facebook" 
            title="Опубликовать в Twitter" onclick="window.open(this.href, 'Опубликовать в Twitter', 
            'width=640,height=436,toolbar=0,status=0'); return false"><img src="/images/icons/twitter-icon.png">
            </a>
        </div>
        <div class="share-link sl_5">
            <a href="https://www.facebook.com/sharer/sharer.php?u=https://gig-stroy.ru/ru/post/156185/" 
            class="social-icons_item-link social-icons__item-link_normal social-icons__item-link_facebook" 
            title="Опубликовать в Facebook" onclick="window.open(this.href, 'Опубликовать в Facebook', 
            'width=640,height=436,toolbar=0,status=0'); return false"><img src="/images/icons/facebook-icon.png">
            </a>
        </div>
    </div>
</div> -->
<div class="modal fade bd-example-modal-xl" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Выбрать аватара</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row justify-content-between p-5">
                    <div class="modal_image_block mb-3">
                        <img src="/img/avatars/ava-1.png">
                    </div>
                    <div class="modal_image_block mb-3">
                        <img src="/img/avatars/ava-2.png">
                    </div>
                    <div class="modal_image_block mb-3">
                        <img src="/img/avatars/ava-3.png">
                    </div>
                    <div class="modal_image_block mb-3">
                        <img src="/img/avatars/ava-4.png">
                    </div>
                    <div class="modal_image_block mb-3">
                        <img src="/img/avatars/ava-5.png">
                    </div>
                </div>
            </div>
            <div class="modal-footer">

                <button type="button" class="btn btn-primary">Сохранить</button>
            </div>
        </div>
    </div>
</div>
<script src="https://api-maps.yandex.ru/2.1/?apikey=ec9aa1bf-ee39-49b0-989a-0aedf6b79f0b&lang=ru_RU" type="text/javascript"></script>
<script src="{{ asset('js/app.js') }}" defer></script>
</body>
</html>

@extends('layouts.app')

@section('content')
    <article>
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-lg-10 col-md-12">
                    <div class="row checkout_range_links">
                        <div class="col-lg-3 col-md-3">
                            <a href="/cart" class="checkout_range_link rlink_1"><span class="checkout_numbers plnumber_1">1</span>Корзина <i class="checkout_next_step_icon fas fa-chevron-right"></i></a>
                        </div>
                        <div class="col-lg-3 col-md-3">
                            <a href="/checkout" class="checkout_range_link rlink_2"><span class="checkout_numbers plnumber_2">2</span>Личные данные <i class="checkout_next_step_icon fas fa-chevron-right"></i></a>
                        </div>
                        <div class="col-lg-3 col-md-3">
                            <a href="/delivery" class="checkout_range_link rlink_3 to_delivery"><span class="checkout_numbers plnumber_3">3</span>Способ доставки <i class="checkout_next_step_icon fas fa-chevron-right"></i></a>
                        </div>
                        <div class="col-lg-3 col-md-3">
                            <a href="/end" class="checkout_range_link rlink_4 to_delivery"><span class="checkout_numbers plnumber_4">4</span>Завершение <i class="checkout_last_step_icon fas fa-check"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-md-10 m-auto">
                    <div class="error"></div>
                </div>
                <div class="col-lg-5 col-md-6 col-sm-12 col-12 checkout_block_1">
                    <h3 class="checkout_page_headers">Оформление заказа</h3>
                    <div class="checkout_tab_content_1 tab-content" id="nav-tabContent">
                        <div class="checkout_tab_pane tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                            <div class="row check_field_1">
                                <div class="col-12 tab_pane_content">
                                    <label for="individual_name"><span style="color: red;">*</span> Фамилия<input id="individual_name" name="name" value="{{empty($user) ? '' : $user->last_name}}" type="text"></label>
                                        <span class="invalid-feedback" role="alert">
                                            <strong></strong>
                                        </span>
                                </div>
                            </div>
                            <div class="row check_field_2">
                                <div class="col-12 tab_pane_content">
                                    <label for="individual_surname"><span style="color: red;">*</span> Имя<input id="individual_surname" name="surname" value="{{empty($user) ? '' : $user->name}}" type="text"></label>
                                        <span class="invalid-feedback" role="alert">
                                            <strong></strong>
                                        </span>
                                </div>
                            </div>
                            <div class="row check_field_3">
                                <div class="col-lg-7 tab_pane_content">
                                    <label for="individual_email"><span style="color: red;">*</span> Электронная почта<input id="individual_email" name="email" value="{{empty($user) ? '' : $user->email}}" type="email"></label>
                                        <span class="invalid-feedback" role="alert">
                                            <strong></strong>
                                        </span>
                                </div>
                                <div class="col-lg-5 tab_pane_content">
                                    <label for="individual_tel"><span style="color: red;">*</span> Телефон<input class="phone" id="individual_tel" name="tel" value="{{empty($user) ? '' : $user->tel}}" type="tel"></label>
                                        <span class="invalid-feedback" role="alert">
                                            <strong></strong>
                                        </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @if (Route::has('login'))
                    @auth
                    @else
                        <div class="col-lg-5 col-md-6 col-sm-12 col-12 aut_reg_block">
                            <h3 class="checkout_page_headers">Войти в личный кабинет</h3>
                            <nav>
                                <div class="checkout_nav_tabs nav nav-tabs" id="nav-tab" role="tablist">
                                    <a class="checkout_nav_link nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home2" role="tab" aria-controls="nav-home2" aria-selected="true">Авторизация</a>
                                    <a class="checkout_nav_link nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile2" role="tab" aria-controls="nav-profile2" aria-selected="false">Регистрация</a>
                                </div>
                            </nav>

                            <div class="checkout_tab_content tab-content" id="nav-tabcontent">
                                <div class="checkout_tab_pane tab-pane fade show active" id="nav-home2" role="tabpanel" aria-labelledby="nav-home-tab">
                                    <form method="POST" action="{{ route('login') }}">
                                        @csrf
                                        <div class="row check_authorization_1">
                                            <div class="col-12 tab_pane_content">
                                                <label for="autorization_email">
                                                    <span style="color: red;">*</span>
                                                    Электронная почта
                                                    <input id="autorization_email" type="email" class="@error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                                                    @error('email')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                    @enderror
                                                </label>
                                            </div>
                                        </div>
                                        <div class="row check_authorization_2">
                                            <div class="col-12 tab_pane_content">
                                                <label for="autorization_password"><span style="color: red;">*</span> Пароль
                                                <input id="autorization_password" type="password" class="@error('password') is-invalid @enderror" name="password" required autocomplete="current-password"></label>
                                                @error('name')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="row check_authorization_3">
                                            <div class="col-lg-12"><button class="authorization_btn">Авторизация</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="checkout_tab_pane tab-pane fade" id="nav-profile2" role="tabpanel" aria-labelledby="nav-profile-tab">
                                    <form method="POST" action="{{ route('register') }}">
                                        @csrf
                                    <div class="row check_registration_1">
                                        <div class="col-12 tab_pane_content">
                                            <label for="registration_surname"><span style="color: red;">*</span> Фамилия<input id="registration_surname" type="text" class="@error('last_name') is-invalid @enderror" name="last_name" value="{{ old('last_name') }}"  autocomplete="name" autofocus></label>
                                        @error('last_name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                        </div>
                                    </div>
                                    <div class="row check_registration_2">
                                        <div class="col-12 tab_pane_content">
                                            <label for="registration_name"><span style="color: red;">*</span> Имя <input id="registration_name" type="text" class="@error('name') is-invalid @enderror" name="name" value="{{ old('name') }}"  autocomplete="name" autofocus></label>
                                            @error('name')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row check_registration_3">
                                        <div class="col-12 tab_pane_content">
                                            <label for="registration_email"><span style="color: red;">*</span>  Электронная почта<input id="registration_email" type="email" class="@error('email') is-invalid @enderror" name="email" value="{{ old('email') }}"  autocomplete="email"></label>
                                            @error('email')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row check_registration_4">
                                        <div class="col-12 tab_pane_content">
                                            <label for="registration_password"><span style="color: red;">*</span>  Пароль<input id="registration_password" type="password" class="@error('password') is-invalid @enderror" name="password"  autocomplete="new-password"></label>
                                            @error('password')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row check_registration_5">
                                        <div class="col-12 tab_pane_content">
                                            <label for="password_confirm"><span style="color: red;">*</span>  Повторить пароль<input id="password_confirm" type="password" name="password_confirmation"  autocomplete="new-password"></label>
                                             @error('password')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row check_registration_6">
                                        <div class="col-12 tab_pane_content">
                                            <label for="confirm"><input id="confirm" required="" type="checkbox"> <span id="privacy_policy_text">Я даю свое согласие на обработку моих персональных данныx в соответствии с <a href="/agreement" target="blink" id="privacy_policy">политикой конфиденциальности.</a></span></label>
                                            @error('password')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row check_registration_5">
                                        <div class="col-12 tab_pane_content"><button class="registration_btn">Регистрация</button></div>
                                    </div>
                                 </form>
                                </div>
                            </div>
                        </div>
                    @endauth
                @endif
                @if (Route::has('login'))
                    @auth
                        <div class="col-lg-5 col-md-6 col-sm-12 col-12">
                        @else
                        <div class="col-lg-5 col-md-6 col-sm-12 col-12 mt-3">
                    @endauth
                    @endif
                    <div>
                        <h3 class="checkout_page_headers">Способы оплаты</h3>
                    </div>
                    <form>
                        <div class="payment_methods">
                            <input name="pay" id="payment_method_1" type="radio" checked value="1"><label for="payment_method_1"> Оплата наличными при получении</label>
                        </div>
                        <div class="payment_methods">
                            <input name="pay" id="payment_method_2" type="radio" value="2"><label for="payment_method_2"> Оплата банковской картой при получении</label>
                        </div>
                        <div class="payment_methods">
                            <input name="pay" id="payment_method_3" type="radio" value="3"><label for="payment_method_3"> Оплата банковской картой на сайте</label>
                        </div>
                        <div class="payment_methods">
                            <input name="pay" id="payment_method_4" type="radio" value="4"><label for="payment_method_4"> Банковский перевод</label>
                        </div>
                    </form>
                </div>
                <div class="col-lg-5 col-md-6 col-sm-12 col-12 checkout_block_5">

                </div>
            </div>
            <div class="row justify-content-center next_step_btn_container">
            	<div class="col-10 btn_container">
            		<div class="next_step_button to_delivery">Далее <i class="further_icon fas fa-arrow-right"></i></div>
            	</div>
            </div>
        </div>
    </article>
@endsection

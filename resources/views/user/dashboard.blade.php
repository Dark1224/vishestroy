@extends('layouts.app')

@section('content')


<article>
    <div class="container-fluid">
        <div class="row pp_nav_tabs justify-content-center">
            <div class="col-md-6 col-lg-3">
                <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                    <a class="nav-link pp_nav_link " id="v-pills-home-tab" data-toggle="pill" href="#v-pills-home" role="tab" aria-controls="v-pills-home" aria-selected="true">Настройки</a>
                    <a class="nav-link pp_nav_link active" id="v-pills-profile-tab" data-toggle="pill" href="#v-pills-profile" role="tab" aria-controls="v-pills-profile" aria-selected="false">История покупок</a>
                </div>
            </div>
            <div class="col-lg-7">
                <div class="tab-content" id="v-pills-tabContent">
                    <div class="tab-pane fade " id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab">

                        <form id="dashboard_config" method="post">
                            @csrf
                                <div class="row justify-content-center">
                                        <div class="col-lg-10 col-md-10 col-sm-12 col-12">
                                            <div class="container-fluid">
                                                <div class="form-group row">
                                                    <label for="name" class="col-md-12 col-form-label"> {{ __('Аватар') }}</label>

                                                    <div class="col-md-12">
                                                        <input id="name" type="hidden" class="form-control" name="image" value="{{$user->avatar}}">

                                                        <div class="choose_avatar">
                                                            @if($user->avatar)
                                                                <img src="{{$user->avatar}}">
                                                            @else
                                                                <i class="fas fa-plus"></i>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                        <nav>
                                            <div class="checkout_nav_tabs nav nav-tabs" id="nav-tab" role="tablist">
                                                <a class="checkout_nav_link nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true"></a>
                                            </div>
                                        </nav>
                                        <div class="checkout_tab_content tab-content" id="nav-tabContent">

                                            <div class="checkout_tab_pane tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">

                                                <div class="row check_field_1">
                                                    <div class="col-12 tab_pane_content"><label for="individual_name"><span style="color: red;">*</span> Фамилия<input id="individual_name" name="individual[name]" value="{{$user->last_name}}" type="text" disabled></label></div>
                                                </div>
                                                <div class="row check_field_2">
                                                    <div class="col-12 tab_pane_content"><label for="individual_surname"><span style="color: red;">*</span> Имя<input id="individual_surname" name="individual[surname]" value="{{$user->name}}" type="text" disabled></label></div>
                                                </div>
                                                <div class="row check_field_3">
                                                    <div class="col-lg-7 tab_pane_content"><label for="individual_email"><span style="color: red;">*</span> Электронная почта<input id="individual_email" name="individual[email]" value="{{$user->email}}" type="email" disabled></label></div>
                                                    <div class="col-lg-5 tab_pane_content"><label for="individual_tel"><span style="color: red;">*</span> Телефон<input id="individual_tel" name="individual[tel]" value="{{$user->tel}}" type="tel" disabled></label></div>
                                                </div>
                                            </div>

                                        </div>
                                            <div class="row check_registration_5">
                                                <div class="col-12 tab_pane_content">
                                                    <button type="submit" class="registration_btn dashboard_save" style="display: none">Сохранить</button>
                                                    <button class="registration_btn dashboard_edit">Редактировать</button>
                                                </div>
                                            </div>
                                        </div>
                                </div>

                            </div>
                        </form>

                    </div>
                    <div class="tab-pane fade show active" id="v-pills-profile" role="tabpanel" aria-labelledby="v-pills-profile-tab">
                        <div id = "tab_pane_title" class="row">
                            <div class="col-md-2">Номер заказа</div>
                            <div class="col-md-2">Дата заказа</div>
                            <div class="col-md-2">Сумма</div>
                            <div class="col-md-2">Статус</div>
                            <div class="col-md-2"></div>
                            <div class="col-md-2"></div>
                        </div>
                        @foreach($orders as $key => $val)
                            <div class="row order_row">
                                <div class="order_id col-md-2"><span>Номер заказа: </span> {{$val->uid}}</div>
                                <div class="col-md-2 created_at"><span>Дата заказа: </span> {{$val->created_at}}</div>
                                <div class="price col-md-2"><span>Сумма: </span> {{$val->total_price}} р.</div>
                                <div class="col-md-2 status"><span>Статус: </span> {{$val->status}}</div>
                                <div class="col-md-2"><div class="pay mt-0 col-md-12" data-id="{{$val->uid}}">Оплатить</div></div>
                                <div class="col-md-2"><div class="more_info mt-0 col-md-12" data-id="{{$val->uid}}">Подробнее</div></div>
                            </div>
                        @endforeach
                        <div class="product_types_pagination" style="margin-top: 30px;">
                            {{ $orders->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</article>


<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title order_number" id="exampleModalLabel">Заказ № <span></span></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-3">Изоброжене</div>
                    <div class="col-md-3">Нозвание товара</div>
                    <div class="col-md-2">Кол-во</div>
                    <div class="col-md-2">Стоимость</div>
                    <div class="col-md-2">Сумма</div>
                </div>
                <div class="about_product">

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Закрыть</button>
            </div>
        </div>
    </div>
</div>
@endsection

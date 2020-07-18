@extends('admin.dashboard.layout')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <form enctype="multipart/form-data" action="{{ route('admin.dashboard.edit.product.post', array('id'=> $id)) }}" method="post">
                @csrf
                <div class="form-group">
                    <label for="name">Название</label>
                    <input type="text" class="form-control" id="name" placeholder="" name="name" value="{{$main_product->name}}">
                </div>
                <div class="form-group">
                    <label for="name">Артикул</label>
                    <input type="text" class="form-control" id="article" placeholder="" name="article" value="{!! str_replace('"', '', $main_product->article) !!}">
                </div>
                <div class="form-group">
                    <label for="category_name">Категория</label>
                    <select class="form-control" id="category_name" name="category_name">
                        <option value="0"></option>
                        @foreach($menu as $menu_el)
                            <option {{ $main_product->category == $menu_el->id ? 'selected' : ''}} value="{{$menu_el->id}}">{{$menu_el->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="description">Описание</label>
                    <textarea class="form-control" id="description" name="description" rows="10">{{$main_product->description}}</textarea>
                </div>
                <div class="form-group">
                    <label for="manufacturer">Прозводитель</label>
                    <select class="form-control select2" id="manufacturer" name="manufacturer">
                        <option value="0"></option>
                        @foreach($manufacturer as $key => $val)
                            <option value="{{$val->id}}" {{$main_product->manufacturer == $val->id ? 'selected' : ''}}>{{$val->name}}</option>
                        @endforeach

                    </select>
                </div>
                <div class="form-check">
                    <input class="form-check-input" value="1" {{$main_product->available == 1 ? 'checked' : ''}} type="checkbox" name="available" id="available">
                    <label class="form-check-label" for="available">
                        Есть на складе
                    </label>
                </div>
                <div class="form-group">
                    <label for="unit">ед. измерения</label>
                    <select class="form-control" id="unit" name="unit">
                        <option value="0"></option>
                        @foreach($unit as $key => $val)
                            <option value="{{$val->id}}" {{$main_product->unit == $val->id ? 'selected' : ''}}>{{$val->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="in_package">В упоковке</label>
                    <input type="number" class="form-control" id="in_package" placeholder="" value="{{ $main_product->in_package }}" name="in_package">
                </div>
                <div class="image_section">
                    @foreach(json_decode($main_product->img_path) as $key => $val)
                        <div class="img_block remove">
                            <input type="hidden" value="{{ $val }}" name="image[{{$key}}]">
                            <img src="{{ $val }}" alt="">
                        </div>
                    @endforeach
                    <div class="add_image">
                        <i class="fas fa-plus"></i>
                    </div>
                </div>
                <div class="form-group additional_section">
                    <p class="add_info">Добавить дополнительную информацию</p>
                    @if($main_product->additional != null || $main_product->additional != '')
                        @foreach(json_decode($main_product->additional) as $key => $val)
                            <div class="form-row mt-3 align-items-center">
                                <div class="col">
                                    <input type="text" class="form-control" placeholder="Description" value="{{ $val->desc }}" name="additional_info[{{ $key }}][desc]">
                                </div>
                                <div class="col">
                                    <input type="text" class="form-control" placeholder="Value" value="{{ $val->val }}" name="additional_info[{{ $key }}][val]">
                                </div>
                                <span class="remove_info"> X </span>
                            </div>
                        @endforeach
                     @else
                         <div class="form-row mt-3 align-items-center">
                             <div class="col">
                                 <input type="text" class="form-control" placeholder="Description" value="" name="additional_info[1][desc]">
                             </div>
                             <div class="col">
                                 <input type="text" class="form-control" placeholder="Value" value="" name="additional_info[1][val]">
                             </div>
                             <span class="remove_info"> X </span>
                         </div>
                     @endif
                </div>
                <div class="form-group">
                    <label for="buy_with">С этим товаром покупают</label>
                    <select multiple class="form-control select2" id="buy_with" name="buy_with[]">
                        <option value="0"></option>
                        @if($main_product->buy_with == 'null')
                            @foreach($products as $product)
                                <option value="{{$product->id}}">{{$product->name}}</option>
                            @endforeach
                        @else
                            @foreach(json_decode($main_product->buy_with) as $product_main)
                                @foreach($products as $product)
                                <option {{  $product_main == $product->id ? 'selected' : '' }} value="{{$product->id}}">{{$product->name}}</option>
                                @endforeach
                            @endforeach
                        @endif
                    </select>
                </div>
                <div class="form-group">
                    <label for="similar">Похожие товары</label>
                    <select multiple class="form-control select2" id="similar" name="similar[]">
                        <option value="0"></option>
                        @if($main_product->similar == 'null')
                            @foreach($products as $product)
                                <option value="{{$product->id}}">{{$product->name}}</option>
                            @endforeach
                        @else
                            @foreach(json_decode($main_product->similar) as $product_main)
                                @foreach($products as $product)
                                    <option {{  $product_main == $product->id ? 'selected' : '' }} value="{{$product->id}}">{{$product->name}}</option>
                                @endforeach
                            @endforeach
                        @endif
                    </select>
                </div>
                <div class="form-check">
                    <input {{ $main_product->bestseller == 1 ? 'checked' : ''}} class="form-check-input" value="1" type="checkbox" name="bestseller" id="bestseller">
                    <label class="form-check-label" for="bestseller">
                        Хит продаж
                    </label>
                </div>
                <div class="form-check">
                    <input {{ $main_product->sel_lout == 1 ? 'checked' : ''}} class="form-check-input" value="1" type="checkbox" name="sel_lout" id="sel_lout">
                    <label class="form-check-label" for="sel_lout">
                        Распродажа
                    </label>
                </div>
                <div class="form-check">
                    <input {{ $main_product->new == 1 ? 'checked' : ''}} class="form-check-input" value="1" type="checkbox" name="new" id="new">
                    <label class="form-check-label" for="new">
                        Новинка
                    </label>
                </div>
                <div class="form-group">
                    <label for="delivery">Доставка</label>
                    <input type="text" class="form-control" id="delivery" value="{{ $main_product->delivery }}" placeholder="" name="delivery">
                </div>
                <div class="form-group">
                    <label for="pickup">Самовывоз</label>
                    <input type="text" class="form-control" id="pickup" value="{{ $main_product->pickup }}" placeholder="" name="pickup">
                </div>
                <div class="form-group">
                    <label for="old_price">Старая цена</label>
                    <input type="text" min="0" class="form-control" value="{{ $main_product->old_price }}" id="old_price" placeholder="" name="old_price">
                </div>
                <div class="form-group">
                    <label for="price">Цена</label>
                    <input type="text" min="0" class="form-control" value="{{ $main_product->price }}" id="price" placeholder="" name="price">
                </div>
                <div class="video_section">
                    <p class="add_video">Добавить видео</p>
                    @if($main_product->video !== 'null' && $main_product != '')
                        @foreach(json_decode($main_product->video) as $key => $val)
                            <div class="form-group">
                                <label for="category_video">Вдео</label>
                                <input type="text" class="form-control-file" value="{{ $val }}" name="video[{{ $key }}]">
                                <span class="remove_video"> X </span>
                            </div>
                        @endforeach
                    @else
                        <div class="form-group">
                            <label for="category_video">Вдео</label>
                            <input type="text" class="form-control-file" name="video[1]">
                            <span class="remove_video"> X </span>
                        </div>
                    @endif
                </div>
                <div class="form-check">
                    <input class="form-check-input" value="1" checked type="checkbox" name="is_active" id="is_active">
                    <label class="form-check-label" for="is_active">
                        Активен
                    </label>
                </div>
                <button type="submit" class="btn btn-primary">Сохранить</button>
            </form>
        </div>
    </div>
</div>
@endsection

@extends('admin.dashboard.layout')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <form enctype="multipart/form-data" action="{{ route('admin.dashboard.add.product.post') }}" method="post">
                @csrf
                <div class="form-group">
                    <label for="name">Название</label>
                    <input type="text" class="form-control" id="name" placeholder="" name="name">
                </div>
                <div class="form-group">
                    <label for="article">Артикул</label>
                    <input type="text" class="form-control" id="article" placeholder="" name="article">
                </div>
                <div class="form-group">
                    <label for="category_name">Категория</label>
                    <select class="form-control" id="category_name" name="category_name">
                        <option value="0"></option>
                        @foreach($menu as $menu_el)
                            <option value="{{$menu_el->id}}">{{$menu_el->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="description">Описание</label>
                    <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                </div>
                <div class="form-group">
                    <label for="manufacturer">Прозводитель</label>
                    <select class="form-control select2" id="manufacturer" name="manufacturer">
                        <option value="0"></option>
                        @foreach($manufacturer as $key => $val)
                        <option value="{{$val->id}}">{{$val->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-check">
                    <input class="form-check-input" value="1" checked type="checkbox" name="available" id="available">
                    <label class="form-check-label" for="available">
                        Есть на складе
                    </label>
                </div>
                <div class="form-group">
                    <label for="unit">ед. измерения</label>
                    <select class="form-control" id="unit" name="unit">
                        <option value="0"></option>
                        @foreach($unit as $key => $val)
                            <option value="{{$val->id}}">{{$val->name}}</option>
                        @endforeach

                    </select>
                </div>
                <div class="form-group">
                    <label for="in_package">В упоковке</label>
                    <input type="number" class="form-control" id="in_package" placeholder="" name="in_package">
                </div>
                <div class="image_section">
                    {{--<p class="add_image">Add Image</p>--}}
                    {{--<div class="form-group">--}}
                        {{--<label for="category_img">Product Image</label>--}}
                        {{--<input type="file" class="form-control-file" name="image[1]">--}}
                        {{--<span class="remove_image"> X </span>--}}
                    {{--</div>--}}
                    <div class="add_image">
                        <i class="fas fa-plus"></i>
                    </div>
                </div>
                <div class="form-group additional_section">
                    <p class="add_info">Добавить дополнительную информацию</p>
                    <div class="form-row mt-3 align-items-center">
                        <div class="col">
                            <input type="text" class="form-control" placeholder="Описание" name="additional_info[1][desc]">
                        </div>
                        <div class="col">
                            <input type="text" class="form-control" placeholder="Значение" name="additional_info[1][val]">
                        </div>
                        <span class="remove_info"> X </span>
                    </div>
                </div>
                <div class="form-group">
                    <label for="buy_with">С этим товаром покупают</label>
                    <select multiple class="form-control select2" id="buy_with" name="buy_with[]">
                        <option value="0"></option>
                        @foreach($products as $product)
                            <option value="{{$product->id}}">{{$product->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="similar">Похожие товары</label>
                    <select multiple class="form-control select2" id="similar" name="similar[]">
                        <option value="0"></option>
                        @foreach($products as $product)
                            <option value="{{$product->id}}">{{$product->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-check">
                    <input class="form-check-input" value="1" type="checkbox" name="bestseller" id="bestseller">
                    <label class="form-check-label" for="bestseller">
                        Хит продаж
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" value="1" type="checkbox" name="sel_lout" id="sel_lout">
                    <label class="form-check-label" for="sel_lout">
                        Распродажа
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" value="1" type="checkbox" name="new" id="new">
                    <label class="form-check-label" for="new">
                        Новинка
                    </label>
                </div>
                <div class="form-group">
                    <label for="delivery">Доставка</label>
                    <input type="text" class="form-control" id="delivery" placeholder="" name="delivery">
                </div>
                <div class="form-group">
                    <label for="pickup">Самовывоз</label>
                    <input type="text" class="form-control" id="pickup" placeholder="" name="pickup">
                </div>
                <div class="form-group">
                    <label for="old_price">Старая цена</label>
                    <input type="text" min="0" class="form-control" id="old_price" placeholder="" name="old_price">
                </div>
                <div class="form-group">
                    <label for="price">Цена</label>
                    <input type="text" min="0" class="form-control" id="price" placeholder="" name="price">
                </div>
                <div class="video_section">
                    <p class="add_video">Добавить видео</p>
                    <div class="form-group">
                        <label for="category_video">Вдео</label>
                        <input type="text" class="form-control-file" name="video[1]">
                        <span class="remove_video"> X </span>
                    </div>
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

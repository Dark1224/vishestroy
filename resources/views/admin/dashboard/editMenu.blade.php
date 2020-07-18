@extends('admin.dashboard.layout')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <form enctype="multipart/form-data" action="{{ route('admin.dashboard.edit.categories.post', array('id' => $id)) }}" method="post">
                @csrf
                <div class="form-group">
                    <label for="name">Имя Категории</label>
                    <input type="text" class="form-control" id="name" placeholder="" name="cat_name" value="{{$menu_info->name}}">
                </div>
                <div class="form-group">
                    <label for="category_name">Родительская категория</label>
                    <select class="form-control" id="category_name" name="cat_parent">
                        <option value="0"></option>
                        @foreach($menu as $menu_el)
                            <option {{ $menu_info->parent_id == $menu_el->id ? 'selected="selected"' : '' }} value="{{$menu_el->id}}">{{$menu_el->name}}</option>
                        @endforeach
                    </select>
                </div>
                <label for="category_img">Изображение категории</label>
                <div class="image_section">
                    {{--<input type="file" class="form-control-file" id="category_img" name="cat_image" files="{{public_path().'\\'.}}" value="">--}}
                        <div class="img_block remove">
                            <input type="hidden" value="{{ $menu_info->img_path }}" name="image[1]">
                            <img src="{{ $menu_info->img_path }}" alt="">
                        </div>
                    <div class="add_image">
                        <i class="fas fa-plus"></i>
                    </div>
                </div>
                <div class="form-check">
                    <input class="form-check-input" value="1" {{ $menu_info->active == 1 ? 'checked' : '' }} type="checkbox" name="is_active" id="is_active">
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

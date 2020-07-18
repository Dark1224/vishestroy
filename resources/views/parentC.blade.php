@extends('layouts.app')

@section('content')
<article>
    <div class="container-fluid">
        <div class="page_header row justify-content-center">
            <div class="col-lg-10 col-md-12 col-sm-12">
                <h1 class="page_header">{{$menu_info->name}}</h1>
            </div>
        </div>
        <div class="article row justify-content-center">
            <!-- <div class="aside aside_cat col-xl-2 col-lg-3">
                <div class="improve">
                <a href="/product/1">
                    <img src="/img/bg-pictures/tytan-advertasing.jpg">
                </a>
                </div>
            </div> -->
            <div class="categories_page_block col-lg-10 col-sm-12">
                <ul>
                    @foreach($children['children'] as $key => $val)
                        <li>
                            <a href="/category/{{$val->id}}">
                                <div class="subcategory_tipes">
                                    <img src="{{$val->img_path}}">
                                    <h5 class="subcategory_name sb_n1">{{$val->name}}</h5>
                                </div>
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</article>
@endsection

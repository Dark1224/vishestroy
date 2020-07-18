@section('header')
<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    {{--<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">--}}
    <script src="https://kit.fontawesome.com/dd6c14d342.js"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="/css/app.css">
    <title> Dashboard</title>
</head>
<body>
<div class="container-fluid">
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">Dashboard</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav w-100">
                <li class="nav-item active">
                    <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('admin.dashboard.show.categories')}}">Categories</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('admin.dashboard.show.products')}}">Products</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('admin.dashboard.show.fields')}}">Fields for products</a>
                </li>
                <li class="nav-item dropdown ml-auto">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Admin
                    </a>
                    <div class="dropdown-menu" id="dropdown-menu-logout" aria-labelledby="navbarDropdownMenuLink">
                        <a class="dropdown-item" href="#">Config</a>
                        <a class="dropdown-item" href="{{ route('admin.logout') }}">Logout</a>
                    </div>
                </li>
            </ul>
        </div>
    </nav>
</div>
@show

@yield('content')

{{--<button type="button" class="btn btn-primary" data-toggle="modal" data-target=".bd-example-modal-xl">Extra large modal</button>--}}

<div class="modal fade bd-example-modal-xl" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row justify-content-between p-3">
                    <div class="img_block choose_folder" data-src="images">
                        <img width="35px" src="/img/return.png" alt="">
                    </div>
                    <div class="upload_image">
                        <img width="35px" src="/img/upload_image.png" alt="">
                    </div>
                </div>
                <form class="hidden" id="imageUploadForm" enctype="multipart/form-data" action="{{ route('admin.dashboard.upload.image') }}" method="post">
                    @csrf
                    <div class="form-group">
                        <input type="file" class="form-control-file" name="image" id="ImageBrowse">
                    </div>
                </form>
                <div class="row p-3">
                    <div class="pop_up_image_section justify-content-between">

                    </div>
                </div>
            </div>
            <div class="modal-footer">

            </div>
        </div>
    </div>
</div>
@section('footer')
{{--<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>--}}
{{--<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>--}}
{{--<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>--}}
{{--<script src="https://api-maps.yandex.ru/2.1/?apikey=ec9aa1bf-ee39-49b0-989a-0aedf6b79f0b&lang=ru_RU" type="text/javascript"></script>--}}
<script src="/js/app.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/js/select2.min.js"></script>
<script>

</script>
</body>
</html>
@show

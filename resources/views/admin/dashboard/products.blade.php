@extends('admin.dashboard.layout')
@section('content')
    <div class="form-group ml-3">
        <label>Search</label>
        <input type="text" class="form-control w-25" id="searchForAdmin">
    </div>
    <a href="{{ route('admin.dashboard.add.product') }}" class="float-right">Add Product</a>
    <table class="table" id="productTable">
        <thead>
        <tr>
            <th scope="col">№</th>
            <th scope="col">Name</th>
            <th scope="col">Image</th>
            <th scope="col">Category Name</th>
            <th scope="col">Is Active</th>
            <th scope="col">Acton</th>
        </tr>
        </thead>
        <tbody>
        @foreach($products as $product)
            <tr>
                <th scope="row">{{$product->id}}</th>
                <td>{{$product->name}}</td>
                <td><img height="100px" src="{{$product->img_path != '' && !empty(json_decode($product->img_path))  ? json_decode($product->img_path)[0] : ''}}"></td>
                <td>{{$product->category}}</td>
                <td>{{$product->active}}</td>
                <td><a href="{{ route('admin.dashboard.edit.product.post', array('id' => $product->id)) }}">edit</a> | <a href="{{ route('admin.dashboard.remove.product', array('id' => $product->id)) }}">remove</a></td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <div class="product_types">
        {{ $products->links() }}
    </div>
@endsection

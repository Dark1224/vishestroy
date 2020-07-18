@extends('admin.dashboard.layout')
@section('content')
<a href="{{ route('admin.dashboard.add.categories') }}" class="float-right">Add Menu</a>
<table class="table">
    <thead>
    <tr>
        <th scope="col">№</th>
        <th scope="col">Image</th>
        <th scope="col">Category Name</th>
        <th scope="col">Parent Category Id</th>
        <th scope="col">Is Active</th>
        <th scope="col">Acton</th>
    </tr>
    </thead>
    <tbody>
    @foreach($menu as $menu_item)
        <tr>
            <th scope="row">{{$menu_item->id}}</th>
            <td><img width="150px" src="{{$menu_item->img_path != '' ? $menu_item->img_path : ''}}"></td>
            <td>{{$menu_item->name}}</td>
            <td>{{$menu_item->parent_id}}</td>
            <td>{{$menu_item->active}}</td>
            <td><a href="{{ route('admin.dashboard.edit.categories.post', array('id' => $menu_item->id)) }}">edit</a> | <a href="{{ route('admin.dashboard.remove.categories', array('id' => $menu_item->id)) }}">remove</a></td>
        </tr>
        
    @endforeach
    </tbody>
</table>
<div class="product_types">
    {{ $menu->links() }}
</div>
@endsection

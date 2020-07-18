@extends('admin.dashboard.layout')
@section('content')
    <div class="container-fluid">
        <div class="row mt-3">
            <div class="col-3">
                <div class="list-group" id="list-tab" role="tablist">
                    @foreach($fields as $key => $val)
                    <a class="list-group-item list-group-{{$val->name}}-action filed_name" id="list-{{$val->name}}-list" data-toggle="list" href="#list-{{$val->name}}"  data-id="{{$val->id}}" role="tab" aria-controls="{{$val->name}}">{{$val->name}}</a>
                    @endforeach
                </div>
            </div>
            <div class="col-9 text-right">
                <input class="btn btn-primary add_vals" type="button" value="Add values" data-toggle="modal" data-target="#exampleModal">
                <div class="tab-content text-left" id="nav-tabContent">
                    @foreach($fields as $key => $val)
                    <div class="tab-pane fade show" id="list-{{$val->name}}" role="tabpanel" aria-labelledby="list-{{$val->name}}-list">
                       <ul class="fileds_ul" data-id="{{$val->id}}">

                       </ul>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>



    <div class="modal fade" id="edit" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit value</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="col">
                        <input type="hidden" name="value_id">
                        <input type="text" class="form-control" name="edit_value" placeholder="Value name">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary submit_edit">Save changes</button>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Value</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="col">
                        <input type="hidden" name="field">
                        <input type="text" class="form-control" name="value" placeholder="Value name">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary submit_value">Add</button>
                </div>
            </div>
        </div>
    </div>
@endsection

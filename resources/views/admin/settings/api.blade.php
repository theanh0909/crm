@extends('admin.layouts.app_new')

@section('content')
@include('admin.layouts.includes.breadcrumb', ['item1' => 'Setting', 'item2' => 'Cấu hình API'])
<div class="container">
    <div class="card card-custom">
        <div class="card-header py-3">
            <div class="card-title">
                <span class="card-icon">
                    <span class="svg-icon svg-icon-md svg-icon-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                <rect x="0" y="0" width="24" height="24" />
                                <rect fill="#000000" opacity="0.3" x="12" y="4" width="3" height="13" rx="1.5" />
                                <rect fill="#000000" opacity="0.3" x="7" y="9" width="3" height="8" rx="1.5" />
                                <path d="M5,19 L20,19 C20.5522847,19 21,19.4477153 21,20 C21,20.5522847 20.5522847,21 20,21 L4,21 C3.44771525,21 3,20.5522847 3,20 L3,4 C3,3.44771525 3.44771525,3 4,3 C4.55228475,3 5,3.44771525 5,4 L5,19 Z" fill="#000000" fill-rule="nonzero" />
                                <rect fill="#000000" opacity="0.3" x="17" y="11" width="3" height="6" rx="1.5" />
                            </g>
                        </svg>
                    </span>
                </span>
                <h3 class="card-label">
                    Cấu hình API
                </h3>
            </div>
        </div>
        @include('admin.layouts.partitals.notify')
        <div class="card-body">
            <div class="list-icons">
                <button type="button" class="btn btn-info" class="btn btn-warning" data-toggle="modal" data-target="#createAPI">
                    <i class="fa fa-plus"></i> Tạo mới
                </button>
            </div>
        </div>
        <div class="card-header">
            <!-- Modal -->
            <div class="modal fade" id="createAPI" tabindex="-1" role="dialog" aria-labelledby="createAPI" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        {!! Form::open(['url' => route('admin.settings.createApi'), 'method' => 'POST']) !!}
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Create KEY</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group row">
                                <label class="col-form-label col-lg-2">Domain</label>
                                <div class="col-lg-10">
                                    <input type="text" name="domain" class="form-control">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-form-label col-lg-2">KEY</label>
                                <div class="col-lg-10">
                                    <input type="text" name="key" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Create</button>
                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
            <table class="table">
                <thead>
                <tr>
                    <th>Domain</th>
                    <th>API KEY</th>
                    <th width="200">Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach($models as $item)
                    <tr>
                        <td>{{$item->domain}}</td>
                        <td>{{$item->key}}</td>
                        <td>
                            {{Form::open(['url' => route('admin.settings.deleteApi', ['id' => $item->id]), 'method' => 'DELETE'])}}

                            <a class="btn btn-secondary" href="{{route('admin.settings.editApi', ['id' => $item->id])}}">
                                <i class="fa fa-key"></i>
                            </a>
                            <button class="btn btn-danger" type="submit" onclick="return confirm('Delete this item?')">
                                <i class="flaticon2-rubbish-bin-delete-button"></i>
                            </button>
                            {{Form::close()}}
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>      
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
    function generateKey() {
        $('input[name=api_key]').val(Math.random().toString(36).substr(2)).change();
    }
</script>
@endsection
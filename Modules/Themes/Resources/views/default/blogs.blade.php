@extends('themes::default.layout')
@section('content')

<!-- Header -->
<header class="ex-header">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1>@lang('All blogs')</h1>
            </div> <!-- end of col -->
        </div> <!-- end of row -->
    </div> <!-- end of container -->
</header> <!-- end of ex-header -->
<!-- end of header -->

<!-- Basic -->
<div class="ex-basic-1 mt-4 pt-4">
    <div class="container">
        <div class="row">
            @foreach($data as $item)
                <div class="col-md-4 col-xs-12 col-sm-6">
                    @include('themes::default.includes.item_blog', ['blog' => $item])
                </div>
            @endforeach
        </div> <!-- end of row -->
        <div class="row my-5">
            <div class="col-auto">
                {{ $data->appends( Request::all() )->links() }}
            </div>
        </div>
    </div> <!-- end of container -->
</div> <!-- end of ex-basic-1 -->
<!-- end of basic -->
@stop

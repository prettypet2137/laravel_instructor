@extends('themes::default.layout')
@section('content')

<!-- Header -->
<header class="ex-header">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1>{{$page->title}}</h1>
            </div> <!-- end of col -->
        </div> <!-- end of row -->
    </div> <!-- end of container -->
</header> <!-- end of ex-header -->
<!-- end of header -->





<!-- Basic -->
<div class="ex-basic-1 pt-4">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                {!!$page->description!!}
            </div>
        </div> <!-- end of row -->
    </div> <!-- end of container -->
</div> <!-- end of ex-basic-1 -->
<!-- end of basic -->
@stop
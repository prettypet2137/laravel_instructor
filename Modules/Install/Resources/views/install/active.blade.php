@extends('install::layouts.install')
@section('content')
<div class="col-lg-10">
    <form method="post" action="{{ route('install.activepost') }}" autocomplete="off">
        @csrf
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Activate license</h3>
            </div>
            <div class="card-body">
                <div class="row mb-2 mt-2">
                    <div class="col-lg-12 text-primary">
                        <h4>Activate license</h4>
                    </div>
                </div>
                 <div class="row">
                    <div class="col-lg-12">
                        
                        <div class="form-group">
                            <label class="form-label">Item Purchase Code</label>
                            <input type="text" value="" required name="PURCHASE_CODE" value="{{ old('PURCHASE_CODE') }}" class="form-control" placeholder="Purchase code">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Enter username envato</label>
                            <input type="text" value="" name="USER_NAME_OR_EMAIL" value="{{ old('USER_NAME_OR_EMAIL') }}" class="form-control" placeholder="Enter username envato">
                        </div>
                    </div>
                </div>
               
            </div>
            <div class="card-footer">
                <div class="">
                    <button type="submit" class="btn btn-block btn-primary">Submit</button>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
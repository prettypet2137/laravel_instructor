@extends('install::layouts.install')
@section('content')
<div class="col-lg-10">
    <form method="post" action="{{ route('install.db') }}" autocomplete="off">
        @csrf
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Application</h3>
            </div>
            <div class="card-body">
                <div class="row mb-2 mt-2">
                    <div class="col-lg-12 text-primary">
                        <h4>Application &amp; Database Setup</h4>
                    </div>
                </div>
                <div class="row">
                    
                    <div class="col-lg-6">

                        <div class="form-group">
                            <label class="form-label">Application URL</label>
                            <input type="text" name="APP_URL" value="{{ old('APP_URL', (request()->server('HTTPS') ? 'https://' : 'http://' . request()->server('HTTP_HOST'))) }}" class="form-control" placeholder="Application URL" required="">
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">Database hostname</label>
                            <input type="text" name="DB_HOST" value="{{ old('DB_HOST', 'localhost') }}" class="form-control" placeholder="Database hostname" required="">
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">Database port</label>
                            <input type="text" name="DB_PORT" value="{{ old('DB_PORT', '3306') }}" class="form-control" placeholder="Database port" required="">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Server IP (This is used for custom domain.)</label>
                            <input type="text" name="SERVER_IP" value="{{ $SERVER_IP }}" class="form-control" placeholder="Server IP">
                        </div>
                        
                    </div>
                    <div class="col-lg-6">

                        <div class="form-group">
                            <label class="form-label">Database name</label>
                            <input type="text" required name="DB_DATABASE" value="{{ old('DB_DATABASE') }}" class="form-control" placeholder="Database name" required="">
                        </div>
                        <small>You need to create your Database first on Cpanel</small>
                        <div class="form-group">
                            <label class="form-label">Database username</label>
                            <input type="text" required name="DB_USERNAME" value="{{ old('DB_USERNAME') }}" class="form-control" placeholder="Database username" required="">
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">Database password</label>
                            <input type="text" name="DB_PASSWORD" value="{{ old('DB_PASSWORD') }}" class="form-control" placeholder="Database password">
                        </div>
                        
                        
                    </div>
                </div>
               
            </div>
            <div class="card-footer">
                @if($passed)
                <div class="col-lg-4">
                </div>
                <div class="">
                    <button type="submit" class="btn btn-block btn-primary">Next step</button>
                </div>
                @endif
            </div>
        </div>
    </form>
</div>
@endsection
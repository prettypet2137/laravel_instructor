@extends('install::layouts.install')

@section('content')

    <div class="row">
        <div class="col-lg-6">

            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Permissions</h3>
                </div>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Folder</th>
                            <th class="text-center">Permission</th>
                            <th class="text-center">Required</th>
                            <th class="text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($results['permissions'] as $permission)
                        <tr>
                            <td>
                                {{ $permission['folder'] }}
                            </td>
                            <td width="110" class="text-center">
                                {{ $permission['permission'] }}
                            </td>
                            <td width="110" class="text-center">
                                {{ $permission['required'] }}
                            </td>
                            <td width="110" class="text-center">
                                @if($permission['success'])
                                    <i class="fas fa-check-circle text-success"></i>
                                @else
                                    <i class="fas fa-times-circle text-danger"></i>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">PHP version</h3>
                    </div>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Installed</th>
                                <th class="text-center">Required</th>
                                <th class="text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    {{ $results['php']['installed'] }}
                                </td>
                                <td width="110" class="text-center">
                                    {{ $results['php']['required'] }}
                                </td>
                                <td width="110" class="text-center">
                                    @if($results['php']['success'])
                                       <i class="fas fa-check-circle text-success"></i>
                                    @else
                                        <i class="fas fa-times-circle text-danger"></i>
                                    @endif
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="card-footer">
                            @if($passed)
                                <a href="{{ route('install.passed', $passed) }}" class="btn btn-block btn-primary">Next step</a>
                            @else
                                <button type="button" class="btn btn-block btn-primary disabled" disabled>Can't be installed. Please check all requirements.</button>
                            @endif
                        </div>
                </div>

        </div>
        <div class="col-lg-6">
                <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">PHP extensions</h3>
                        </div>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Extension</th>
                                    <th class="text-center">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($results['extensions'] as $extension)
                                <tr>
                                    <td>
                                        {{ $extension['extension'] }}
                                    </td>
                                    <td width="110" class="text-center">
                                        @if($extension['success'])
                                           <i class="fas fa-check-circle text-success"></i>
                                        @else
                                            <i class="fas fa-times-circle text-danger"></i>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
        </div>

    </div>

@endsection
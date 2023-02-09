@extends('core::layouts.app')

@section('title', __('Create blog'))

@section('content')

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">@lang('Create blog')</h1>
</div>
<div class="row">
    <div class="col-md-3">
        @include('core::partials.admin-sidebar')
    </div>
    <div class="col-md-9">

        <form role="form" method="post" action="{{ route('settings.blogs.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="card">
                <div class="card-body">
                    <div class="form-group">
                        <label class="form-label">@lang('Title')*</label>
                        <input type="text" name="title" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">@lang('Categories')*</label>
                        <select name="category_id" class="form-control" required>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">@lang('Content short')*</label>
                        <textarea name="content_short" class="form-control" rows="4" required></textarea>
                    </div>
                    <div class="form-group">
                        <label class="form-label">@lang('Content')*</label>
                        <textarea name="content" id="blogContent" rows="15" class="form-control"></textarea>
                    </div>
                    <div class="form-group">
                        <div class="form-label mb-2">@lang('Thumbnail')*</div>
                        <div class="custom-file">
                            <input type="file" class="" required name="thumb" accept="image/*">
                        </div>
                        <small class="help-block">@lang('Recommended size: :size', ['size' => '100x100'])</small>
                    </div>
                    <div class="form-group">
                        <label class="form-label">@lang('Meta title for SEO')*</label>
                        <textarea name="title_seo" class="form-control" rows="4" required></textarea>
                    </div>
                    <div class="form-group">
                        <label class="form-label">@lang('Meta description for SEO')*</label>
                        <textarea name="description_seo" class="form-control" rows="4" required></textarea>
                    </div>
                    <div class="form-group">
                        <label class="form-label">@lang('Meta keyword for SEO')*</label>
                        <textarea name="keyword_seo" class="form-control" rows="4" required></textarea>
                    </div>
                    <div class="form-group">
                        <label class="form-label">@lang('Read times')</label>
                        <input type="number" min="0" step="1" name="time_read" value="0" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">@lang('Is featured')</label>
                        <div>
                            <label><input type="radio" name="is_featured" value="1" {{ old('is_featured', '1') == '1' ? 'checked' : '' }}> @lang('Yes')</label>
                            <label><input type="radio" name="is_featured" value="0" {{ old('is_featured', '1') == '0' ? 'checked' : '' }}> @lang('No')</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">@lang('Is active')</label>
                        <div>
                            <label><input type="radio" name="is_active" value="1" {{ old('is_active', '1') == '1' ? 'checked' : '' }}> @lang('Active')</label>
                            <label><input type="radio" name="is_active" value="0" {{ old('is_active', '1') == '0' ? 'checked' : '' }}> @lang('In-active')</label>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="d-flex">
                        <a href="{{ route('settings.blogs.index') }}" class="btn btn-secondary">@lang('Cancel')</a>
                        <button type="submit" class="btn btn-primary ml-auto">@lang('Save')</button>
                    </div>
                </div>
            </div>
        </form>

    </div>
    
</div>
@stop

@push('scripts')
<script>
    const TINYCME_UPLOAD_BLOG_IMAGE = "{{ route('settings.blogs.upload_image') }}";
    const CSRF_TOKEN = "{{ csrf_token() }}";
</script>
<script src="{{ Module::asset('blogs:js/blogs.js') }}"></script>
@endpush
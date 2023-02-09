<li class="nav-item">
  <a class="nav-link" href="#" data-toggle="modal" data-target="#createModal">
    <i class="fas fa-plus fa-lg"></i>
    <span class="d-none d-sm-inline-block ml-2">@lang('New event')</span>
  </a>
</li>
@php $categories = getEventCategories(); @endphp
<div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="documents_createDocumentModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">@lang('New Event')</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="createForm" action="{{ route('events.store') }}" method="post">
        @csrf
        <div class="modal-body">
          <div class="form-group">
            <label>@lang('Category'):</label>
            <select class="form-control" name="category_id" required>
              @foreach ($categories as $category)
                <option value="{{ $category->id }}">{{ $category->name }}</option>
              @endforeach
            </select>
          </div>
          <div class="form-group">
            <label>@lang('Name'):</label>
            <input type="text" class="form-control" name="name" required />
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">@lang('Close')</button>
          <button type="submit" class="btn btn-primary">@lang('Save & Edit')</button>
        </div>
      </form>
    </div>
  </div>
</div>
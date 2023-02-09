<div class="modal fade" id="createAboutModal" tabindex="-1" role="dialog" aria-labelledby="documents_createDocumentModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">@lang('Add About')</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="createForm" action="{{ route('about.store') }}" method="post">
                @csrf
                <div class="modal-body">
                    <label>@lang('Description'):</label>
                    <textarea name="add_description" id="add_description" rows="4"
                              class="form-control">{{ old('add_description') }}</textarea>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">@lang('Close')</button>
                    <button type="submit" id="s" class="btn btn-primary">@lang('Save')</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="editAboutModal" tabindex="-1" role="dialog" aria-labelledby="documents_createDocumentModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">@lang('Edit About')</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="editForm" action="{{ route('about.update',['id' => !empty($about) ? $about->id : null ]) }}" method="post">
                @method('PUT')
                @csrf
                <div class="modal-body">
                    <label>@lang('Description'):</label>
                    <textarea name="edit_description" id="edit_description" rows="4"
                              class="form-control">{!! !empty($about) ? $about->description : "" !!}</textarea>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">@lang('Close')</button>
                    <button type="submit" class="btn btn-primary">@lang('Save')</button>
                </div>
            </form>
        </div>
    </div>
</div>
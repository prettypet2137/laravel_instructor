<div class="modal fade" id="iframeEventModal" tabindex="-1" role="dialog"
     aria-labelledby="documents_createDocumentModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">@lang('Iframe Code Copier')</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <main class="main-code">
                    <div class="d-flex align-items-center mb-3">
                        <code class="language-html" style="padding: 6px 8px; border: 1px solid #dddddd;">&lt;iframe src="{{ route('all-events.index',['name' => getSlugName(auth()->user()->name)]) }}" style="width:100%;height:100vh;"&gt;&lt;/iframe&gt;</code>
                        <button class="btn btn-primary clipboard-btn" style="border-radius: 0px"><i class="fa fa-clipboard"></i> Copy</button>
                    </div>
                    <div class="form-group">
                        <label class="mr-3">Show About us form: <input type="checkbox" name="is_show_about_us_form" style="vertical-align: middle" {{ $user->is_show_about_us_form ? "checked" : "" }}/></label>
                        <label>Show Contact us form: <input type="checkbox" name="is_show_contact_us_form" style="vertical-align: middle" {{ $user->is_show_contact_us_form ? "checked" : "" }}/></label>
                    </div>
                    <iframe src="{{ route('all-events.calendar', ['name' => getSlugName(auth()->user()->name)]) }}" style="width: 100%; height: 50vh;"></iframe>
                </main>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">@lang('Close')</button>
            </div>
        </div>
    </div>
</div>
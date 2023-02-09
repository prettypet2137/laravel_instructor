<div id="modalEmailTemplate" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Email Subject and Content</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="mb-2">
                    <label>Subject</label>
                    <input type="text" name="subject" id="subject" class="form-control" value="{{old('subject')}}" required/>
                </div>
                <label>Content</label>
                <textarea name="description" id="description" rows="4"
                          class="form-control" required>{{ old('description') }}</textarea>
                <button class="btn btn-primary mt-2 send-email" type="button">
                    Submit
                </button>
                <p><span class="data-qr-code"></span></p>
                <div class="data-guest-info-items"></div>
            </div>
        </div>
    </div>
</div>
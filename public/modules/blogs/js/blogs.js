(function($) {
  "use strict";

  var config = {
    toolbar: 'styleselect visualblocks fullscreen image link codesample',
    plugins: 'visualblocks fullscreen image link codesample',
    selector: '#blogContent',
  };

  if(typeof TINYCME_UPLOAD_BLOG_IMAGE === 'string' && typeof CSRF_TOKEN === 'string') {
    config.images_upload_handler = function (blobInfo, success, failure) {
      var xhr, formData;

      xhr = new XMLHttpRequest();
      xhr.withCredentials = false;
      xhr.open('POST', TINYCME_UPLOAD_BLOG_IMAGE);

      xhr.upload.onprogress = function (e) {
        progress(e.loaded / e.total * 100);
      };

      xhr.onload = function() {
        var json;

        if (xhr.status === 403) {
          failure('HTTP Error: ' + xhr.status, { remove: true });
          return;
        }

        if (xhr.status < 200 || xhr.status >= 300) {
          failure('HTTP Error: ' + xhr.status);
          return;
        }

        json = JSON.parse(xhr.responseText);

        if (!json || typeof json.location != 'string') {
          failure('Invalid JSON: ' + xhr.responseText);
          return;
        }

        success(json.location);
      };

      xhr.onerror = function () {
        failure('Image upload failed due to a XHR Transport error. Code: ' + xhr.status);
      };

      formData = new FormData();
      formData.append('file', blobInfo.blob(), blobInfo.filename());
      formData.append('_token', CSRF_TOKEN);

      xhr.send(formData);
    }
  }

  tinymce.init(config);

})(jQuery);


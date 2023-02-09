(function ($) {

    $.fn.fileInput = function (options) {

        var settings = $.extend({
            fileList: true,
            iconClass: null,
            imgPreview: true,
            imgPreviewClass: '',
            imgPreviewSelector: null
        }, options);

        function inputValueChanged(e) {
            var input = $(this);

            var container = input.closest('.tower-file');
            var label = container.find('label');
            var clear = container.find('.tower-file-clear');
            var fileList = container.find('.tower-file-list').empty().hide();
            var imgContainer = container.find('.tower-input-preview-container');
            var img = container.find('img');
            var details = container.find('.tower-file-details');
            if (!details.length) {
                container.append('<div class="tower-file-details"></div>');
                details = container.find('.tower-file-details');
            }

            var files = input[0].files;

            var iconHtml = '';
            if (settings.iconClass !== null && settings.iconClass.length > 0) {
                iconHtml = '<span class="mdi mdi-upload"></span>';
            }

            if (files.length === 1) {
                // Single File Selected
                var file = files[0];
                label.html(iconHtml + file.name);

                if (file.type.match('image.*') && settings.imgPreview && (settings.imgPreviewSelector === null || settings.imgPreviewSelector.length < 1)) {
                    if (!img.length) {
                        details.append('<div class="tower-input-preview-container"><div class="tower-input-preview-wrapper"><img alt="" /></div></div>');
                        img = container.find('img');
                        if (settings.imgPreviewClass !== undefined && settings.imgPreviewClass.length > 0) {
                            img.addClass(settings.imgPreviewClass)
                        }
                    }

                    details.show();
                    imgContainer.show();
                    showImgPreview(file, img);
                } else if (file.type.match('image.*') && settings.imgPreview && settings.imgPreviewSelector !== null && settings.imgPreviewSelector.length > 0) {
                    img = $(settings.imgPreviewSelector);
                    if (img.length > 0 && img.is('img')) {
                        details.hide();
                        imgContainer.show();
                        showImgPreview(file, img);
                    } else {
                        throw 'The selected element must be a img';
                    }
                } else {
                    details.hide();
                    img.attr('src', '').hide();
                }
                clear.attr('disabled', null);

            } else if (files.length > 1) {
                // Multiple Files Selected
                img.attr('src', '').hide();

                if (settings.fileList) {
                    if (!fileList.length) {
                        details.append('<ul class="tower-file-list"></ul>');
                        fileList = container.find('.tower-file-list');
                    }

                    for (var i = 0; i < files.length; i++) {
                        fileList.append('<li>' + files[i].name + '</li>');
                    }
                    details.show();
                    fileList.show();
                    imgContainer.hide();
                } else {
                    fileList.hide();
                    imgContainer.hide();
                }
                label.html(iconHtml + files.length + ' Files Selected');
                clear.attr('disabled', null);

            } else {
                // No Files Selected
                details.hide();
                img.attr('src', '').hide();
                label.html(label.data('default-text'));
                clear.attr('disabled', '');
            }
        }

        // Read the file data and insert the data URL into the src
        function showImgPreview(file, img) {

            var reader = new FileReader();

            reader.onload = function (e) {
                img[0].onload = function () {
                    if (this.height > this.width) {
                        img.addClass('tower-input-preview-portrait');
                    } else {
                        img.removeClass('tower-input-preview-portrait');
                    }
                };
                img.attr('src', reader.result).show();
            };
            reader.readAsDataURL(file);
        }

        function clearInputAndDetails() {
            var container = $(this).closest('.tower-file');

            container.find('input[type="file"]').val('');

            var label = container.find('label');
            label.html(label.data('default-text'));

            container.find('.tower-file-clear').attr('disabled', '');

            var details = container.find('.tower-file-details');
            details.hide();

            if (settings.imgPreviewSelector !== null && settings.imgPreviewSelector.length > 0) {
                $(settings.imgPreviewSelector).attr('src', '');
            }
        }

        this.filter('input[type="file"]').each(function () {
            var container = $(this).closest('.tower-file');
            var label = container.find('label');
            if (label.length) {
                label.attr('data-default-text', label.html().trim());
            }

            var clear = container.find('.tower-file-clear');
            if (clear.length) {
                clear.attr('disabled', '');
                clear.on('click', clearInputAndDetails);
            }

            $(this).on('change', inputValueChanged);
        });
    };

}(jQuery));
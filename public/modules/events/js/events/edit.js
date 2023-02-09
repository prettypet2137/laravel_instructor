// init date time picker
(function () {
  $("#search_fonts").on("change", function () {
    var search_query = $(this).val();
    $.ajax({
      type: "POST",
      url: url_search_fonts,
      data: {
        search_query: search_query,
        _token: _token,
      },
      beforeSend: function () {
        $("#list_fonts").html("");
        $(`#spinner-loading-fonts`).removeClass("d-none");
      },
      success: function (response) {
        if (response.status == true) {
          var all_tr_table = "";

          $.each(response.data, function (i) {
            var font_variants_option = `<option value="">${lang.select_a_font}</option>`;
            console.log(response.data[i].variants);
            $.each(response.data[i].variants, function (j) {
              font_variants_option += `
                                  <option value="${response.data[i].family}:${response.data[i].variants[j]}">
                                  ${response.data[i].family}:${response.data[i].variants[j]}
                                  </option>`;
            });
            all_tr_table += `
                              <tr>
                                  <td>${response.data[i].family}</td>
                                  <td>
                                      <div class="d-flex">
                                          <div class="p-1">
                                              <a target="_blank" href="https://fonts.google.com/?query=${response.data[i].family}">
                                              <span class="badge badge-dark">
                                                  ${lang.demo_font}
                                              </span>
                                              </a>
                                          </div>
                                          <div class="p-1">
                                              <select class="btn-font-select">
                                                  ${font_variants_option}
                                              </select>
                                          </div>
                                      </div>
                                  </td>
                              </tr>`;
          });
          var data_html_fonts = `
                      <div class="table-responsive">
                      <table class="table card-table">
                          <thead class="thead-dark">
                              <tr>
                              <th>${lang.font_name}</th>
                              <th>${lang.action}</th>
                              </tr>
                          </thead>
                          <tbody>
                              ${all_tr_table}
                          </tbody>
                      </table>
                      </div>`;

          $("#list_fonts").html(data_html_fonts);
        }
        $(`#spinner-loading-fonts`).addClass("d-none");
      },
    });
  });
  $(document).on("change", ".btn-font-select", function () {
    var family = this.value;
    if (family) {
      $("#font_currently").val(family);
      $("#font_currently_label").html(family);
      Swal.fire({
        position: "top-end",
        timer: 3000,
        toast: true,
        html: `<small><i class="fas fa-check-circle text-success"></i> ${lang.selected_font}: '<strong>${family}</strong>'</small>`,
        showConfirmButton: false,
      });
    }
  });
})();

// control name="type"
(function () {
  var fnCheck = function () {
    var value = $('[name="type"]:checked').val();
    if (value == "OFFLINE") {
      $(".address-wrapper").removeClass("hide");
    } else {
      $(".address-wrapper").addClass("hide");
    }
  };
  $('[name="type"]').on("change", function () {
    fnCheck();
  });
  fnCheck();
})();


// init editor
(function () {
  tinymce.init({
    selector: "textarea#description",
    height: "350px",
    plugins: "codesample fullscreen hr image imagetools link lists",
    toolbar:
      "styleselect | fullscreen | bold italic underline strikethrough forecolor backcolor | image link codesample hr | bullist numlist checklist",
    menubar: false,
    statusbar: false,
    file_picker_callback: function (callback, value, meta) {
      let x =
        window.innerWidth ||
        document.documentElement.clientWidth ||
        document.getElementsByTagName("body")[0].clientWidth;
      let y =
        window.innerHeight ||
        document.documentElement.clientHeight ||
        document.getElementsByTagName("body")[0].clientHeight;

      let type = "image" === meta.filetype ? "Images" : "Files",
        url = "/laravel-filemanager?editor=tinymce5&type=" + type;

      tinymce.activeEditor.windowManager.openUrl({
        url: url,
        title: "Filemanager",
        width: x * 0.8,
        height: y * 0.8,
        onMessage: (api, message) => {
          callback(message.content);
        },
      });
    },
  });
  tinymce.init({
    selector: "textarea#email_content",
    height: "250px",
    plugins: "codesample fullscreen hr image imagetools link lists",
    toolbar:
      "styleselect | fullscreen | bold italic underline strikethrough forecolor backcolor | image link codesample hr | bullist numlist checklist",
    menubar: false,
    statusbar: false,
    file_picker_callback: function (callback, value, meta) {
      let x =
        window.innerWidth ||
        document.documentElement.clientWidth ||
        document.getElementsByTagName("body")[0].clientWidth;
      let y =
        window.innerHeight ||
        document.documentElement.clientHeight ||
        document.getElementsByTagName("body")[0].clientHeight;

      let type = "image" === meta.filetype ? "Images" : "Files",
        url = "/laravel-filemanager?editor=tinymce5&type=" + type;

      tinymce.activeEditor.windowManager.openUrl({
        url: url,
        title: "Filemanager",
        width: x * 0.8,
        height: y * 0.8,
        onMessage: (api, message) => {
          callback(message.content);
        },
      });
    },
  });

  $("#theme_design_list").on("change", function () {
    $(".theme-screen-preview").addClass("d-none");
    $("#template_" + this.value).removeClass("d-none");
  });
})();

// background upload
(function () {
  var fnCheck = function () {
    var input = $('[name="background"]')[0];
    var url = $(input).val();
    var ext = url.substring(url.lastIndexOf(".") + 1).toLowerCase();
    if (
      input.files &&
      input.files[0] &&
      (ext == "gif" || ext == "png" || ext == "jpeg" || ext == "jpg")
    ) {
      var reader = new FileReader();
      reader.onload = function (e) {
        $(".preview-image").attr("src", e.target.result);
      };
      reader.readAsDataURL(input.files[0]);
    } else {
      $(".preview-image").attr(
        "src",
        "{{ ($event->background != null && $event->background != '') ? asset('storage/modules/events/' . $event->background) : asset('modules/events/img/no-image.png') }}"
      );
    }
  };
  $('[name="background"]').on("change", function () {
    fnCheck();
  });
  fnCheck();
})();

// control info inputs
(function () {
  var fnOnChangeDateType = function (element) {
    var text = "";
    var value = $(element).val();
    switch (value) {
      case "text":
      case "textarea":
        text = "";
        break;
      case "select":
        text = "@lang('Separate values by comma symbol')";
        break;
      default:
        text = "";
        break;
    }
    $(element).parents("tr").find(".help-text").html(text);
  };

  var fnAddItem = function (name, data_type, is_required, values) {
    var template = document.getElementById("info_template");
    var clone = template.content.cloneNode(true);

    if (name != undefined && name != null && name != "") {
      clone.querySelector('[name="info_items[name][]"]').value = name;
    }
    if (data_type != undefined && data_type != null && data_type != "") {
      clone.querySelector('[name="info_items[data_type][]"]').value = data_type;
    }
    if (is_required != undefined && is_required != null && name != "") {
      if (is_required == "1") {
        clone.querySelector(
          '[name="info_items[is_required][]"]'
        ).checked = true;
      } else {
        clone.querySelector(
          '[name="info_items[is_required][]"]'
        ).checked = false;
      }
    }
    if (values != undefined && values != null && values != "") {
      clone.querySelector('[name="info_items[values][]"]').value = values;
    }

    clone
      .querySelector('[name="info_items[data_type][]"]')
      .addEventListener("change", function () {
        fnOnChangeDateType(this);
      });
    fnOnChangeDateType(clone.querySelector('[name="info_items[data_type][]"]'));

    clone
      .querySelector(".btn-remove-item")
      .addEventListener("click", function () {
        this.closest("tr").remove();
      });

    document.getElementById("info_container").appendChild(clone);
  };

  // click button
  $("#info_add").on("click", function () {
    fnAddItem();
  });

  // init values
  var inits = event_infos_item;
  if (
    inits["name"] != undefined &&
    inits["name"] != null &&
    inits["name"] != "" &&
    inits["data_type"] != undefined &&
    inits["data_type"] != null &&
    inits["data_type"] != "" &&
    inits["is_required"] != undefined &&
    inits["is_required"] != null &&
    inits["is_required"] != ""
  ) {
    var len = inits["name"].length;
    for (var i = 0; i < len; i = i + 1) {
      fnAddItem(
        inits["name"][i],
        inits["data_type"][i],
        inits["is_required"][i],
        inits["values"][i]
      );
    }
  }
})();

// control ticket inputs
(function () {
  var fnAddItem = function (name, price, description) {
    var template = document.getElementById("ticket_template");
    var clone = template.content.cloneNode(true);
    if (name != undefined && name != null && name != "") {
      clone.querySelector('[name="ticket_items[name][]"]').value = name;
    }
    if (price != undefined && price != null && price != "") {
      clone.querySelector('[name="ticket_items[price][]"]').value = price;
    }
    if (description != undefined && description != null && description != "") {
      clone.querySelector('[name="ticket_items[description][]"]').value =
        description;
    }

    clone
      .querySelector(".btn-remove-item")
      .addEventListener("click", function () {
        this.closest("tr").remove();
      });

    document.getElementById("ticket_container").appendChild(clone);
  };
  $("#ticket_add").on("click", function () {
    fnAddItem();
  });
  var inits = event_ticket_item;
  if (
    inits["name"] != undefined &&
    inits["name"] != null &&
    inits["name"] != "" &&
    inits["price"] != undefined &&
    inits["price"] != null &&
    inits["price"] != "" &&
    inits["description"] != undefined &&
    inits["description"] != null &&
    inits["description"] != "" &&
    inits["name"].length == inits["price"].length &&
    inits["price"].length == inits["description"].length
  ) {
    var len = inits["name"].length;
    for (var i = 0; i < len; i = i + 1) {
      fnAddItem(inits["name"][i], inits["price"][i], inits["description"][i]);
    }
  }
})();

// submit form event
(function () {
  $("#form_create").on("submit", function () {
    $('[name="info_items[is_required][]"]').each(function (ele) {
      if (!$(this).is(":checked")) {
        $(this).prop("checked", true);
        $(this).val("0");
      }
    });
  });
})();


$(document).ready(function() {
  $("#register_end_date").datetimepicker({
    format: "YYYY-MM-DD HH:mm:ss"
  });
  $("#end_date").datetimepicker({
    format: "YYYY-MM-DD HH:mm:ss",
  });
  $("#start_date").datetimepicker({
    format: "YYYY-MM-DD HH:mm:ss",
  });
  $("#recur_end_date").datetimepicker({
    format: "YYYY-MM-DD HH:mm:ss",
  });

  recur_action();
  $("[name='is_recur']").change(function() {
    recur_action();
  });

  function recur_action() {
    let checked = $("[name='is_recur']").prop("checked");
    if (checked) {
      $("[name='is_recur']").val(1);
      $("[name='recur_day']").attr("disabled", false);
      $("[name='recur_week']").attr("disabled", false);
      $("[name='recur_end_date']").attr("disabled", false);
    } else {
      $("[name='is_recur']").val(0);
      $("[name='recur_day']").attr("disabled", true);
      $("[name='recur_week']").attr("disabled", true);
      $("[name='recur_end_date']").attr("disabled", true);
    }
  }
});
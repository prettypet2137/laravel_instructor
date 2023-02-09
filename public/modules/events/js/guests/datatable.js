$(function () {
    var table = $("#users-table").DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: datatable_url,
            data: function (d) {
                d.event_id = $('#users-table_filter select[name="event_id"]').val();
            },
        },
        columns: [
            {
                "className": "sub-guests-control",
                "orderable": false,
                "data": null,
                "defaultContent": "<i class='fa fa-chevron-down'></i>"
            },
            {data: "event_name", name: "event.name"},
            {data: "email", name: "email"},
            {data: "ticket", name: "ticket"},
            {data: "is_paid", name: "is_paid"},
            {data: "gateway", name: "gateway"},
            {data: "status", name: "status"},
            {data: "created_at", name: "created_at"},
            {data: "action", name: "action"},
        ],
        columnDefs: [{targets: "no-sort", orderable: false, searchable: false}],
    });

    $("#users-table tbody").on("click", 'td.sub-guests-control', function() {
        var tr = $(this).closest('tr');
        var row = table.row( tr );
        // if (row.data().sub_guests.length) {
            if ( row.child.isShown() ) {
                tr.find("i.fa-chevron-up").removeClass("fa-chevron-up").addClass("fa-chevron-down");
                row.child.hide();
            } else {
                tr.find("i.fa-chevron-down").removeClass("fa-chevron-down").addClass("fa-chevron-up");
                row.child( format(row.data()) ).show();
            }
        // }
    });

    function format(d) {
        let subTbl = `<table style="margin-left: auto; border-bottom: 1px solid #dddddd">`;
            for(guest of d.sub_guests) {
                subTbl += `
                    <tr>
                        <td>${guest.fullname}</td>
                        <td>${guest.email}<td>
                        <td>${guest.birthday}</td>
                        <td>${guest.phone}</td>
                    </tr>
                `
            }
            subTbl += `</table>`;
        return subTbl;
    }

    var filteruserhtml = ` <label>Event: <select name="event_id" class="form-control form-control-sm">`;
    filteruserhtml += `<option value="">All</option>`;
    filteruserhtml += event_options;
    filteruserhtml += `</select></label>`;

    $("#users-table_filter").append(filteruserhtml);

    $('#users-table_filter select[name="event_id"]').on("change", function () {
        table.draw();
        var val = $(this).find(':selected').data('eventName');
        if (val === undefined) {
            window.history.replaceState(null, null, location.pathname);
        } else {
            window.history.replaceState(null, null, "?event=" + val);
        }
    });

    $(document).on("click", ".btn-delete", function () {
        if (!confirm("Are you sure?")) return;

        var rowid = $(this).data("rowid");
        var el = $(this);
        if (!rowid) return;

        $.ajax({
            type: "POST",
            dataType: "JSON",
            url: guests_route + "/" + rowid,
            data: {_method: "post", _token: token},
            success: function (data) {
                var html = "";
                if (data.success)
                    html =
                        '<i class="fa fa-check-circle text-success"></i><small> ' +
                        data.message +
                        "</smal>";
                else
                    html =
                        '<i class="fa fa-times-circle text-error"></i><small> ' +
                        data.message +
                        "</smal>";
                Swal.fire({
                    position: "top-end",
                    timer: 3000,
                    toast: true,
                    html: html,
                    showConfirmButton: false,
                });
                $("#users-table").DataTable().ajax.reload();
            },
        }); //end ajax
    });

    // switch status
    $(document).on("click", ".switch-status", function () {
        var id = $(this).data("id");
        if (!id) return;

        var url = guests_switch_status_url;

        var parentEle = $(this).parent();
        var currentEle = $(this);

        $.ajax({
            type: "POST",
            dataType: "JSON",
            url: url.replace(":id", id),
            data: {
                _method: "post",
                _token: token,
            },
            success: function (data) {
                var html = "";
                if (data.success) {
                    currentEle.remove();
                    parentEle.append(data.html);

                    html =
                        '<i class="fa fa-check-circle text-success"></i><small> ' +
                        data.message +
                        "</smal>";
                } else {
                    html =
                        '<i class="fa fa-times-circle text-error"></i><small> ' +
                        data.message +
                        "</smal>";
                }
                Swal.fire({
                    position: "top-end",
                    timer: 3000,
                    toast: true,
                    html: html,
                    showConfirmButton: false,
                });
                // $('#users-table').DataTable().ajax.reload();
            },
        });
    });

    // switch paid
    $(document).on("click", ".switch-paid", function () {
        var id = $(this).data("id");
        if (!id) return;

        var url = guests_switch_paid_url;

        var parentEle = $(this).parent();
        var currentEle = $(this);

        $.ajax({
            type: "POST",
            dataType: "JSON",
            url: url.replace(":id", id),
            data: {
                _method: "post",
                _token: token,
            },
            success: function (data) {
                var html = "";
                if (data.success) {
                    currentEle.remove();
                    parentEle.append(data.html);

                    html =
                        '<i class="fa fa-check-circle text-success"></i><small> ' +
                        data.message +
                        "</smal>";
                } else {
                    html =
                        '<i class="fa fa-times-circle text-error"></i><small> ' +
                        data.message +
                        "</smal>";
                }
                Swal.fire({
                    position: "top-end",
                    timer: 3000,
                    toast: true,
                    html: html,
                    showConfirmButton: false,
                });
                // $('#users-table').DataTable().ajax.reload();
            },
        });
    });

    // detail guest click
    var lockDetailGuest = false;
    $(document).on("click", ".btn-detail", function () {
        var id = $(this).data("id");
        if (!id || lockDetailGuest) {
            return;
        }

        var url = guests_get_detail_url;

        $.ajax({
            type: "GET",
            dataType: "JSON",
            url: url.replace(":id", id),
            success: function (data) {
                var html = "";
                if (data.success) {
                    // process success
                    $(".data-guest-fullname").text(data.item.fullname);
                    $(".data-event-name").text(data.item.event.name);
                    $(".data-guest-email").text(data.item.email);
                    $(".data-guest-registered").text(
                        moment(data.item.created_at).format("YYYY-MM-DD HH:mm:ss")
                    );
                    if (data.item.joined_at) {
                        $(".data-guest-joined").text(
                            moment(data.item.joined_at).format("YYYY-MM-DD HH:mm:ss")
                        );
                    }
                    if (data.item.ticket_name && data.item.ticket_price) {
                        $(".data-guest-ticket").html(
                            data.item.ticket_name +
                            " - " +
                            data.item.ticket_price +
                            " " +
                            (data.item.ticket_currency ?? "") + " &times; " + (data.item.sub_guests.length + 1)
                        );
                    }
                    if (data.item.upsell_histories.length) {
                        var html = ""
                        for (var i = 0; i < data.item.upsell_histories.length; i++) {
                            html += `<p class="mb-1">${data.item.upsell_histories[i].upsell.title} - ${data.item.upsell_histories[i].price}USD</p>`;
                        }
                        $(".data-upsell").html(html);
                    }
                    if (data.item.info_items?.name) {
                        var len = data.item.info_items.name.length;
                        for (let i = 0; i < len; i = i + 1) {
                            $(".data-guest-info-items").append(
                                `<p><strong>${data.item.info_items.name[i]}</strong>: <span>${data.item.info_items.submit[i]}</span></p>`
                            );
                        }
                    }
                    $(".data-guest-status").html(data.item.status);
                    $(".data-qr-code").html(data.item.qr_code_image);
                    $(".confirm_ticket_btn").data("id", data.item.id)

                    $("#modalDetail").modal("show");
                } else {
                    html =
                        '<i class="fa fa-times-circle text-error"></i><small> ' +
                        data.message +
                        "</smal>";
                    $("#modalDetail").modal("hide");
                }
                Swal.fire({
                    position: "top-end",
                    timer: 3000,
                    toast: true,
                    html: html,
                    showConfirmButton: false,
                });
                // $('#users-table').DataTable().ajax.reload();
            },
            error: function () {
                $("#modalDetail").modal("hide");
            },
        });
    });
    
    $(".confirm_ticket_btn").click(function() {
        var id = $(this).data("id");
        $.ajax({
            type: "GET",
            url: BASE_URL + "/guests/confirm-ticket/" + id
        }).then(function(res) {
            if (res.success) {
                toastr.success("The confirmation ticket was sent to the guest successfully.", "Success!");
            }
        });
    });

    $("#modalDetail").on("hidden.bs.modal", function (e) {
        $(".data-guest-fullname").text("");
        $(".data-event-name").text("");
        $(".data-guest-email").text("");
        $(".data-guest-status").text("");
        $(".data-guest-registered").text("");
        $(".data-guest-joined").text("");
        $(".data-guest-ticket").text("");
        $(".data-guest-info-items").text("");
        $(".data-qr-code").text("");
    });

    var lockTransferGuest = false;
    $(document).on("click", ".btn-transfer", function () {
        var id = $(this).data("eventId");
        var guestId = $(this).data("guestId");
        if (!guestId || !id || lockTransferGuest) {
            return;
        }

        var eurl = guests_get_events_url;

        $.ajax({
            type: "GET",
            dataType: "JSON",
            url: eurl.replace(":eventId", id),
            success: function (data) {
                var html = "";
                if (data.success) {
                    // process success
                    var selectData = `<label for="event_id">Select event in which you want to transfer: <select id="event_id" name="event_id" class="form-control form-control-sm">`;
                    if (data.items.length) {
                        var len = data.items.length;
                        for (let i = 0; i < len; i = i + 1) {
                            selectData += `<option value="${data.items[i].id}">${data.items[i].name}</option>`;
                        }
                    } else {
                        selectData += `<option value="">Select...</option>`;
                    }
                    selectData += `</select></label>`;
                    selectData += `<input type="hidden" name="guest_id" value="${guestId}"/>`;
                    $(".select-div").append(selectData)

                    $("#modalTransfer").modal("show");
                } else {
                    html =
                        '<i class="fa fa-times-circle text-error"></i><small> ' +
                        data.message +
                        "</smal>";
                    $("#modalTransfer").modal("hide");
                }
                Swal.fire({
                    position: "top-end",
                    timer: 3000,
                    toast: true,
                    html: html,
                    showConfirmButton: false,
                });
                // $('#users-table').DataTable().ajax.reload();
            },
            error: function () {
                $("#modalTransfer").modal("hide");
            },
        });
    });

    $("#modalTransfer").on("hidden.bs.modal", function (e) {
        $(".select-div").text("")
        $(".event_id").empty();
    });
});

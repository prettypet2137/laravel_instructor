// click on btn-detail-panel event
(function () {
  $(".btn-detail-panel").on("click", function () {
    var target = $(this).data("target");
    if (target == undefined || target == null || target == "") {
      returnl;
    }
    target = $(target);
    if (target.length == 0) {
      return;
    }
    if (target.is(":visible")) {
      target.hide();
      $(this)
        .find("i.fas")
        .removeClass("fa-chevron-up")
        .addClass("fa-chevron-down");
    } else {
      target.show();
      $(this)
        .find("i.fas")
        .removeClass("fa-chevron-down")
        .addClass("fa-chevron-up");
    }
  });

  $('.form-delete').on('submit', function(){
    if(confirm("@lang('Delete this item ?')")){
        return true;
    }else{
        return false;
    }
});
})();

(function() {
  "use strict";
  
  $('.btn-show-content').on('click', function() {
    var id = $(this).data('id');
    $('#modal_'+id).modal();
  });
  
})();
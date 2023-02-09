(function($) {
	
  	"use strict"; // Start of use strict

	$("#btnUpdateVersion").on("click", function (e) {
	    e.preventDefault();
	    $(this).prop('disabled', true);
	    $(this).text('Waiting for update...');
	    $('form#formUpdateVersion').submit();
	});

	$("#btnInstallModuleModal").on("click", function (e) {
            e.preventDefault();
            $(this).prop('disabled', true);
            $(this).text('Watting for install...');
            $('form#installModuleForm').submit();
    });

	$(".btninstallModule").on("click", function (e) {
            e.preventDefault();
            var name = $(this).data('name');
            var path_main = $(this).data('pathmain');
            var product_id = $(this).data('productid');
            var verify_type = $(this).data('verifytype');
            var productname = $(this).data('productname');
            
            $('#installModuleTitle').html(name);
            $('#path_main').val(path_main);
            $('#product_id').val(product_id);
            $('#verify_type').val(verify_type);
            $('#product_name').val(productname);

      });
      

      $("#btnDeactiveModuleModal").on("click", function (e) {
            e.preventDefault();
            $(this).prop('disabled', true);
            $(this).text('Watting...');
            $('form#deactiveModuleForm').submit();
      });

})(jQuery); // End of use strict

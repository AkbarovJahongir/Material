(function () {
	"use strict";

	var treeviewMenu = $('.app-menu');

	// Toggle Sidebar
	$('[data-toggle="sidebar"]').click(function(event) {
		event.preventDefault();
		$('.app').toggleClass('sidenav-toggled');
		
		var isSet = 0;
		var classList = $('.app').attr('class').split(/\s+/);
		$.each(classList, function(index, item) {
			if (item === 'sidenav-toggled') {
				isSet++;
			}
		});
		//alert($(window).width()); 
		//751
		
		if($(window).width() >= 751){	
			$.ajax({
				url: "/main/menustick",
				type: "POST",
				data: {'sidenav_toggled': isSet},
				dataType: "text",
				success: function(resultData) {}
			});
		}
		
		
		if($("#opa_order").length){
			if(isSet != 0)
				var opa_width = $(window).width() / 4;
			else
				var opa_width = ($(window).width() / 4) - 62;
			//alert(opa_width);
            $('#korzina').width(opa_width);
        }
	});

	// Activate sidebar treeview toggle
	$("[data-toggle='treeview']").click(function(event) {
		event.preventDefault();
		if(!$(this).parent().hasClass('is-expanded')) {
			treeviewMenu.find("[data-toggle='treeview']").parent().removeClass('is-expanded');
		}
		$(this).parent().toggleClass('is-expanded');
	});

	// Set initial active toggle
	$("[data-toggle='treeview.'].is-expanded").parent().toggleClass('is-expanded');

	//Activate bootstrip tooltips
	$("[data-toggle='tooltip']").tooltip();

})();

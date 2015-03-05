
/**
 * Ratings.js
 * 
 */


(function() {

	"use strict";


	/* Tabs */

	var hash = document.location.hash;
	var prefix = "tab_";

	// Enable tabs
	$('.nav-tabs li a').click(function (e) {
		e.preventDefault();
		$(this).tab('show');
	});

	// Link to tabs on page load
	if (hash) {
		$('.nav-tabs a[href='+hash.replace(prefix,"")+']').tab('show');
	}

	// Change hash when tabs are changed
	$('.nav-tabs a').on('shown.bs.tab', function (e) {
		window.location.hash = e.target.hash.replace("#", "#" + prefix);
	});



	/* Comments */
	$('.report-item .comments h4').on("click", function(e){
		$(this).parent().toggleClass('open');
	});


	/* Print button */

	$('.print-btn').on("click", function(e) { 
		window.print();
	});

})();
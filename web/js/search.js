$(document).ready(function() {
		
		var searchBarText = "Recherche...";
		$("#searchBar").attr("value", searchBarText);
		
		$("#searchBar").focus(function() {
			$(this).addClass("active");
			if($(this).attr("value") == searchBarText) $(this).attr("value", "");
		});
		
		$("#searchBar").blur(function() {
			$(this).removeClass("active");
			if($(this).attr("value") == "") $(this).attr("value", searchBarText);
		});
	});
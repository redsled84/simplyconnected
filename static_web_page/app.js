function fadeElementsIn() {
	$("#aruba").fadeTo("slow", 1, function() {
		$("#start-text").fadeTo("slow", 1, function() {
			$("#cisco").fadeTo("slow", 1, function() {
				$("#end-text").fadeTo("slow", 1);
			});
		});
	});
	$("#start-text", 3000, "swing");
	$("#cisco", 4500, "swing");
	$("#end-text", 6000, "swing");
}

$(document).ready(function() {
	$(".links h2").hover(function() {
		$(".links h2").css("cursor", "pointer");
	});
	fadeElementsIn();
});
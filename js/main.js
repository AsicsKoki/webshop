//BUY BUTTONS
(function(){
	var buyBtn = $("#buyBtn");
	var buyInput = $("#buyInput");
	var	alert = $("#alert");

	buyBtn.click(function(){
		if (buyInput.val() > 10 || buyInput.val() == 0){
			$("#alert").modal();
		} else{
			$(this).text("Purchased");
			$(this).addClass("btn-danger");
			$(this).attr("disabled", "disabled");
		}
	});
}())

function toTitleCase(str)
{
	return str.replace(/\w\S*/g, function(txt){return txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase();});
}

//READ MORE BUTTON
jQuery(document).ready(function($) {
	$("div.columnLeft > footer").prepend("<button id=\"readMoreBtn\">Read more</button>");

	$("div.columnLeft > footer > button#readMoreBtn").on('click', function(){
		var btn = $(this);

		if (btn.text() == "Read more") {

			$("div.more").slideDown()
			btn.text("Read less");
		} else{
			$("div.more").slideUp();
			btn.text("Read more");
		}
	});

	$("button#next").on('click', function(){
		var img = $("div.columnRight > img:visible");
		img.hide();
		var imgNext = img.next();
		if (!imgNext.length) imgNext =  $("div.columnRight > img").first();
		imgNext.show();

	})
	$("button#previous").on('click', function(){
		var img = $("div.columnRight > img:visible");
		img.hide();
		var imgPrevious = img.prev();
		if (!imgPrevious.length) imgPrevious =  $("div.columnRight > img").last();
		imgPrevious.show();
	});

	//COLOR INPUT

	$("footer").on('click', 'select#menu > option', function(){
		$("div#boja").css("background-color",$(this).val());
	})
	$("div#boja").css("background-color",'blue');

	$("#ok").click(function(){
		var color = $("#colorInput").val();
		if ($("option[value="+color+"]").length == 0) {
			$("select#menu").append("<option value='"+color+"'>"+ toTitleCase(color) + "</option>");
		};

	});

	//RIGHT SIDE BANNER!
	var i = 0;
	var i2 = 0;
	

	setInterval(function() {
			if($("input#checkbox").is(':checked'))
			{
				i = i + 1;
				i = i % 4;
				$("img#banner").attr("src", banners[i])
			}
	}, 2000);

	//LEFT SIDE BANNER!
	setInterval(function() {
			if($("input#checkbox").is(':checked'))
			{
				i2 = i2 - 1;
				i2 = i2 % 4;
				$("img#banner2").attr("src", banners2[i2*-1])
			}
	}, 2000);
});
$(document).ready(function() {
    $('#productsTable').dataTable();
} );
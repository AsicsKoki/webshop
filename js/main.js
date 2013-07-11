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
});


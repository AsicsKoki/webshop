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

function toTitleCase(str) {
	return str.replace(/\w\S*/g, function(txt){return txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase();});
}
//READ MORE BUTTON

$("#readMore").click(function(){
	var self = $(this);
  $("#more").slideToggle(function(){
  	if(self.text() == "Read more"){
  		self.text("Read less");
  	} else {
  		self.text("Read more");
  	}
  });
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
if($('table').length) {
		$('#productsTable').dataTable();
		$('#usersTable').dataTable();
};


$('.delete').click(function(e){
	e.preventDefault();
	var id = $(this).data('id');
	var self = this;
	$.ajax({
		url: "productDelete.php",
		type: "get",
		data: {
			id: id
		},
		success: function(data){
			$(self).parents("tr").remove();
		}
	});
});

$('.deletePhoto').click(function(e){
	e.preventDefault();
	var id = $(this).data('id');
	var self = this;
	$.ajax({
		url: "fileDelete.php",
		type: "get",
		data: {
			id: id
		},
		success: function(data){
			if (data){
				$(self).parents("li").remove();
			}
		}
	});
});
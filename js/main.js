function toTitleCase(str) {
	return str.replace(/\w\S*/g, function(txt){return txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase();});
}
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
//AJAX DELETE BACK END
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
//AJAX DELETE COMMENT BACK END
$('.deleteComment').click(function(e){
	var id = $(this).data('id');
	var self = this;
	$.ajax({
		url: "commentDelete.php",
		type: "get",
		data: {
			id: id
		},
		success: function(data){
			if (data){
				$(self).parents("div.well").remove();
				$("div.comment_thumbnail").remove();
			}
		}
	});
});
//parsley initialization
$(document).ready(function() {
	if($('table').length) {
		$('#productsTable').dataTable();
		$('#usersTable').dataTable();
	}
	//COMMENT BOX(SUBMIT)
	$('input#post_comment').click(function(e){
		e.preventDefault();
		var valid = $("form#post_comment_form").parsley('validate');
		if (valid) {
		var text = $('textarea#comment').val();
		var id = $(this).data('id');
		var self = this;
		$.ajax({
			url: "comment.php",
			type: "POST",
			data: {
				id: id,
				text: text
			},
			success: function(data){
				if (data){
					var temp = $("script#comment_box_temp").html();
					temp = temp.replace('{{text}}',$('textarea#comment').val());
					$('div#comment_content').append(temp);
					}
				}
			});
		}
	});
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

	//COMMENT EDIT-BACKEND-TOGGLE
	$(".editComment").click(function(){
		$(this).parent().siblings(".editForm").slideToggle();
	})
	//COMMENT EDIT-BACKEND-REQUEST
		$('.update_comment').click(function(e){
		var text = $(this).siblings('textarea.comment_area').val();
		var id = $(this).data('id');
		var self = this
		$.ajax({
			url: "../commentUpdate.php",
			type: "POST",
			data: {
				id: id,
				text: text
			},
			success: function(data){
					$(".editForm").slideUp();
					$(self).parents('div.well').children("p").text(text);
			}
		});
	});
	//LIKE
	$('div.well.comment_padding').on('click', 'a.like', function(e){
		e.preventDefault();
		var userId = $(this).data('userid');
		var commentId = $(this).data('commentid');
		var self = this;
		$.ajax({
			url: "postLike.php",
			type: "POST",
			data: {
				userId: userId,
				commentId: commentId
			},
			success: function(data){
				$(self).text('Unlike').removeClass('like').addClass('unlike');
			}
		});
	})
	//UNLIKE
	$('div.well.comment_padding').on('click', 'a.unlike', function(e){
		e.preventDefault();
		var userId = $(this).data('userid');
		var commentId = $(this).data('commentid');
		var self = this;
		$.ajax({
			url: "unLike.php",
			type: "POST",
			data: {
				userId: userId,
				commentId: commentId
			},
			success: function(data){
				$(self).text('Like').removeClass('unlike').addClass('like');
			}
		});
	})
})
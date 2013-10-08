$(document).ready(function()
{
	window.setInterval(function() {
		$('.fleets').each(function() {
			var s		= $(this).data('fleet-time') - (serverTime.getTime() - startTime) / 1000;
			if(s <= 0) {
				$(this).text('-');
			} else {
				$(this).text(GetRestTimeFormat(s));
			}
		})
	}, 1000);
	
	window.setInterval(function() {
		$('.timer').each(function() {
			var s		= $(this).data('time') - (serverTime.getTime() - startTime) / 1000;
			if(s == 0) {
				window.location.href = "game.php?page=overview";
			} else {
				$(this).text(GetRestTimeFormat(s));
			}
		});
	}, 1000);
	
	window.setInterval(function(){
		$.post("game.php?page=shoutbox",
		{			
				ajaxpost: ""
		},
		function(data){
			$("#test").html(data);
		}
		);
	},10000);
	
	
$("#ajaxpostlink").click(function(){
	$.post("game.php?page=shoutbox",
		{
			ajaxnews: $("#msg").attr('value')
		},
		function(data){
			$("#test").html(data);
			$("#msg").val("");
		}
	);
});
});
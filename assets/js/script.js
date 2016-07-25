$(function() {

});

var myId;
var greened;
function bordercho(id) {
	/*if(myId == id) {
		if(greened) {
			$("#" + id).css({
				'padding': 'none',
				'border': 'none'
			});
			greened = false;
			document.getElementById('i'+id).checked = false;
			console.log(document.getElementById('i'+id));
		} else {
			$('#' + id).css({
				'border': '2px solid green',
				'padding': '2px'
			});
			greened = true;
		}
		return 0;
	}

	myId = id;*/

	$("#winner_div *").css({
		'padding': 'none',
		'border': 'none'
	});
	$('#' + id).css({
		'border': '2px solid green',
		'padding': '2px'
	});
	greened = true;
}
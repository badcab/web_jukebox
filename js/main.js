$(function(){
	$('#skip').on('click',function(){
		thinking_overlay();
		update_queue(true);
	});
	update_queue(true);
	window.setInterval(function(){update_queue(false)},3000);
});

function remove_overlay(){
   $('html').removeClass("loading");
}

function thinking_overlay(){
	$('.modal h1').html('Loading Next Vote');
	$('html').addClass("loading");
}

function go_dance_overlay(){
	$('.modal h1').html('Go Dance');
	$('html').addClass("loading");
}

function cast_vote(vote_for){
	thinking_overlay();
	$.ajax({
		url: 'rpc/cast_vote.php',
		type: 'POST',
		data: {vote_for: vote_for}
	}).done(function(){
		update_queue(true);
	}).fail(function() {
		console.log('cast_vote ajax error');
	})
	.always(function() {
		remove_overlay();
	});
}

function update_queue(advance_by_one){
	advance_by_one = (typeof advance_by_one === 'undefined') ? false : advance_by_one;
	advance_by_one = (advance_by_one) ? 1 : 0 ;
	$.ajax({
		url: 'rpc/update_queue.php',
		type: 'POST',
		data: { advance_by_one: advance_by_one},
	}).done(function(result){
		result = eval('(' + result + ')');//some websrv are dumb and don't get that this is json
		console.log(result);
		if(result.max_entropy){
			go_dance_overlay();
		} else if(result.update_list){
			thinking_overlay();
			$('.song1 div').html(result.song1);
			$('.song2 div').html(result.song2);
			$('.song3 div').html(result.song3);
			$('#vote1').html(result.vote1);
			$('#vote2').html(result.vote2);
			$('#vote3').html(result.vote3);
			remove_overlay();
		}
	}).error(function(){
		console.log('there was a problem');
	});
}

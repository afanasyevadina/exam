

	$('.subject').change(function() {
		$('.personal .ready').removeAttr('disabled');
	});

	$('#start').click(function(e){
		e.preventDefault();
		var subject;
		$('.subject').each(function(){
			if($(this).prop('checked')) {
				subject=$(this).val();
			}
		});
		$.ajax({
			url: '/test.php',
			method: 'POST',
			data: 'subject='+subject,
			dataType: 'html',
			success: function(response) {
				$('.personal').fadeOut();
				$('.test').html(response);
				setTimeout(function(){
					$('#finish').css('display', 'block');
					$('.test').fadeIn();
				},400);
			}
		});
		return false;
	});
	$('form').submit(function(e){
		e.preventDefault();
		$.ajax({
			url: $(this).attr('action'),
			dataType: 'html',
			method: $(this).attr('method'),
			data: $(this).serialize(),
			success: function(response) {
				var result=$.parseJSON(response);
				$('#message .balls').html(result.balls);
				$('#message .rating').html(result.rating);
				$('#message').css('display', 'block');
				$('.test input').each(function(){
					if($(this).val()==result.keys[$(this).attr('name')]) {
						$(this).parent().css('background-color', '#B6FFB4');
					} else if($(this).prop('checked')) {
						$(this).parent().css('background-color', '#FFC9C9');
					}
				});
				$(window).scrollTop(0);
				$('input[type=submit]').remove();
			}
		});
		return false;
	});
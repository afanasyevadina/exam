$.ajax({
			url: '/list.php',
			method: 'POST',
			data: 'lang='+$('.language').val(),
			dataType: 'html',
			success: function(response) {
				$('#list').html(response);
			}
		});


	var time;

	$('body').on('change', '.subject', function() {
		if($('.name').val()&&$('.surname').val()) {
			$('.personal .ready').removeAttr('disabled');
		}		
	});

	$('.personal input[type=text]').on('input', function() {
		if($('.name').val()&&$('.surname').val()&&$('.subject:checked').length) {
			$('.personal .ready').removeAttr('disabled');
		} else {
			$('.personal .ready').attr('disabled', 'disabled');
		}
	});

	$('.language').change(function(){
		$.ajax({
			url: '/list.php',
			method: 'POST',
			data: 'lang='+$(this).val(),
			dataType: 'html',
			success: function(response) {
				$('#list').html(response);
			}
		});
	})

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
				time=setInterval(Tik, 1000);
				setTimeout(function(){
					$('#finish').css('display', 'block');
					$('.timer').css('display', 'flex');
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

	function LeadZero(n) {
		return (n<10 ? '0' : '') + n;
	}

	function Tik() {
		var min=parseInt($('.min').html(), 10);
		var sec=parseInt($('.sec').html(), 10);
		if(!min&&!sec) {
			clearInterval(time);
			$('form').trigger('submit');
			return;
		}
		if(min&&!sec) {
			$('.min').html(LeadZero(--min));
			$('.sec').html('59');
		} else {
			$('.sec').html(LeadZero(--sec));
		}
	}
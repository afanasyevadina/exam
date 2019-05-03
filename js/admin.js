
	function Load(url, data, target) {
		$.ajax({
			url: url,
			method: 'POST',
			data: data,
			dataType: 'html',
			success: function(response) {
				target.html(response);
			}
		});
	}
	Load('/a_folder/getresults.php', 'school='+$('#school_select').val()+'&subject='+$('#subject_select').val(), $('.results tbody'));
	$('.download').attr('href', '/a_folder/download.php?school='+$('#school_select').val()+'&subject='+$('#subject_select').val());

	$('#results_btn').click(function() {
		$('.panel a').removeClass('active');
		$(this).addClass('active');
		$('.content>div').css('transform', 'translateX(0)');
	});
	$('#schools_btn').click(function() {
		$('.panel a').removeClass('active');
		$(this).addClass('active');
		$('.content>div').css('transform', 'translateX(-200%)');
	});
	$('#subjects_btn').click(function() {
		$('.panel a').removeClass('active');
		$(this).addClass('active');
		$('.content>div').css('transform', 'translateX(-100%)');
	});
	$('.filter select').change(function(){
		Load('/a_folder/getresults.php', 'school='+$('#school_select').val()+'&subject='+$('#subject_select').val(), $('.results tbody'));
		$('.download').attr('href', '/a_folder/download.php?school='+$('#school_select').val()+'&subject='+$('#subject_select').val());
	});

	$('.subjects').on('change', 'input[type=range]', function(){
		$(this).parent().find('span').html($(this).val());
	});

	$('.subjects').on('change', 'input[name=count]', function(){
		var max=$(this).val();
		$(this).parent().parent().find('input[type=range]').each(function(){
			$(this).attr('max', max);
		});
	});

	$('.subjects').on('click', '.minus', function(){
		var input=$(this).parent().find('input');
		var val=parseInt(input.val(),10);
		val--;
		if(parseInt(input.attr('min'),10)<=val) {
			input.val(val);
			$(this).parent().find('span').html(val);
		}
	});

	$('.subjects').on('click', '.plus', function(){
		var input=$(this).parent().find('input');
		var val=parseInt(input.val(),10);
		val++;
		if(parseInt(input.attr('max'),10)>=val) {
			input.val(val);
			$(this).parent().find('span').html(val);
		}
	});

	$('.add_subject').click(function(){
		$.ajax({
			url: '/a_folder/add_subject.php',
			data: '',
			dataType: 'html',
			method: 'POST',
			success: function(response) {
				$('.subjects').append(response);
				$(window).scrollTop($(document).height());
			}
		});
	});

	$('.subjects').on('click', '.delete', function() {
		var parent=$(this).parent().parent().parent();
		$.ajax({
			url: '/a_folder/del_subject.php',
			data: 'id='+$(this).data('id'),
			dataType: 'html',
			method: 'POST',
			success: function(response) {
				parent.remove();
			}
		});
	});
	$('.add_school').click(function(){
		$.ajax({
			url: '/a_folder/add_school.php',
			data: '',
			dataType: 'html',
			method: 'POST',
			success: function(response) {
				$('.schools').append(response);
				$(window).scrollTop($(document).height());
			}
		});
	});

	$('.schools').on('click', '.delete', function() {
		var parent=$(this).parent().parent().parent();
		$.ajax({
			url: '/a_folder/del_school.php',
			data: 'id='+$(this).data('id'),
			dataType: 'html',
			method: 'POST',
			success: function(response) {
				parent.remove();
			}
		});
	});

	$('.clear').click(function(){
		$.ajax({
			url: '/clear.php',
			data: '',
			method: 'POST',
			dataType: 'html',
			success: function(response) {
				Load('/a_folder/getresults.php', 'school='+$('#school_select').val()+'&subject='+$('#subject_select').val(), $('.results tbody'));
			}
		});
	});
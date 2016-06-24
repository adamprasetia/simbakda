$(document).ready(function(){
	function check_called(){
		if($('#called').is(":checked")){
			$('.box-program').removeClass('hide');
		}else{
			$('.box-program').addClass('hide');
		}			
	}
	check_called();
	$('#called').change(function(){
		check_called();
	});

	function check_program(){
		var radio = $('input[type=radio][name=program]:checked').val();
		if(radio==1){
			$('.box-minute').removeClass('hide');
			$('.box-program-tidak').addClass('hide');
		}else if(radio==2){
			$('.box-minute').addClass('hide');
			$('.box-program-tidak').removeClass('hide');
		}			
	}
	check_program();
	$('input[type=radio][name=program]').change(function(){
		check_program();
	});

	function check_minute(){
		var radio = $('input[type=radio][name=minute]:checked').val();
		if(radio==1){
			$('.box-smoker').removeClass('hide');
			$('.box-minute-tidak').addClass('hide');
		}else if(radio==2){
			$('.box-smoker').addClass('hide');
			$('.box-minute-tidak').removeClass('hide');
		}			
	}
	check_minute();
	$('input[type=radio][name=minute]').change(function(){
		check_minute();
	});

	function check_smoker(){
		var radio = $('input[type=radio][name=smoker]:checked').val();
		if(radio==1){
			$('.box-resign').removeClass('hide');
			$('.box-smoker-tidak').addClass('hide');
		}else if(radio==2){
			$('.box-resign').addClass('hide');
			$('.box-smoker-tidak').removeClass('hide');
		}			
	}
	check_smoker();
	$('input[type=radio][name=smoker]').change(function(){
		check_smoker();
	});

	function check_resign(){
		var radio = $('input[type=radio][name=resign]:checked').val();
		if(radio==1){
			$('.question').removeClass('hide');
			$('.box-resign-tidak').addClass('hide');
		}else if(radio==2){
			$('.question').addClass('hide');
			$('.box-resign-tidak').removeClass('hide');
		}			
	}
	check_resign();
	$('input[type=radio][name=resign]').change(function(){
		check_resign();
	});

	function check_sim(){
		var radio = $('input[type=radio][name=sim]:checked').val();
		if(radio==1){
			$('.box-sim-ya').removeClass('hide');
		}else if(radio==2){
			$('.box-sim-ya').addClass('hide');
		}			
	}
	check_sim();
	$('input[type=radio][name=sim]').change(function(){
		check_sim();
	});

	function check_motor(){
		var radio = $('input[type=radio][name=motor]:checked').val();
		if(radio==1){
			$('.box-motor-ya').removeClass('hide');
		}else if(radio==2){
			$('.box-motor-ya').addClass('hide');
		}			
	}
	check_motor();
	$('input[type=radio][name=motor]').change(function(){
		check_motor();
	});
	
	function check_sick(){
		var radio = $('input[type=radio][name=sick]:checked').val();
		if(radio==1){
			$('.box-sick-ya').removeClass('hide');
		}else if(radio==2){
			$('.box-sick-ya').addClass('hide');
		}			
	}
	check_sick();
	$('input[type=radio][name=sick]').change(function(){
		check_sick();
	});
	
	function check_passport(){
		var radio = $('input[type=radio][name=passport]:checked').val();
		if(radio==1){
			$('.box-passport-ya').removeClass('hide');
		}else if(radio==2){
			$('.box-passport-ya').addClass('hide');
		}			
	}
	check_passport();
	$('input[type=radio][name=passport]').change(function(){
		check_passport();
	});
	
	function check_campaign(){
		var radio = $('input[type=radio][name=campaign]:checked').val();
		if(radio==1){
			$('.box-campaign-ya').removeClass('hide');
		}else if(radio==2){
			$('.box-campaign-ya').addClass('hide');
		}			
	}
	check_campaign();
	$('input[type=radio][name=campaign]').change(function(){
		check_campaign();
	});

	function check_campaign_same(){
		var radio = $('input[type=radio][name=campaign_same]:checked').val();
		if(radio==1){
			$('.box-campaign-same-ya').removeClass('hide');
		}else if(radio==2){
			$('.box-campaign-same-ya').addClass('hide');
		}			
	}
	check_campaign_same();
	$('input[type=radio][name=campaign_same]').change(function(){
		check_campaign_same();
	});
});
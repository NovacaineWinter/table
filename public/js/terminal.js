


$(document).ready(completeJS);
$(document).ajaxComplete(completeJS);


//this is where ALL the js goes - it ensure the listeners are refreshed each time an ajax request returns
function completeJS(){
//	$(document).off();
	//set positions etc
    setElementPositions();
    $(window).resize(setElementPositions);

    timer();



    $('#modal').draggable({revert: true});
    $('#modalPopover').draggable({revert: true});


    var searchTimeout;
    $('#seachBox').on('keyup',function() {

    	if(searchTimeout){
    		clearTimeout(searchTimeout);
    	}

    	searchTimeout = setTimeout(function() {
    		
    		$.ajax({
				url: url('/search'),
				method: 'GET',
				data:{
					target: $(this).attr('target'),
					term: $('#seachBox').val(),
				},

				success: function(response) {

					$('#memberSearchResults').html(response);	

				},
				error: function(response) {
				    console.log('There was an error - it was:');
				    console.dir(response);
				}
			}); 
    	},400);
    });    


    $('.openModal').off().click(function(e) {    
    	e.stopPropagation();

		$.ajax({
			url: url('/ajax'),
			method: 'GET',
			data:{
				target: $(this).attr('target'),
				method: $(this).attr('method'),
			},
			success: function(response) {

				if(response.success){
					openModal(response.data); 
				}else{
					openModal(response.message);
				}

			                             

			},
			error: function(response) {
			    console.log('There was an error - it was:');
			    console.dir(response);
			}
		}); 
    });






    $('.userOnTable').off().click(function() {
		if($(this).attr('targetTable') && $(this).attr('targetUser')){
			targetTable = $(this).attr('targetTable');
			$.ajax({
				url: url('/ajax'),
				method: 'GET',
				data:{
					targetTable: targetTable,
					targetUser: $(this).attr('targetUser'),
					method: $(this).attr('method'),
				},
				success: function(response) {

					if(response.success){
						openModal(response.data); 
						//$('#tableRow'+targetTable).html(response.row);
						$('#appContent').html(response.home);
					}else{
						openModal(response.message);
					}
                         

				},
				error: function(response) {
				    console.log('There was an error - it was:');
				    console.dir(response);
				}
			}); 

    	}
    });





    $('.tableAction').off().click(function() {

    	if($(this).attr('target') && $(this).attr('method')){
			targetTable = $(this).attr('target');

			$.ajax({
				url: url('/ajax'),
				method: 'GET',
				data:{
					targetTable: targetTable,					
					method: $(this).attr('method'),
				},
				success: function(response) {

					if(response.success){

						//$('#tableRow'+targetTable).html(response.row);
						$('#appContent').html(response.home);


						if(response.popover){							
							//fill the popover with content and show
							if(response.closeModal){
								popoverOnly(response.popoverContent);
							}else{
								openPopover(response.popoverContent);
							}
								

						}else{

							if(response.closeModal){
								closeModal();
							}else{
								openModal(response.data);							
							}

						}

					}else{
						//error - print the message to the modal
						openModal(response.message);
					}
				                              

				},
				error: function(response) {
				    console.log('There was an error - it was:');
				    console.dir(response);
				}
			}); 

    	}
    });






    $('.errorInAddingUserToTable').off().click(function() {


    	if($(this).attr('targetTable') && $(this).attr('targetUser')){

			$.ajax({
				url: url('/ajax'),
				method: 'GET',
				data:{
					targetTable: $(this).attr('targetTable'),
					targetUser: $(this).attr('targetUser'),
					method: 'errorInAddingUserToTable',
				},
				success: function(response) {

					if(response.success){
						openPopover(response.data); 
					}else{
						openPopover(response.message);
					}
                       

				},
				error: function(response) {
				    console.log('There was an error - it was:');
				    console.dir(response);
				}
			}); 

    	}
    });


    $('#closeModalButton').off().click(function() {
		closeModal()
    });
    $('#blankout').off().click(function(e) {
    	e.stopPropagation();
		closeModal();
		closePopover();
    });




    $('#modalBlankout').off().click(function(e) {
    	e.stopPropagation();
    	closePopover();
    });


	$('.userThumb').off().click(function() {
		$('#enlargedProfilePic'+$(this).attr('target')).show(300);
	});

	$('.userPicEnlarged').off().click(function(e) {
		e.stopPropagation();
		$('.userPicEnlarged').hide(300);
	});

}//<-----
/* =================================================================================================================================*/
/* ====================================       End of CompleteJS()     ==============================================================*/
/* =================================================================================================================================*/


function timer(){
    var ticker = setInterval(function() {
		$('.timeElapsed').each(function() {

			ts = Math.round((new Date()).getTime() / 1000);
			elapsed = ts - parseInt($(this).attr('data-timeStart'));

			if($(this).attr('data-cancellimit')){
				if(elapsed >= $(this).attr('data-cancellimit')){
					$('#'+$(this).attr('data-cancelButton')).hide();
				}
			}

			target = $(this).attr('data-target');
			$('#timerForTable'+target).html(secondsToStopwatch(elapsed));
			interval = document.head.querySelector("[property=chargeableinterval]").content;
			pricePerInterval = $(this).attr('data-baserate')/(3600/interval);
			intervalsElapsed = Math.floor(elapsed/interval);
			cost = pricePerInterval * intervalsElapsed;
			$('#costIncurredForTable'+target).html('&pound;'+((Math.floor(cost))/100).toFixed(2));

		});
    },500);
}



function setElementPositions(){	

	/* Set up margins in order to vertically center things in their parent elements */
    $('.centervertically').each(function() {
    	parentPadding = parseInt($(this).parent().css('padding-top').substr(0,$(this).parent().css('padding-top').length - 2));
    	parentMargin = parseInt($(this).parent().css('margin-top').substr(0,$(this).parent().css('padding-top').length - 2));
        size=(($(this).parent().height() - $(this).height())/2)-parentMargin;
        $(this).css('padding-top',size-parentPadding);
        $(this).css('padding-bottom',size); 
    });                 
}  



function secondsToStopwatch(seconds){
	hours= Math.floor(seconds/3600);
	mins = Math.floor((seconds/60)%60);
	seconds = seconds%60;

	if(hours > 0){
		str = hours+":"+pad(mins)+":"+pad(seconds); 
	}else{
		str = pad(mins)+":"+pad(seconds); 
	}
	return str;
}


function pad(num) {
    var s = num+"";
    while (s.length < 2) s = "0" + s;
    return s;
}


function url(uri){

    cleanURI = (uri[0] == '/') ? uri.substr(1) : uri;

    return document.head.querySelector("[property=siteurl]").content+'/'+cleanURI;
}



function openPopover(content){
	$('#modalBlankout').removeClass('hidden');
	$('#modalPopover').html(content);
	$('#modalPopover').removeClass('hidden');	
	return true;
}


function closeModal(){
	$('#modal').addClass('hidden'); 
	$('#blankout').addClass('hidden'); 
	return true;
}

function openModal(content){
	$('#modal').html(content);
	$('#modal').removeClass('hidden');
	$('#blankout').removeClass('hidden');
	return true;
}

function closePopover(){
	$('#modalBlankout').addClass('hidden');    	
	$('#modalPopover').addClass('hidden');   
	return true;
}

function popoverOnly(content){
	openPopover(content);
	closeModal();

	return true;
}
$(function(){
	var menuStatus;

	// Show menu
	$("a.showMenu").click(function(){
		if(menuStatus != true){				
			$(".ui-page-active").animate({
				marginLeft: "165px",
			}, 300, function(){menuStatus = true});
			return false;
		} else {
			$(".ui-page-active").animate({
				marginLeft: "0px",
			}, 300, function(){menuStatus = false});
			return false;
		}
	});
	
	
	$('#menu, .pages').on("swipeleft", function(){
		if (menuStatus){	
			$(".ui-page-active").animate({
				marginLeft: "0px",
			}, 300, function(){menuStatus = false});
		}
	});
	
	$('.pages').on("swiperight", function(){
		if (!menuStatus){	
			$(".ui-page-active").animate({
				marginLeft: "165px",
			}, 300, function(){menuStatus = true});
		}
	});
	
	$('div[data-role="page"]').on('pagebeforeshow',function(event, ui){
		menuStatus = false;
		$(".pages").css("margin-left","0");
	});
	
	// Menu behaviour
	$("#menu li a").click(function(){
		var p = $(this).parent();
		if($(p).hasClass('active')){
			$("#menu li").removeClass('active');
		} else {
			$("#menu li").removeClass('active');
			$(p).addClass('active');
		}
	});

	// Tabs 
	$('div[data-role="navbar"] a').on('click', function () {
		$(this).addClass('ui-btn-active');
		$('div.content_div').hide();
		$('div#' + $(this).attr('data-href')).show();
	});

});

$(document).ready(function(){

	$('.ui-input-clear').click(function(){
		$('#ExerciseInputs').html('');
		$('#autocomplete').html('');
		$('#add-exercise').val('');
		$('#add-exercise').attr('placeholder', 'Add Activity...');
		$('.ui-input-clear').hide();
	});

	$('.progress-container').click(function(){
		document.location = '/members/progress/'+$(this).data("link");
	});

	$('.workout-btns').click(function(){
		inputField = '<input type="hidden" value="'+this.innerHTML+'" id="workout-type-selected" />';
		$('.workout-type').html('<h1>Selected '+this.innerHTML+'</h1>'+inputField);
	});

	$('.main-template-btn').click(function(){

		_params = {
			template:$(this).data("template")
		}

		$.ajax({                    
		    url:'/members/templatesRender',
		    type:"POST",                                        
		    data:_params,
		    success: function(data) {
      			$('.selected-template-content').html(data);
		    }
		});
	});

	$('#getting').click(function(){
		alert('asdfads');
	});

	// $('#addRow').click(function(){
	// 	alert('asdfads');
	// 	// var html = "";
		
	// 	// var n = $('.emotm-row').length;
	// 	// alert(n);

	// 	// html += '<div class="emotm-row" data-row="'+n+'">';
	// 	// 	html += '<div class="template-details cols-4">';
	// 	// 		html += '<div class="attribute-label">EVERY (time)</div>';
	// 	// 		html += '<div class="attribute-input"><input type="text" value="" placeholder="#" id="sets" /></div>';
	// 	// 	html += '</div>';
	// 	// 	html += '<div class="template-details cols-4">';
	// 	// 		html += '<div class="attribute-label">REPS</div>';
	// 	// 		html += '<div class="attribute-input"><input type="text" value="" placeholder="#" id="reps" /></div>';
	// 	// 	html += '</div>';
	// 	// 	html += '<div class="template-details cols-4">';
	// 	// 		html += '<div class="attribute-label">WEIGHT</div>';
	// 	// 		html += '<div class="attribute-input"><input type="text" value="" placeholder="#" id="weight" /></div>';
	// 	// 	html += '</div>';
	// 	// 	html += '<div class="template-details cols-4">';
	// 	// 		html += '<div class="attribute-label">NUMBER OF SETS</div>';
	// 	// 		html += '<div class="attribute-input"><input type="text" value="" placeholder="#" id="reps" /></div>';
	// 	// 	html += '</div>';
	// 	// 	html += '<div class="clear"></div>';
	// 	// html += '</div>';

	// 	// $('.emotm-container').append(html);

	// });

	$('.exercise-type-selected').click(function(){
		inputField = '<input type="hidden" value="'+this.innerHTML+'" id="exercise-type-selected" />';

		if($('#workout-type-selected').val() == 'Multiple Movements')
			$('.selected-exercise-type-content').append('<div class="main-exercise">'+this.innerHTML+inputField+'</div>');
		else
			$('.selected-exercise-type-content').html('<div class="main-exercise">'+this.innerHTML+inputField+'</div>');
	});


	$( "#add-exercise" ).keyup(function() 
	{
		$('.ui-input-clear').show();

		var _params = {
			keyword:this.value
	    }

	    $.ajax({
	        url: "/exercises/find_all", // url to send data to
	        type: "POST", // parse data as type
	        data: _params, // data object to parse
	        dataType: "json", // return type
	        success: function(data) {
	          $('#autocomplete').html(data);
	        }, // callback function
	        error: function() {

	        },
	        async: true
	    });
	});

	$('#mygym').keyup(function()
	{

		$('.mygym-list').show();
		var _params = {
			keyword:this.value
	    }

	    $.ajax({
	        url: "/affiliates/find_all", // url to send data to
	        type: "POST", // parse data as type
	        data: _params, // data object to parse
	        dataType: "json", // return type
	        success: function(data) {
	          $('.mygym-list').html(data);
	        }, // callback function
	        error: function() {

	        },
	        async: true
	    });
	});

	$(".activity").on('click', function() 
	{
		alert(this.id);
		// var _params = {
		// 	keyword:this.value
	 //    }
	    
	 //    $.ajax({
	 //        url: "/exercises/find_all", // url to send data to
	 //        type: "POST", // parse data as type
	 //        data: _params, // data object to parse
	 //        dataType: "json", // return type
	 //        success: function(data) {
	 //          $('#autocomplete').html(data);
	 //        }, // callback function
	 //        error: function() {

	 //        },
	 //        async: true
	 //    });
	});


});

function addMemberGym(id, name)
{
	$('#affiliate_id').val(id);
	$('#mygym').attr('placeholder', name);
	$('#mygym').val(name);
	$('.mygym-list').hide();
	$('.mygym-list').html('');
}

function loadExercise(name, id)
{

	$('#add-exercise').val('');
	$('#add-exercise').attr('placeholder', name);

	var _params = {
		exercise_id:id
    }

    $.ajax({
        url: "/exercises/load_exercise_date", // url to send data to
        type: "POST", // parse data as type
        data: _params, // data object to parse
        dataType: "json", // return type
        success: function(data) {
          $('#autocomplete').html('');
          $('#ExerciseInputs').html(data);
        }, // callback function
        error: function() {

        },
        async: true
    });
}

function getConversionValues(cat)
{
	var intRegex = /^(?:[1-9]\d*|0)?(?:\.\d+)?$/;
	var imperialvalue = 0;
	var metricvalue = 0;   
	if(cat == 'weight') 
	{
		if($('#metric_weight_input').val() != '') {
			if(intRegex.test($('#metric_weight_input').val())) {
				imperialvalue = $('#metric_weight_input').val() * 2.20;
				$('#imperial_weight').val(imperialvalue.toFixed(2) + 'lbs');
			} else {
				alert('Please make sure that you\'ve entered a valid value');
				return false;
			}
		}
		if($('#imperial_weight_input').val() != '') {
			if(intRegex.test($('#imperial_weight_input').val())) {
				metricvalue = $('#imperial_weight_input').val() * 0.45;
				$('#metric_weight').val(metricvalue.toFixed(2) + 'kg'); 
			} else {
				alert('Please make sure that you\'ve entered a valid value');
				return false;
			}
		}
		if($('#metric_weight_pood').val() != '') {
			if(intRegex.test($('#metric_weight_pood').val())) {
				metricvalue = $('#metric_weight_pood').val() * 16.38;
				$('#metric_weight_pood_answer').val(metricvalue.toFixed(2) + 'kg');
			}else{
				alert('Please make sure that you\'ve entered a valid value');
				return false;
			}
		}
		if($('#imperial_weight_pood').val() != '') {
			if(intRegex.test($('#imperial_weight_pood').val())) {
				metricvalue = $('#imperial_weight_pood').val() * 36.11;
				$('#imperial_weight_pood_answer').val(metricvalue.toFixed(2) + 'lbs');
			}else{
				alert('Please make sure that you\'ve entered a valid value');
				return false;
			}
		}
		if($('#metric_weight_kg').val() != '') {
			if(intRegex.test($('#metric_weight_kg').val())) {
				metricvalue = $('#metric_weight_kg').val() * 0.061;
				$('#metric_weight_kg_answer').val(metricvalue.toFixed(2) + 'pood');
			}else{
				alert('Please make sure that you\'ve entered a valid value');
				return false;
			}
		}
		if($('#imperial_weight_lbs').val() != '') {
			if(intRegex.test($('#imperial_weight_lbs').val())) {
				metricvalue = $('#imperial_weight_lbs').val() * 0.02769;
				$('#imperial_weight_lbs_answer').val(metricvalue.toFixed(2) + 'pood');
			}else{
				alert('Please make sure that you\'ve entered a valid value');
				return false;
			}
		}
	} 
	else if(cat == 'height') 
	{
		if($('#metric_height_input').val() != '') {
			if(intRegex.test($('#metric_height_input').val())) {
				imperialvalue = $('#metric_height_input').val() * 0.39;
				$('#imperial_height').val(imperialvalue.toFixed(2) + 'in');
			} else {
				alert('Please make sure that you\'ve entered a valid value');
				return false;
			}
		}
		if($('#imperial_height_input').val() != '') {
			if(intRegex.test($('#imperial_height_input').val())) {
				metricvalue = $('#imperial_height_input').val() * 2.54;
				$('#metric_height').val(metricvalue.toFixed(2) + 'cm'); 
			} else {
				alert('Please make sure that you\'ve entered a valid value');
				return false;
			}
		}        
	} 
	else if(cat == 'distance') 
	{
		if($('#metric_distance_input').val() != '') {
			if(intRegex.test($('#metric_distance_input').val())) {
				imperialvalue = $('#metric_distance_input').val() * 0.62;
				$('#imperial_distance').val(imperialvalue.toFixed(2) + 'mi');
			} else {
				alert('Please make sure that you\'ve entered a valid value');
				return false;
			}
		}
		if($('#imperial_distance_input').val() != '') {
			if(intRegex.test($('#imperial_distance_input').val())) {
				metricvalue = $('#imperial_distance_input').val() * 1.61;
				$('#metric_distance').val(metricvalue.toFixed(2) + 'km'); 
			} else {
				alert('Please make sure that you\'ve entered a valid value');
				return false;
			}
		}            
	} 
	else if(cat == 'volume') 
	{
		var metricvolume = document.getElementById("imperial_volume_input").value * 33.81;
		var imperialvolume = document.getElementById("metric_volume_input").value * 0.03;
		$('#metric_volume').val(metricvolume.toFixed(2) + 'litres'); 
		$('#imperial_volume').val(imperialvolume.toFixed(2) + 'Oz');
	}
}

function getSystem(val)
{
	var thisheight = document.getElementById("height").value;
	var thisweight = document.getElementById("weight").value;

	if (val == 'Metric') {
		var newheight = thisheight * 2.54;
		var newweight = thisweight * 0.45;
		document.getElementById("heightlabel").innerHTML = 'Height(cm)';
		document.getElementById("height").value = newheight.toFixed(2);
		document.getElementById("weightlabel").innerHTML = 'Weight(kg)';
		document.getElementById("weight").value = newweight.toFixed(2);
	}
	else if (val == 'Imperial') {
		var newheight = thisheight * 0.39;
		var newweight = thisweight * 2.20;
		document.getElementById("heightlabel").innerHTML = 'Height(inches)';
		document.getElementById("height").value = newheight.toFixed(2);
		document.getElementById("weightlabel").innerHTML = 'Weight(lbs)';
		document.getElementById("weight").value = newweight.toFixed(2);
	}
}

function profilesubmit()
{
	$.getJSON('/members/profile/?update=1', $("#profileform").serialize(), messagedisplay);
}

function messagedisplay(message)
{
	if (message == 'Success') {
		alert("Successfully saved");
		window.location = 'index.php?module=memberhome&message=1';
	} else {
		alert(message);
		$.getJSON('ajax.php?module=profile', $("#profileform").serialize(), display);
	}
}


function AddActivity()
{
	submit = false;
	counter = 0;

	var exercise_array = [];

	$('.exercise_details').each(function(){
		if(this.type == 'text')
		{
			if(this.value != '')
			{
				str = this.id;
				str = str.split("_");

				var attr = {};

				name = 'exercise_'+str[2]+'_name';
				attribute_name = 'attribute_'+str[2]+'_name';
				attribute_id = 'attribute_'+str[2]+'_id';
				attribute_value = 'attribute_value_'+str[2];

				name_value = $("#exercise_"+str[2]+"_name").val();
				attribute_name_value = $("#attribute_"+str[2]+"_name").val();
				attribute_id_value = $("#attribute_"+str[2]+"_id").val();
				attribute_value_content = $("#attribute_value_"+str[2]).val();

				attr[name] = name_value;
				attr[attribute_name] = attribute_name_value;
				attr[attribute_id] = attribute_id_value;
				attr[attribute_value] = attribute_value_content;

				exercise_array.push(attr);

				submit = true;
			}
		}
	});

	if(submit)
	{
		if( !$.trim( $('.routines').html() ).length ) {
			html = '<div class="routine routine_1">';
				html += '<div id="1_Benchmark" class="RoutineList RoutineBox">';
					html += '<div class="RoutineLabel" id="Routine1Round">';
						html += '<h2>';
							html += '<div class="RoutineText">Routine 1</div>';
							html += '<div class="RoutineDeleteButton" style="float:right" id="1deletebenchmark">';
								html += '<span class="dd ui-btn ui-btn-up-c ui-shadow ui-btn-corner-all ui-btn-icon-notext" data-icon="delete" data-role="button" data-iconpos="notext" onclick="RemoveRoutine(1);" data-corners="true" data-shadow="true" data-iconshadow="true" data-wrapperels="span" data-theme="c" title=""><span class="ui-btn-inner"><span class="ui-btn-text"></span><span class="ui-icon ui-icon-delete ui-icon-shadow">&nbsp;</span></span></span>';
							html += '</div>';
							html += '<div class="clear"></div>';
						html += '</h2>';
					html += '</div>';
					html += '<div class="RoundLabel round round_1" id="Routine1Round1Label">';
						html += '<h3 class="GenericRoundText">Round 1</h3>';
						html += '<div class="deleteround">';
							html += '<span class="dd ui-btn ui-btn-up-c ui-shadow ui-btn-corner-all ui-btn-icon-notext" data-icon="delete" data-role="button" data-iconpos="notext" onclick="RemoveRound(1,1);" data-corners="true" data-shadow="true" data-iconshadow="true" data-wrapperels="span" data-theme="c" title=""><span class="ui-btn-inner"><span class="ui-btn-text"></span><span class="ui-icon ui-icon-delete ui-icon-shadow">&nbsp;</span></span></span>';
						html += '</div>';
						html += '<div class="clear"></div>';
						html += '<div id="activity1list" class="ActivityList">';
							html += returnExerciseData(exercise_array, 1, 1);
						html += '</div>';
					html += '</div>';
					html += '<div class="clear"></div>';
				html += '</div>';
			html += '</div>';

			$('.routines').html(html);
		}
		else
		{
			var routineItems = $('.routine').length;
			var roundItems = $('.routine_'+routineItems+' .round').length;
			
			html = returnExerciseData(exercise_array, routineItems, roundItems);
			$('.routine_'+routineItems+' .round_'+roundItems+' .ActivityList').append(html);
			
		}

		$('#ExerciseInputs').html('');
		$('#autocomplete').html('');
		$('#add-exercise').val('');
		$('#add-exercise').attr('placeholder', 'Add Activity...');
		$('.ui-input-clear').hide();
	}
	else
	{
		alert('Please make sure you have entered at least one attribute value');
	}

}

function returnExerciseData(data, routine, round)
{
	content = '';
	counter = 0;

	$.each(data, function(index, val) 
	{
		console.log(val);

		name = 'exercise_'+counter+'_name';

		name = val[name];

		content_name = "attribute_"+counter+"_name";
		content_id = "attribute_"+counter+"_id";
		content_value = "attribute_value_"+counter;

		if(val[content_name] != null && val[content_value] != null)
		{
		    content += '<div class="AttributeGroupLabel" id="" data-name="'+val[content_name]+'">';
				content += '<span>'+val[content_name]+'</span>';
				content += '<span class="ActivityValueHtml" id="" data-value="'+val[content_value]+'">'+val[content_value]+'</span>';
				content += '<span class="uom_space">kg</span>';
				content += '<input type="hidden" value="'+val[content_name]+'_'+val[content_value]+'_'+routine+'_'+round+'" name="attr_'+counter+'_'+routine+'_'+round+'" id="" />';
				content += '<div class="clear"></div>';
			content += '</div>';
			content += '<span class="divider-line">/</span>';
			counter += 1;
		}
	});

	html = '<div class="activityitem">';
		html += '<div>';
			html += '<h2>';
				html += name+'<br>';
				html += '<input type="hidden" name="exercise_name_'+routine+'_'+round+'" value="'+name+'_'+routine+'_'+round+'" />';
				
				html += content;
				html += '<div class="clear"></div>';
			html += '</h2>';
			html += '<div style="display:none;">';
				html += '<div class="ActivityAttributes">';
					
				html += '</div>';
				html += '<div class="clear"></div>';
			html += '</div>';
		html += '</div>';
	html += '</div>';

	return html;
}

function AddRound()
{
	var num_of_routines = $('.routine').length;
	var num_of_rounds = $('.routine_'+num_of_routines+' .round').length + 1;

	html = '<div id="Routine1Round1Label" class="RoundLabel round round_'+num_of_rounds+'">';
		html += '<h3 class="GenericRoundText">Round '+num_of_rounds+'</h3>';
		html += '<div class="deleteround">';
			html += '<span title="" data-theme="c" data-wrapperels="span" data-iconshadow="true" data-shadow="true" data-corners="true" onclick="RemoveRound('+num_of_routines+','+num_of_rounds+');" data-iconpos="notext" data-role="button" data-icon="delete" class="dd ui-btn ui-btn-up-c ui-shadow ui-btn-corner-all ui-btn-icon-notext">';
				html += '<span class="ui-btn-inner">';
					html += '<span class="ui-btn-text"></span>';
					html += '<span class="ui-icon ui-icon-delete ui-icon-shadow">&nbsp;</span>';
				html += '</span>';
			html += '</span>';
		html += '</div>';
		html += '<div class="clear"></div>';
		html += '<div id="activity1list" class="ActivityList"></div>';
	html += '</div>';

	$('.routine_'+num_of_routines+' .RoutineList').append(html);
}

function RemoveRoutine(id)
{
	$(".routine_"+id).remove();
}

function RemoveRound(routine, round)
{
	field = ".routine_"+routine+" .RoutineList .round_"+round;
	//alert($(field).html());
	$(field).remove();
}

function updateSubscription(value)
{
	$('#subscription_total_value').html("R " + number_format(parseInt(value)));
	$('#subscription_amount').val(number_format(parseInt(value)));

	var subscription, subscription_months;

	switch (parseInt(value)) {
	    case 50:
	        subscription = "1 Month Subscription";
	        subscription_months = 1;
	        break;
	    case 300:
	        subscription = "6 Months Subscription";
	        subscription_months = 6;
	        break;
	    case 600:
	        subscription = "12 Months Subscription";
	        subscription_months = 12;
	        break;
	}

	$('#subscription_name').val(subscription);
	$('#subscription_period').val(subscription_months);

}

function number_format(n) 
{
    return n.toFixed(2).replace(/./g, function(c, i, a) {
        return i > 0 && c !== "." && (a.length - i) % 3 === 0 ? "," + c : c;
    });
}

function processSubscription()
{
	var form = document.getElementById('paymentForm');

	if(parseInt($('#subscription_package').val()) != 0 && $('#subscription_package').val() != '--')
		form.submit();
	else
		alert('Please make sure you have selected a Membership package.');
}

function deleteAttribute(id)
{
	var _params = {
		attribute_id:id
    }

    $.ajax({
        url: "/exercises/delete_exercise_attribute", // url to send data to
        type: "POST", // parse data as type
        data: _params, // data object to parse
        dataType: "json", // return type
        success: function(data) {
          if(data['success'] == 'true')
          {
          	$( "#attribute-item-box-"+id ).remove();
          	$('.attribute-list').hide();
          	alert('Attribute has been removed');
          }
          else
          	alert('Oh no, something went wrong when we tried to remove the attribute. Please try again later');
        }, // callback function
        error: function() {

        },
        async: true
    });
}
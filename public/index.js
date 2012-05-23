//FORM FIELDS VARIATION//

var default_name = 'name...';
var default_d = 'deadline...';
var default_w = 'weight...';
	
function formVariation()
{	
	$(".input_name_reset")
		.focus(function () {
		  $(this).removeClass("input_name_reset").addClass("input_name").val('');
		})					
		.blur(function(){
			if($(this).val() == '') { $(this).removeClass("input_name").addClass("input_name_reset").val(default_name); }
		});
	
	$(".input_d_reset")
		.focus(function () {
		  $(this).removeClass("input_d_reset").addClass("input_d").val('');
		})					
		.blur(function(){
			if($(this).val() == '') { $(this).removeClass("input_d").addClass("input_d_reset").val(default_d); }
		});
		
	$(".input_w_reset")
		.focus(function () {
		  $(this).removeClass("input_w_reset").addClass("input_w").val('');
		})					
		.blur(function(){
			if($(this).val() == '') { $(this).removeClass("input_w").addClass("input_w_reset").val(default_w); }
		});
}
//~FORM FIELDS VARIATION//

//ADD-SUB MORE TASKS//

var index = 3;
function addTask()
{
	var field_html = '\n                <tr class="hidden task_heading" id="task_heading_'+index+'">\n                    <td class="task_heading"><br /><span class="task_heading">Task '+index+'</span></td>\n                <tr class="hidden" id="task_fields_'+index+'">\n                    <td><input class="input_name_reset" name="name'+index+'" type="text" value="name..." size="20" /></td>\n                    <td><input class="input_d_reset" name="d'+index+'" type="text" value="deadline..." size="20" /></td>\n                    <td><input class="input_w_reset" name="w'+index+'" type="text" value="weight..." size="20" /></td>\n                </tr>';
				
	$('#form_fields').append(field_html);
	
	$("#task_heading_"+index).show('fast');
	$("#task_fields_"+index).show('fast');
	
	formVariation();
	index++;
}

function subTask()
{
	if(index == 1)
		return;
		
	index--;
	
	$("#task_heading_"+index).hide('slow');
	$("#task_fields_"+index).hide('slow');
	
	$("#task_heading_"+index).remove();
	$("#task_fields_"+index).remove();
//	$("#task_heading_3").remove();
//	$("#task_fields_3").remove();
}

function defineButtons()
{
	$("#add_task")
		.click(function () {addTask();});
	$("#sub_task")
		.click(function () {subTask();});
}
//~ADD-SUB MORE TASKS//

//HANDLING ON SUBMIT

function fill_data()
{
	//i=1;
	//alert($('input[name="name'+i+'"]').val());
	
	var names_v = '';
	var d_v = '';
	var w_v = '';
	
	var errors = 'Errors Encountered :\n';
	ret = true;
	i = 1;
	while(i<index)
	{
		if($('input[name="name'+i+'"]').val() != default_name && $('input[name="name'+i+'"]').val() != '')
			names_v = names_v+$('input[name="name'+i+'"]').val()+',';
		else
		{
			errors = errors+"Task "+i+" has Name field empty\n";
			ret = false;
		}
		
		if($('input[name="d'+i+'"]').val() != default_d && $('input[name="d'+i+'"]').val() != '')
			d_v = d_v+$('input[name="d'+i+'"]').val()+',';
		else
		{
			errors = errors+"Task "+i+" has Deadline field empty\n";
			ret = false;
		}
		
		if($('input[name="w'+i+'"]').val() != default_w && $('input[name="w'+i+'"]').val() != '')
			w_v = w_v+$('input[name="w'+i+'"]').val()+',';
		else
		{
			errors = errors+"Task "+i+" has Weight field empty\n";
			ret = false;
		}
			
		i++;
	}
	
	names_v = names_v.substr(0, names_v.length-1);
	d_v = d_v.substring(0, d_v.length - 1);
	w_v = w_v.substring(0, w_v.length - 1);
	
	$("#names").val(names_v);
	$("#ds").val(d_v);
	$("#ws").val(w_v);	

	
	if(ret == false)
	   alert(errors);
	
	return ret;
}

$("#form_post_submit").submit(function() {
	return  fill_data();
  //return isValidated();
});

//~HANDLING ON SUBMIT
//MAIN//
defineButtons();
formVariation();
//~MAIN//
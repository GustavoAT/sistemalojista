<?php
echo form_open('services/save/'.$service_info->service_id,array('id'=>'service_form'));
?>
<div id="required_fields_message"><?php echo $this->lang->line('common_fields_required_message'); ?></div>
<ul id="error_message_box"></ul>
<fieldset id="service_basic_info">
<legend><?php echo $this->lang->line("services_basic_information"); ?></legend>
<div class="field_row clearfix">	
<?php echo form_label($this->lang->line('common_first_name').':', 'name',array('class'=>'required')); ?>
	<div class='form_field'>
	<?php echo form_input(array(
		'name'=>'name',
		'id'=>'name',
		'value'=>$service_info->name)
	);?>
	</div>
</div>
<div class="field_row clearfix">	
<?php echo form_label($this->lang->line('service_cost').':', 'service_cost'); ?>
	<div class='form_field'>
	<?php echo form_input(array(
		'name'=>'lservice_cost',
		'id'=>'service_cost',
		'value'=>$service_info->service_cost)
	);?>
	</div>
</div>

<div class="field_row clearfix">	
<?php echo form_label($this->lang->line('services_comment').':', 'comment'); ?>
	<div class='form_field'>
	<?php echo form_textarea(array(
		'name'=>'comment',
		'value'=>$service_info->comment,
		'rows'=>'4','cols'=>'23', 'id'=>'comment'));
	?>
	</div>
</div>
<?php
echo form_submit(array(
	'name'=>'submit',
	'id'=>'submit',
	'value'=>$this->lang->line('common_submit'),
	'class'=>'submit_button float_right')
);
?>
</fieldset>
<?php 
echo form_close();
?>
<script type='text/javascript'>

//validation and submit handling
$(document).ready(function()
{
	$('#service_form').validate({
		submitHandler:function(form)
		{
			$(form).ajaxSubmit({
			success:function(response)
			{
				tb_remove();
				post_service_form_submit(response);
			},
			dataType:'json'
		});

		},
		errorLabelContainer: "#error_message_box",
 		wrapper: "li",
		rules: 
		{
			name: "required",
			service_cost:{
				number:true
			}
   		},
		messages: 
		{
     		name: "<?php echo $this->lang->line('common_first_name_required'); ?>",
     		number: "<?php echo $this->lang->line('services_cost_number'); ?>"
		}
	});
});
</script>
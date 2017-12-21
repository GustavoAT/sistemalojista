<?php
class Secure_area extends CI_Controller 
{
	/*
	Controllers that are considered secure extend Secure_area, optionally a $module_id can
	be set to also check if a user can access a particular module in the system.
	*/
	function __construct($module_id=null)
	{
		parent::__construct();	
		$this->load->model('employee');
		if(!$this->employee->is_logged_in())
		{
			redirect('login');
		}
		
		if(!$this->employee->has_permission($module_id,$this->employee->get_logged_in_employee_info()->person_id))
		{
			redirect('no_access/'.$module_id);
		}
		
		//load up global data
		$logged_in_employee_info=$this->employee->get_logged_in_employee_info();
		$data['allowed_modules']=$this->module->get_allowed_modules($logged_in_employee_info->person_id);
		$data['user_info']=$logged_in_employee_info;
		$this->load->vars($data);
	}
}
?>
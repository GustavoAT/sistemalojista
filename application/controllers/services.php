<?php
require_once ("secure_area.php");
require_once ("interfaces/idata_controller.php");
class Services extends Secure_area implements iData_controller
{
	function __construct()
	{
		parent::__construct('services');
	}

	function index()
	{
		$config['base_url'] = site_url('/services/index');
		$config['total_rows'] = $this->service->count_all();
		$config['per_page'] = '20';
		$config['uri_segment'] = 3;
		$this->pagination->initialize($config);
		
		$data['controller_name']=strtolower(get_class());
		$data['form_width']=$this->get_form_width();
		$data['manage_table']=get_service_manage_table( $this->service->get_all( $config['per_page'], $this->uri->segment( $config['uri_segment'] ) ), $this );
		$this->load->view('services/manage',$data);
	}
	
	/*
	Returns service table data rows. This will be called with AJAX.
	*/
	function search()
	{
		$search=$this->input->post('search');
		$data_rows=get_service_manage_table_data_rows($this->service->search($search),$this);
		echo $data_rows;
	}
	
	/*
	Gives search suggestions based on what is being searched for
	*/
	function suggest()
	{
		$suggestions = $this->service->get_search_suggestions($this->input->post('q'),$this->input->post('limit'));
		echo implode("\n",$suggestions);
	}
	
	/*
	Loads the service edit form
	*/
	function view($service_id=-1)
	{
		$data['service_info']=$this->service->get_info($service_id);
		$this->load->view("services/form",$data);
	}
	
	/*
	Inserts/updates a service
	*/
	function save($service_id=-1)
	{
		$service_data = array(
		'name'=>$this->input->post('name'),
		'service_cost'=>$this->input->post('service_cost'),
		'comment'=>$this->input->post('comment'),
		);
		
		if($this->service->save($service_data,$service_id))
		{
			//New service
			if($service_id==-1)
			{
				echo json_encode(array('success'=>true,'message'=>$this->lang->line('services_successful_adding').' '.
				$service_data['name'],'servicetype_id'=>$service_data['servicetype_id']));
			}
			else //previous service
			{
				echo json_encode(array('success'=>true,'message'=>$this->lang->line('services_successful_updating').' '.
				$service_data['name'],'servicetype_id'=>$servicetype_id));
			}
		}
		else//failure
		{	
			echo json_encode(array('success'=>false,'message'=>$this->lang->line('services_error_adding_updating').' '.
			$service_data['name'],'servicetype_id'=>-1));
		}
	}
	
	/*
	This deletes services from the services table
	*/
	function delete()
	{
		$services_to_delete=$this->input->post('ids');
		
		if($this->service->delete_list($services_to_delete))
		{
			echo json_encode(array('success'=>true,'message'=>$this->lang->line('services_successful_deleted').' '.
			count($services_to_delete).' '.$this->lang->line('services_one_or_multiple')));
		}
		else
		{
			echo json_encode(array('success'=>false,'message'=>$this->lang->line('services_cannot_be_deleted')));
		}
	}
	
	function excel()
	{
		$data = file_get_contents("import_services.csv");
		$name = 'import_services.csv';
		force_download($name, $data);
	}
	
	function excel_import()
	{
		$this->load->view("services/excel_import", null);
	}

	function do_excel_import()
	{
		$msg = 'do_excel_import';
		$failCodes = array();
		if ($_FILES['file_path']['error']!=UPLOAD_ERR_OK)
		{
			$msg = $this->lang->line('items_excel_import_failed');
			echo json_encode( array('success'=>false,'message'=>$msg) );
			return;
		}
		else
		{
			if (($handle = fopen($_FILES['file_path']['tmp_name'], "r")) !== FALSE)
			{
				//Skip first row
				fgetcsv($handle);
				
				$i=1;
				while (($data = fgetcsv($handle)) !== FALSE) 
				{
					$service_data = array(
					'servicetype_id'=>$data[0],
					'name'=>$data[1],
					'service_cost'=>$data[2],
					'comment'=>$data[3]
					);
					
					if(!$this->service->save($service_data,$service_data))
					{	
						$failCodes[] = $i;
					}
					
					$i++;
				}
			}
			else 
			{
				echo json_encode( array('success'=>false,'message'=>'Your upload file has no data or not in supported format.') );
				return;
			}
		}

		$success = true;
		if(count($failCodes) > 1)
		{
			$msg = "Most services imported. But some were not, here is list of their CODE (" .count($failCodes) ."): ".implode(", ", $failCodes);
			$success = false;
		}
		else
		{
			$msg = "Import services successful";
		}

		echo json_encode( array('success'=>$success,'message'=>$msg) );
	}
	
	function get_row()
	{
		$service_id = $this->input->post('row_id');
		$data_row=get_service_data_row($this->service->get_info($service_id),$this);
		echo $data_row;
	}
	/*
	get the width for the add/edit form
	*/
	function get_form_width()
	{			
		return 350;
	}
}
?>
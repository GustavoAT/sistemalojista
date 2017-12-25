<?php
class Service extends CI_Model
{	
	/*
	Determines if a given servicetype_id is a service
	*/
	function exists($servicetype_id)
	{
		$this->db->from('servicetype');	
		$this->db->where('servicetype_id',$servicetype_id);
		$query = $this->db->get();
		
		return ($query->num_rows()==1);
	}
	
	/*
	Returns all the servicetype
	*/
	function get_all($limit=10000, $offset=0)
	{
		$this->db->from('servicetype');		
		$this->db->where('servicetype_id >',0);
		$this->db->order_by("name", "asc");
		$this->db->limit($limit);
		$this->db->offset($offset);
		return $this->db->get();		
	}
	
	function count_all()
	{
		$this->db->from('servicetype');
		$this->db->where('servicetype_id >',0);
		return $this->db->count_all_results();
	}
	
	/*
	Gets information about a particular service
	*/
	function get_info($servicetype_id)
	{
		$this->db->from('servicetype');	
		$this->db->where('servicetype_id',$servicetype_id);
		$query = $this->db->get();
		
		if($query->num_rows()==1)
		{
			return $query->row();
		}
		else
		{
			//Get empty base parent object, as $servicetype_id is NOT an service
			$service_obj=parent::get_info(-1);
			
			//Get all the fields from service table
			$fields = $this->db->list_fields('servicetype');
			
			//append those fields to base parent object, we we have a complete empty object
			foreach ($fields as $field)
			{
				$service_obj->$field='';
			}
			
			return $service_obj;
		}
	}
	
	/*
	Gets information about multiple servicetype
	*/
	function get_multiple_info($servicetype_ids)
	{
		$this->db->from('servicetype');		
		$this->db->where_in('servicetype_id',$servicetype_ids);
		$this->db->order_by("name", "asc");
		return $this->db->get();		
	}
	
	/*
	Inserts or updates a service
	*/
	function save(&$service_data,$servicetype_id=false)
	{
		$success=false;
		//Run these queries as a transaction, we want to make sure we do all or nothing
		$this->db->trans_start();
		
		if(parent::save($service_data,$servicetype_id))
		{
			if (!$servicetype_id or !$this->exists($servicetype_id))
			{
				$service_data['servicetype_id'] = $service_data['servicetype_id'];
				$success = $this->db->insert('servicetype',$service_data);				
			}
			else
			{
				$this->db->where('servicetype_id', $servicetype_id);
				$success = $this->db->update('servicetype',$service_data);
			}
			
		}
		
		$this->db->trans_complete();		
		return $success;
	}
	
	/*
	Deletes one service
	*/
	function delete($servicetype_id)
	{
		$this->db->where('servicetype_id', $servicetype_id);
		return $this->db->delete('servicetype');
	}
	
	/*
	Deletes a list of servicetype
	*/
	function delete_list($servicetype_ids)
	{
		$this->db->where_in('servicetype_id',$servicetype_ids);
		return $this->db->delete('servicetype');
 	}
 	
 	/*
	Get search suggestions to find servicetype
	*/
	function get_search_suggestions($search,$limit=25)
	{
		$suggestions = array();
		
		$this->db->from('servicetype');
		$this->db->where("name LIKE '%".$this->db->escape_like_str($search)."%'");
		$this->db->order_by("name", "asc");		
		$by_name = $this->db->get();
		foreach($by_name->result() as $row)
		{
			$suggestions[]=$row->name;		
		}
		
		$this->db->from('servicetype');
		$this->db->where('servicetype_id >',0);	
		$this->db->like("comment",$search);
		$this->db->order_by("comment", "asc");		
		$by_comment = $this->db->get();
		foreach($by_comment->result() as $row)
		{
			$suggestions[]=$row->comment;		
		}

		
		//only return $limit suggestions
		if(count($suggestions > $limit))
		{
			$suggestions = array_slice($suggestions, 0,$limit);
		}
		return $suggestions;
	
	}
	
	/*
	Get search suggestions to find servicetype
	*/
	function get_service_search_suggestions($search,$limit=25)
	{
		$suggestions = array();
		
		$this->db->from('servicetype');
		$this->db->where("name LIKE '%".$this->db->escape_like_str($search)."%'");
		$this->db->order_by("name", "asc");		
		$by_name = $this->db->get();
		foreach($by_name->result() as $row)
		{
			$suggestions[]=$row->name;		
		}
		
		$this->db->from('servicetype');
		$this->db->where('servicetype_id >',0);	
		$this->db->like("comment",$search);
		$this->db->order_by("comment", "asc");		
		$by_comment = $this->db->get();
		foreach($by_comment->result() as $row)
		{
			$suggestions[]=$row->comment;		
		}

		//only return $limit suggestions
		if(count($suggestions > $limit))
		{
			$suggestions = array_slice($suggestions, 0,$limit);
		}
		return $suggestions;

	}
	/*
	Preform a search on servicetype
	*/
	function search($search)
	{
		$this->db->from('servicetype');		
		$this->db->where("name LIKE '%".$this->db->escape_like_str($search)."%' or 
		comment LIKE '%".$this->db->escape_like_str($search)."%'");		
		$this->db->order_by("name", "asc");
		
		return $this->db->get();	
	}

}
?>

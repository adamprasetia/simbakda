<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class General_model extends CI_Model {
	function get_from_field($table_name,$field,$value){
		$this->db->where($field,$value);
		return $this->db->get($table_name);	
	}			
	function get_from_field_row($table_name,$field,$value){
		$this->db->where($field,$value);
		$this->db->limit(1);
		if($this->db->get($table_name)->num_rows() > 0){
			return $this->db->get($table_name)->row();		
		}
		return false;	
	}				
	function dropdown($tbl_name,$caption,$where = array()){
		foreach ($where as $key => $value) {
			$this->db->where($key,$value);
		}
		$result = $this->db->get($tbl_name)->result();
		$data[''] = '- '.$caption.' -';
		foreach($result as $r){
			$data[$r->code] = $r->code.' - '.$r->name;
		}
		return $data;
	}					
}
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class General_model extends CI_Model 
{
	function get_from_field($table_name,$field,$value)
	{
		$this->db->where($field,$value);
		return $this->db->get($table_name);	
	}			
	function get_from_field_row($table_name,$field,$value)
	{
		$this->db->where($field,$value);
		$this->db->limit(1);
		$result = $this->db->get($table_name);
		if($result->num_rows() > 0){
			return $result->row();		
		}
		return false;	
	}				
	function dropdown($tbl_name,$caption,$where = array())
	{
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
	function double_check($tabel,$field,$value,$id=false)
	{
		$this->db->where($field,$value);
		$this->db->from($tabel);
		$row = $this->db->get();
		if ($row->num_rows() > 0 && $row->row()->id!=$id) {
			return true;
		}
		return false;
	}	
	function add($table,$data)
	{
		$this->db->insert($table,$data);
		return $this->db->insert_id();
	}
	function add_batch($table,$data){
		$this->db->insert_batch($table,$data);
	}

	function edit($table,$id,$data)
	{
		$this->db->where('id',$id);
		$this->db->update($table,$data);
	}
	function delete($table,$id)
	{
		$this->db->where('id',$id);
		$this->db->delete($table);
	}
	function delete_from_field($table,$field,$id)
	{
		$this->db->where($field,$id);
		$this->db->delete($table);
	}
	function query($table,$field,$detail=false){
		$select = array();
		$select[] = $table.'.*';
		if ($detail) {
			$select[] = 'count('.$table.'_detail.id) as jumlah,sum('.$table.'_detail.jumlah*'.$table.'_detail.harga) as total';			
			$data[] = $this->db->join($table.'_detail',$table.'.id='.$table.'_detail.id_parent','left');
			$data[] = $this->db->group_by($table.'.id');
		}
		foreach ($field as $row) {
			if ($row['type']=='dropdown' || $row['type']=='dropdown_ajax') {
				$select[] = $row['id'].'.name as '.$row['id'].'_name';
			}
		}
		$data[] = $this->db->select($select);
		$data[] = $this->db->from($table);
		foreach ($field as $row) {
			if ($row['type']=='dropdown' || $row['type']=='dropdown_ajax') {
				$data[] = $this->db->join($row['id'],$table.'.'.$row['id'].' = '.$row['id'].'.code','left');
			}
		}
		foreach ($field as $row) {
			if ($row['filter']) {
				if ($row['type']=='dropdown') {
					if($this->input->get($row['id']) <> ''){
						$data[] = $this->db->where($table.'.'.$row['id'],$this->input->get($row['id']));
					}					
				}elseif ($row['type']=='date') {
					if($this->input->get($row['id'].'_from') <> '' && $this->input->get($row['id'].'_to') <> ''){
						$date_from = $this->input->get($row['id'].'_from');
						$date_to = $this->input->get($row['id'].'_to');
						$data[] = $this->db->where($table.'.'.$row['id'].' >=',format_ymd($date_from));
						$data[] = $this->db->where($table.'.'.$row['id'].' <=',format_ymd($date_to));						
					}					
				}else{
					if($this->input->get($row['id']) <> ''){
						$data[] = $this->db->where($table.'.'.$row['id'].' like "%'.$this->input->get($row['id']).'%"');
					}					
				}
			}
		}
		$data[] = $this->db->order_by($this->general->get_order_column($table.'.id'),$this->general->get_order_type('desc'));
		$data[] = $this->db->offset($this->general->get_offset());
		return $data;		
	}
	public function get($table,$field,$detail=false)
	{
		$this->query($table,$field,$detail);
		$this->db->limit($this->general->get_limit());
		return $this->db->get();
	}
	public function get_detail($table,$field,$detail=false,$filter_column,$filter_value)
	{
		$this->query($table,$field,$detail);
		$this->db->where($filter_column,$filter_value);						
		return $this->db->get();
	}
	public function count_all($table,$field,$detail=false)
	{
		$this->query($table,$field,$detail);
		return $this->db->get()->num_rows();
	}

}
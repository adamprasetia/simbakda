<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Inherit_model extends CI_Model 
{

	public function query($tbl_name,$tbl_name_parent,$code)
	{
		$select[] = 'a.*';
		$data[] = $this->db->from($tbl_name.' a');
		$data[] = $this->db->where('a.type',$code);
		if ($tbl_name_parent) {
			$select[] = 'b.name as '.$tbl_name_parent.'_name';
			$data[] = $this->db->join($tbl_name_parent.' b','a.parent = b.code','left');			
		}
		$data[] = $this->db->select($select);
		$data[] = $this->search();
		if($this->input->get($tbl_name_parent) <> '')
			$data[] = $this->db->where('a.parent',$this->input->get($tbl_name_parent));
		$data[] = $this->db->order_by($this->general->get_order_column('a.code'),$this->general->get_order_type('asc'));
		$data[] = $this->db->offset($this->general->get_offset());
		return $data;
	}
	public function get($tbl_name,$tbl_name_parent,$code)
	{
		$this->query($tbl_name,$tbl_name_parent,$code);
		$this->db->limit($this->general->get_limit());
		return $this->db->get();
	}
	public function count_all($tbl_name,$tbl_name_parent,$code)
	{
		$this->query($tbl_name,$tbl_name_parent,$code);
		return $this->db->get()->num_rows();
	}
	public function search()
	{
		$result = $this->input->get('search');
		if($result <> ''){
			return $this->db->where('(a.code like "%'.$result.'%" OR a.name like "%'.$result.'%")');
		}		
	}
}
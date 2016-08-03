<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model extends CI_Model 
{
	private $tbl_name = 'barang';
	private $tbl_name_parent = 'barang_sub_kelompok';
	private $tbl_key 	= 'id';

	public function query()
	{
		$data[] = $this->db->select(array(
			'a.*',
			'b.name as '.$this->tbl_name_parent.'_name'
		));
		$data[] = $this->db->from('barang a');
		$data[] = $this->db->where('a.type','05');
		$data[] = $this->db->join('barang b','a.parent = b.code','left');
		$data[] = $this->search();
		if($this->input->get($this->tbl_name_parent) <> '')
			$data[] = $this->db->where('a.parent',$this->input->get($this->tbl_name_parent));
		$data[] = $this->db->order_by($this->general->get_order_column('a.code'),$this->general->get_order_type('asc'));
		$data[] = $this->db->offset($this->general->get_offset());
		return $data;
	}
	public function get()
	{
		$this->query();
		$this->db->limit($this->general->get_limit());
		return $this->db->get();
	}
	public function add($data)
	{
		$this->db->insert($this->tbl_name,$data);
	}
	public function edit($id,$data)
	{
		$this->db->where($this->tbl_key,$id);
		$this->db->update($this->tbl_name,$data);
	}
	public function delete($id)
	{
		$this->db->where($this->tbl_key,$id);
		$this->db->delete($this->tbl_name);
	}
	public function get_from_field($field,$value)
	{
		$this->db->where($field,$value);
		return $this->db->get($this->tbl_name);	
	}
	public function count_all()
	{
		$this->query();
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
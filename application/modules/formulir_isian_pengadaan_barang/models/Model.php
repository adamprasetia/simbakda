<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model extends CI_Model 
{
	private $tbl_name = 'formulir_isian_pengadaan_barang';
	private $tbl_key 	= 'id';

	public function query()
	{
		$data[] = $this->db->select('a.*,count(b.id) as jumlah,sum(b.jumlah*b.harga) as total,c.name as tahun_anggaran_name,d.name as bidang_unit_name');
		$data[] = $this->db->from($this->tbl_name.' a');
		$data[] = $this->db->join($this->tbl_name.'_detail b','a.id=b.id_parent','left');
		$data[] = $this->db->join('tahun_anggaran c','a.tahun_anggaran=c.code','left');
		$data[] = $this->db->join('bidang d','a.bidang_unit=d.code','left');
		$data[] = $this->search();
		$date_from = $this->input->get('date_from');
		$date_to = $this->input->get('date_to');
		if($date_from <> '' && $date_to <> ''){
			$data[] = $this->db->where('a.tanggal >=',format_ymd($date_from));
			$data[] = $this->db->where('a.tanggal <=',format_ymd($date_to));
		}		
		$tahun_anggaran = $this->input->get('tahun_anggaran');
		if($tahun_anggaran <> ''){
			$data[] = $this->db->where('a.tahun_anggaran',$tahun_anggaran);
		}		
		$bidang_unit = $this->input->get('bidang_unit');
		if($bidang_unit <> ''){
			$data[] = $this->db->where('a.bidang_unit',$bidang_unit);
		}		
		$data[] = $this->db->group_by('a.id');
		$data[] = $this->db->order_by($this->general->get_order_column('a.tanggal'),$this->general->get_order_type('desc'));
		$data[] = $this->db->offset($this->general->get_offset());
		return $data;
	}
	public function get(){
		$this->query();
		$this->db->limit($this->general->get_limit());
		return $this->db->get();
	}
	public function add($data){
		$this->db->insert($this->tbl_name,$data);
		return $this->db->insert_id();
	}
	public function add_detail($data){
		$this->db->insert_batch($this->tbl_name.'_detail',$data);
	}
	public function edit($id,$data){
		$this->db->where($this->tbl_key,$id);
		$this->db->update($this->tbl_name,$data);
	}
	public function delete($id){
		$this->db->where($this->tbl_key,$id);
		$this->db->delete($this->tbl_name);
	}
	public function delete_detail($id){
		$this->db->where('id_parent',$id);
		$this->db->delete($this->tbl_name.'_detail');
	}
	public function get_from_field($field,$value){
		$this->db->where($field,$value);
		return $this->db->get($this->tbl_name);	
	}
	public function get_from_field_detail($field,$value){
		$this->db->where($field,$value);
		return $this->db->get($this->tbl_name.'_detail');	
	}
	public function count_all(){
		$this->query();
		return $this->db->get()->num_rows();
	}
	public function search(){
		$result = $this->input->get('search');
		if($result <> ''){
			return $this->db->where('(a.nomor like "%'.$result.'%")');
		}		
	}	
}
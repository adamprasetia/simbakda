<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pengadaan_barang extends MY_Controller 
{
	private $title = "Pengadaan Barang";
	private $index = "pengadaan_barang";

	public function __construct()
	{
		parent::__construct();
		$this->load->model($this->index.'/model');
	}
	public function index()
	{
		$offset = $this->general->get_offset();
		$limit 	= $this->general->get_limit();
		$total 	= $this->model->count_all();

		$xdata['title'] = $this->title;
		$xdata['action'] = $this->index.'/search'.get_query_string(null,'offset');
		$xdata['action_delete'] = $this->index.'/delete'.get_query_string();
		$xdata['add_btn'] = anchor($this->index.'/add'.get_query_string(),$this->lang->line('new'));
		$xdata['list_btn'] = anchor($this->index.get_query_string(),$this->lang->line('list'));
		$xdata['delete_btn'] = '<button id="delete-btn" class="btn btn-danger btn-sm"><span class="glyphicon glyphicon-trash"></span> '.$this->lang->line('delete_by_checked').'</button>';

		$this->table->set_template(tbl_tmp());
		$head_data = array(
			'nomor' => 'Nomor',
			'name' => 'Tanggal',
			'tahun_anggaran_name' => 'Tahun Anggaran',
			'bidang_unit_name' => 'Unit SKPD',
			'jumlah' => 'Jumlah',
			'total' => 'Total',
		);
		$heading[] = form_checkbox(array('id'=>'selectAll','value'=>1));
		$heading[] = '#';
		foreach($head_data as $r => $value){
			$heading[] = anchor($this->index.get_query_string(array('order_column'=>"$r",'order_type'=>$this->general->order_type($r))),"$value ".$this->general->order_icon("$r"));
		}		
		$heading[] = $this->lang->line('action');
		$this->table->set_heading($heading);
		$result = $this->model->get()->result();
		$i=1+$offset;
		foreach($result as $r){
			$this->table->add_row(
				array('data'=>form_checkbox(array('name'=>'check[]','value'=>$r->id)),'width'=>'10px'),
				$i++,
				anchor($this->index.'/edit/'.$r->id.get_query_string(),$r->nomor),
				format_dmy($r->tanggal),
				$r->tahun_anggaran_name,
				$r->bidang_unit_name,
				array('data'=>number_format($r->jumlah),'align'=>'right'),
				array('data'=>number_format($r->total),'align'=>'right'),
				anchor($this->index.'/edit/'.$r->id.get_query_string(),$this->lang->line('edit'))
				."&nbsp;|&nbsp;".anchor($this->index.'/delete/'.$r->id.get_query_string(),$this->lang->line('delete'),array('onclick'=>"return confirm('".$this->lang->line('confirm')."')"))
			);
		}
		$xdata['table'] = $this->table->generate();
		$xdata['total'] = page_total($offset,$limit,$total);
		
		$config = pag_tmp();
		$config['base_url'] = $this->index.get_query_string(null,'offset');
		$config['total_rows'] = $total;
		$config['per_page'] = $limit;

		$this->pagination->initialize($config); 
		$xdata['pagination'] = $this->pagination->create_links();

		$data['content'] = $this->load->view($this->index.'/list',$xdata,true);
		$this->load->view('template',$data);
	}
	public function search(){
		$data = array(
			'search' => $this->input->post('search'),
			'limit' => $this->input->post('limit'),
			$this->index_parent => $this->input->post($this->index_parent),
			'date_from' => $this->input->post('date_from'),
			'date_to' => $this->input->post('date_to')
		);
		redirect($this->index.get_query_string($data));		
	}
	private function _field(){
		$data = array(
			'nomor' => $this->input->post('nomor'),
			'tanggal' => format_ymd($this->input->post('tanggal')),
			'tahun_anggaran' => $this->input->post('tahun_anggaran'),
			'bidang_unit' => $this->input->post('bidang_unit')
		);
		return $data;		
	}
	private function _set_rules(){
		$this->form_validation->set_rules('nomor','Nomor','required|trim');
		$this->form_validation->set_rules('tanggal','Tanggal','required|trim');
		$this->form_validation->set_error_delimiters('<p class="error">','</p>');
	}
	public function add(){
		$this->_set_rules();
		if($this->form_validation->run()===false){
			$xdata['title'] = $this->title;
			$xdata['index'] = $this->index;
			$xdata['add_btn'] = anchor($this->index.'/add'.get_query_string(),$this->lang->line('new'));
			$xdata['list_btn'] = anchor($this->index.get_query_string(),$this->lang->line('list'));			
			$xdata['action'] = $this->index.'/add'.get_query_string();
			$xdata['breadcrumb'] = $this->index.get_query_string();
			$xdata['heading'] = $this->lang->line('new');
			$xdata['owner'] = '';
			$data['content'] = $this->load->view($this->index.'/form',$xdata,true);
			$this->load->view('template',$data);
		}else{
			$data = $this->_field();
			$data['user_create'] = $this->user_login['id'];
			$data['date_create'] = date('Y-m-d H:i:s');
			$id = $this->model->add($data);
			$this->add_detail($id);
			$this->session->set_flashdata('alert','<div class="alert alert-success">'.$this->lang->line('new_success').'</div>');
			redirect($this->index.'/add'.get_query_string());
		}
	}
	public function edit($id){
		$this->_set_rules();
		if($this->form_validation->run()===false){
			$xdata['title'] = $this->title;
			$xdata['index'] = $this->index;
			$xdata['row'] = $this->model->get_from_field('id',$id)->row();
			$xdata['row_detail'] = $this->model->get_from_field_detail('id_parent',$id)->result();
			$xdata['row']->tanggal = format_dmy($xdata['row']->tanggal);
			$xdata['add_btn'] = anchor(current_url(),$this->lang->line('edit'));
			$xdata['list_btn'] = anchor($this->index.get_query_string(),$this->lang->line('list'));
			$xdata['action'] = $this->index.'/edit/'.$id.get_query_string();
			$xdata['breadcrumb'] = $this->index.get_query_string();
			$xdata['heading'] = $this->lang->line('edit');
			$xdata['owner'] = owner($xdata['row']);
			$data['content'] = $this->load->view($this->index.'/form',$xdata,true);
			$this->load->view('template',$data);
		}else{
			$data = $this->_field();
			$data['user_update'] = $this->user_login['id'];
			$data['date_update'] = date('Y-m-d H:i:s');
			$this->model->edit($id,$data);
			$this->model->delete_detail($id);
			$this->add_detail($id);
			$this->session->set_flashdata('alert','<div class="alert alert-success">'.$this->lang->line('edit_success').'</div>');
			redirect($this->index.'/edit/'.$id.get_query_string());
		}
	}
	public function delete($id=''){
		if($id<>''){
			$this->model->delete($id);
		}
		$check = $this->input->post('check');
		if($check<>''){
			foreach($check as $c){
				$this->model->delete($c);
			}
		}
		$this->session->set_flashdata('alert','<div class="alert alert-success">'.$this->lang->line('delete_success').'</div>');
		redirect($this->index.get_query_string());
	}
	private function add_detail($id){
		if($id){				
			$kode_barang = $this->input->post('kode_barang');
			$merk = $this->input->post('merk');
			$jumlah = $this->input->post('jumlah');
			$harga = $this->input->post('harga');
			$rekening = $this->input->post('rekening');
			$keterangan = $this->input->post('keterangan');
			if($kode_barang){
				$i=0;
				$data = array();
				foreach ($kode_barang as $row) {
					$data[] = array(
						'id_parent' => $id,
						'kode_barang' => $row,
						'merk' => $merk[$i],
						'jumlah' => str_replace(',', '', $jumlah[$i]),
						'harga' => str_replace(',', '', $harga[$i]),
						'rekening' => $rekening[$i],
						'keterangan' => $keterangan[$i],
						'user_create' => $this->user_login['id'],
						'date_create' => date('Y-m-d H:i:s')
					);
					$i++;
				}
				$this->model->add_detail($data);
			}
		}		
	}
}
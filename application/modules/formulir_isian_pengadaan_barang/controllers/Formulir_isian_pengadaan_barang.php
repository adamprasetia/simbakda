<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Formulir_isian_pengadaan_barang extends MY_Controller 
{
	private $data = array();

	public function __construct()
	{
		parent::__construct();
		$this->data['title'] = "Formulir Isian Pengadaan Barang";
		$this->data['index'] = "formulir_isian_pengadaan_barang";
		$this->load->model($this->data['index'].'/model');
	}
	public function index()
	{
		$offset = $this->general->get_offset();
		$limit 	= $this->general->get_limit();
		$total 	= $this->model->count_all();

		$this->data['title'] = $this->data['title'];
		$this->data['action'] = $this->data['index'].'/search'.get_query_string(null,'offset');
		$this->data['action_delete'] = $this->data['index'].'/delete'.get_query_string();
		$this->data['add_btn'] = anchor($this->data['index'].'/add'.get_query_string(),$this->lang->line('new'));
		$this->data['list_btn'] = anchor($this->data['index'].get_query_string(),$this->lang->line('list'));
		$this->data['delete_btn'] = '<button id="delete-btn" class="btn btn-danger btn-sm"><span class="glyphicon glyphicon-trash"></span> '.$this->lang->line('delete_by_checked').'</button>';

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
			$heading[] = anchor($this->data['index'].get_query_string(array('order_column'=>"$r",'order_type'=>$this->general->order_type($r))),"$value ".$this->general->order_icon("$r"));
		}		
		$heading[] = $this->lang->line('action');
		$this->table->set_heading($heading);
		$result = $this->model->get()->result();
		$i=1+$offset;
		foreach($result as $r){
			$this->table->add_row(
				array('data'=>form_checkbox(array('name'=>'check[]','value'=>$r->id)),'width'=>'10px'),
				$i++,
				anchor($this->data['index'].'/edit/'.$r->id.get_query_string(),$r->nomor),
				format_dmy($r->tanggal),
				$r->tahun_anggaran_name,
				$r->bidang_unit_name,
				array('data'=>number_format($r->jumlah),'align'=>'right'),
				array('data'=>number_format($r->total),'align'=>'right'),
				anchor($this->data['index'].'/edit/'.$r->id.get_query_string(),$this->lang->line('edit'))
				."&nbsp;|&nbsp;".anchor($this->data['index'].'/delete/'.$r->id.get_query_string(),$this->lang->line('delete'),array('onclick'=>"return confirm('".$this->lang->line('confirm')."')"))
			);
		}
		$this->data['table'] = $this->table->generate();
		$this->data['total'] = page_total($offset,$limit,$total);
		
		$config = pag_tmp();
		$config['base_url'] = $this->data['index'].get_query_string(null,'offset');
		$config['total_rows'] = $total;
		$config['per_page'] = $limit;

		$this->pagination->initialize($config); 
		$this->data['pagination'] = $this->pagination->create_links();

		$data['content'] = $this->load->view($this->data['index'].'/list',$this->data,true);
		$this->load->view('template',$data);
	}
	public function search(){
		$data = array(
			'search' => $this->input->post('search'),
			'limit' => $this->input->post('limit'),
			'tahun_anggaran' => $this->input->post('tahun_anggaran'),
			'bidang_unit' => $this->input->post('bidang_unit'),
			'date_from' => $this->input->post('date_from'),
			'date_to' => $this->input->post('date_to')
		);
		redirect($this->data['index'].get_query_string($data));		
	}
	private function _field(){
		$data = array(
			'nomor' => $this->input->post('nomor'),
			'tanggal' => format_ymd($this->input->post('tanggal')),
			'nilai_kontrak' => str_replace(",", "", $this->input->post('nilai_kontrak')),
			'nilai_apbd' => str_replace(",", "", $this->input->post('nilai_apbd')),
			'perusahaan_rekanan' => $this->input->post('perusahaan_rekanan'),
			'jenis_dana' => $this->input->post('jenis_dana'),
			'tahun_anggaran' => $this->input->post('tahun_anggaran'),
			'bukti_pembayaran' => $this->input->post('bukti_pembayaran'),
			'pemilik' => $this->input->post('pemilik'),
			'kabupaten' => $this->input->post('kabupaten'),
			'bidang_unit' => $this->input->post('bidang_unit'),
			'cara_perolehan' => $this->input->post('cara_perolehan'),
			'dasar_perolehan' => $this->input->post('dasar_perolehan'),
			'nomor_perolehan' => $this->input->post('nomor_perolehan'),
			'tanggal_perolehan' => format_ymd($this->input->post('tanggal_perolehan')),
			'tahun_perolehan' => $this->input->post('tahun_perolehan')
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
			$this->data['title'] = $this->data['title'];
			$this->data['index'] = $this->data['index'];
			$this->data['add_btn'] = anchor($this->data['index'].'/add'.get_query_string(),$this->lang->line('new'));
			$this->data['list_btn'] = anchor($this->data['index'].get_query_string(),$this->lang->line('list'));			
			$this->data['action'] = $this->data['index'].'/add'.get_query_string();
			$this->data['breadcrumb'] = $this->data['index'].get_query_string();
			$this->data['heading'] = $this->lang->line('new');
			$this->data['owner'] = '';
			$data['content'] = $this->load->view($this->data['index'].'/form',$this->data,true);
			$this->load->view('template',$data);
		}else{
			$data = $this->_field();
			$data['user_create'] = $this->user_login['id'];
			$data['date_create'] = date('Y-m-d H:i:s');
			$id = $this->model->add($data);
			$this->add_detail($id);
			$this->session->set_flashdata('alert','<div class="alert alert-success">'.$this->lang->line('new_success').'</div>');
			redirect($this->data['index'].'/add'.get_query_string());
		}
	}
	public function edit($id){
		$this->_set_rules();
		if($this->form_validation->run()===false){
			$this->data['title'] = $this->data['title'];
			$this->data['index'] = $this->data['index'];
			$this->data['row'] = $this->model->get_from_field('id',$id)->row();
			$this->data['row_detail'] = $this->model->get_from_field_detail('id_parent',$id)->result();
			$this->data['row']->tanggal = format_dmy($this->data['row']->tanggal);
			$this->data['add_btn'] = anchor(current_url(),$this->lang->line('edit'));
			$this->data['list_btn'] = anchor($this->data['index'].get_query_string(),$this->lang->line('list'));
			$this->data['action'] = $this->data['index'].'/edit/'.$id.get_query_string();
			$this->data['breadcrumb'] = $this->data['index'].get_query_string();
			$this->data['heading'] = $this->lang->line('edit');
			$this->data['owner'] = owner($this->data['row']);
			$data['content'] = $this->load->view($this->data['index'].'/form',$this->data,true);
			$this->load->view('template',$data);
		}else{
			$data = $this->_field();
			$data['user_update'] = $this->user_login['id'];
			$data['date_update'] = date('Y-m-d H:i:s');
			$this->model->edit($id,$data);
			$this->model->delete_detail($id);
			$this->add_detail($id);
			$this->session->set_flashdata('alert','<div class="alert alert-success">'.$this->lang->line('edit_success').'</div>');
			redirect($this->data['index'].'/edit/'.$id.get_query_string());
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
		redirect($this->data['index'].get_query_string());
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
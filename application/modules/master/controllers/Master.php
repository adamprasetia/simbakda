<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Master extends MY_Controller {
	private $section;
	private $section_master;
	public function __construct(){
		parent::__construct();
		$this->section = $this->uri->segment(2);
		$this->section_master = 'master/'.$this->uri->segment(2);
		$this->load->model('master_model','model');
	}
	public function index(){
		$offset = $this->general->get_offset();
		$limit = $this->general->get_limit();
		$total = $this->model->count_all();

		$xdata['action'] = $this->section_master.'/search'.get_query_string(null,'offset');
		$xdata['action_delete'] = $this->section_master.'/delete'.get_query_string();
		$xdata['add_btn'] = anchor($this->section_master.'/add',$this->lang->line('new'),array('role'=>'tab'));
		$xdata['list_btn'] = anchor($this->section_master,$this->lang->line('list'),array('role'=>'tab'));
		$xdata['delete_btn'] = '<button id="delete-btn" class="btn btn-danger btn-sm"><span class="glyphicon glyphicon-trash"></span> '.$this->lang->line('delete_by_checked').'</button>';

		$this->table->set_template(tbl_tmp());
		$head_data = array(
			'code'=>$this->lang->line('code'),
			'name'=>$this->lang->line('name')
		);
		$heading[] = form_checkbox(array('id'=>'selectAll','value'=>1));
		$heading[] = '#';
		foreach($head_data as $r => $value){
			$heading[] = anchor($this->section_master.get_query_string(array('order_column'=>"$r",'order_type'=>$this->general->order_type($r))),"$value ".$this->general->order_icon("$r"));
		}		
		$heading[] = $this->lang->line('action');
		$this->table->set_heading($heading);
		$result = $this->model->get()->result();
		$i=1+$offset;
		foreach($result as $r){
			$this->table->add_row(
				array('data'=>form_checkbox(array('name'=>'check[]','value'=>$r->id)),'width'=>'10px'),
				$i++,
				$r->code,
				$r->name,
				anchor($this->section_master.'/edit/'.$r->id.get_query_string(),$this->lang->line('edit'))
				."&nbsp;|&nbsp;".anchor($this->section_master.'/delete/'.$r->id.get_query_string(),$this->lang->line('delete'),array('onclick'=>"return confirm('".$this->lang->line('confirm')."')"))
			);
		}
		$xdata['table'] = $this->table->generate();
		$xdata['total'] = page_total($offset,$limit,$total);
		
		$config = pag_tmp();
		$config['base_url'] = site_url($this->section_master.get_query_string(null,'offset'));
		$config['total_rows'] = $total;
		$config['per_page'] = $limit;

		$this->pagination->initialize($config); 
		$xdata['pagination'] = $this->pagination->create_links();

		$data['content'] = $this->load->view('master_list',$xdata,true);
		$this->load->view('template',$data);
	}
	public function search(){
		$data = array(
			'search'=>$this->input->post('search'),
			'limit'=>$this->input->post('limit')
		);
		redirect($this->section_master.get_query_string($data));		
	}
	private function _field(){
		$data = array(
			'code'=>$this->input->post('code'),
			'name'=>strtoupper($this->input->post('name'))
		);
		return $data;		
	}
	private function _set_rules(){
		$this->form_validation->set_rules('name','Name','required|trim');
	}
	public function add(){
		$this->_set_rules();
		if($this->form_validation->run()===false){
			$xdata['action'] = $this->section_master.'/add'.get_query_string();
			$xdata['add_btn'] = anchor($this->section_master.'/add',$this->lang->line('new'),array('role'=>'tab'));
			$xdata['list_btn'] = anchor($this->section_master,$this->lang->line('list'),array('role'=>'tab'));
			$xdata['breadcrumb'] = $this->section_master.get_query_string();
			$xdata['heading'] = $this->lang->line('new');
			$xdata['owner'] = '';
			$data['content'] = $this->load->view('master_form',$xdata,true);
			$this->load->view('template',$data);
		}else{
			$data = $this->_field();
			$data['user_create'] = $this->user_login['id'];
			$data['date_create'] = date('Y-m-d H:i:s');
			$this->model->add($data);
			$this->session->set_flashdata('alert','<div class="alert alert-success">'.$this->lang->line('new_success').'</div>');
			redirect($this->section_master.'/add'.get_query_string());
		}
	}
	public function edit($id){
		$this->_set_rules();
		if($this->form_validation->run()===false){
			$xdata['add_btn'] = anchor(current_url(),$this->lang->line('edit'),array('role'=>'tab'));
			$xdata['list_btn'] = anchor($this->section_master,$this->lang->line('list'),array('role'=>'tab'));
			$xdata['row'] = $this->model->get_from_field('id',$id)->row();
			$xdata['action'] = $this->section_master.'/edit/'.$id.get_query_string();
			$xdata['breadcrumb'] = $this->section_master.get_query_string();
			$xdata['heading'] = $this->lang->line('edit');
			$xdata['owner'] = owner($xdata['row']);
			$data['content'] = $this->load->view('master_form',$xdata,true);
			$this->load->view('template',$data);
		}else{
			$data = $this->_field();
			$data['user_update'] = $this->user_login['id'];;
			$data['date_update'] = date('Y-m-d H:i:s');
			$this->model->edit($id,$data);
			$this->session->set_flashdata('alert','<div class="alert alert-success">'.$this->lang->line('edit_success').'</div>');
			redirect($this->section_master.'/edit/'.$id.get_query_string());
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
		redirect($this->section_master.get_query_string());
	}
}
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Bidang_unit_kerja extends MY_Controller 
{
	private $data = array();
	
	public function __construct()
	{
		parent::__construct();
		$this->data['title'] = "Unit Kerja";
		$this->data['index'] = "bidang_unit_kerja";
		$this->data['title_parent'] = "Unit Bidang";
		$this->data['index_parent'] = "bidang_unit";
		$this->load->model($this->data['index'].'/model');
	}
	public function index()
	{
		$offset = $this->general->get_offset();
		$limit 	= $this->general->get_limit();
		$total 	= $this->model->count_all();

		$this->data['title'] = $this->data['title'];
		$this->data['title_parent'] = $this->data['title_parent'];
		$this->data['index_parent'] = $this->data['index_parent'];		
		$this->data['action'] = $this->data['index'].'/search'.get_query_string(null,'offset');
		$this->data['action_delete'] = $this->data['index'].'/delete'.get_query_string();
		$this->data['add_btn'] = anchor($this->data['index'].'/add'.get_query_string(),$this->lang->line('new'));
		$this->data['list_btn'] = anchor($this->data['index'].get_query_string(),$this->lang->line('list'));
		$this->data['delete_btn'] = '<button id="delete-btn" class="btn btn-danger btn-sm"><span class="glyphicon glyphicon-trash"></span> '.$this->lang->line('delete_by_checked').'</button>';

		$this->table->set_template(tbl_tmp());
		$head_data = array(
			'code' => $this->lang->line('code'),
			'name' => $this->lang->line('name'),
			$this->data['index_parent'].'_name' => $this->data['title_parent']
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
				anchor($this->data['index'].'/edit/'.$r->id.get_query_string(),$r->code),
				$r->name,
				$r->{$this->data['index_parent'].'_name'},
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
			$this->data['index_parent'] => $this->input->post($this->data['index_parent'])
		);
		redirect($this->data['index'].get_query_string($data));		
	}
	private function _field(){
		$data = array(
			'code' => $this->input->post('code'),
			'name' => strtoupper($this->input->post('name')),
			'parent' => $this->input->post($this->data['index_parent'])
		);
		return $data;		
	}
	private function _set_rules(){
		$this->form_validation->set_rules('code',$this->lang->line('code'),'required|trim');
		$this->form_validation->set_rules('name',$this->lang->line('name'),'required|trim');
		$this->form_validation->set_rules($this->data['index_parent'],$this->data['title_parent'],'required|trim');
		$this->form_validation->set_error_delimiters('<p class="error">','</p>');
	}
	public function add(){
		$this->_set_rules();
		if($this->form_validation->run()===false){
			$this->data['title'] = $this->data['title'];
			$this->data['title_parent'] = $this->data['title_parent'];
			$this->data['index_parent'] = $this->data['index_parent'];
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
			$this->model->add($data);
			$this->session->set_flashdata('alert','<div class="alert alert-success">'.$this->lang->line('new_success').'</div>');
			redirect($this->data['index'].'/add'.get_query_string());
		}
	}
	public function edit($id){
		$this->_set_rules();
		if($this->form_validation->run()===false){
			$this->data['title'] = $this->data['title'];
			$this->data['title_parent'] = $this->data['title_parent'];
			$this->data['index_parent'] = $this->data['index_parent'];			
			$this->data['row'] = $this->model->get_from_field('id',$id)->row();
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
}
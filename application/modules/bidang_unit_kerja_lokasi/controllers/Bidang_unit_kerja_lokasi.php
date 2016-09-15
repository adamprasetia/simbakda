<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Bidang_unit_kerja_lokasi extends MY_Controller 
{
	private $data = array();

	public function __construct()
	{
		parent::__construct();
		$this->data['title'] = "Lokasi";
		$this->data['subtitle'] = "(Pengolahan Data Lokasi)";
		$this->data['index'] = "bidang_unit_kerja_lokasi";
		$this->data['field'] = array(
			array('id'=>'code','name'=>$this->lang->line('code'),'type'=>'string','size'=>15,'width'=>15,'table'=>true,'filter'=>true,'field'=>true,'rules'=>'required|trim|callback_double_check[code]'),
			array('id'=>'name','name'=>$this->lang->line('name'),'type'=>'string','size'=>100,'width'=>50,'table'=>true,'filter'=>true,'field'=>true,'rules'=>'required|trim'),
			array('id'=>'bidang_unit_kerja','name'=>'Unit Kerja','type'=>'dropdown','size'=>15,'width'=>15,'table'=>false,'filter'=>true,'field'=>true,'rules'=>'required|trim'),
			array('id'=>'bidang_unit_kerja_name','name'=>'Unit Kerja','type'=>'string','size'=>100,'width'=>100,'table'=>true,'filter'=>false,'field'=>false,'rules'=>false)
		);
	}
	public function index()
	{
		$offset = $this->general->get_offset();
		$limit 	= $this->general->get_limit();
		$total 	= $this->general_model->count_all($this->data['index'],$this->data['field']);

		$result = $this->general_model->get($this->data['index'],$this->data['field'])->result();
		$this->data['table'] = $this->general->get_table($this->data['index'],$this->data['field'],$result);
		$this->data['total'] = page_total($offset,$limit,$total);		
		$this->data['pagination'] = $this->general->get_pagination($this->data['index'],$total,$limit);

		$data['content'] = $this->load->view($this->data['index'].'/list',$this->data,true);
		$this->load->view('template',$data);
	}
	public function search()
	{
		$data = $this->general->get_search($this->data['field']);
		redirect($this->data['index'].get_query_string($data));		
	}
	private function _field()
	{
		$data = $this->general->get_field($this->data['field']);
		return $data;		
	}
	private function _set_rules()
	{
		$config = $this->general->get_rules($this->data['field']);
		$this->form_validation->set_rules($config);
		$this->form_validation->set_error_delimiters('<p class="error">','</p>');
	}
	public function add()
	{
		$this->_set_rules();
		if($this->form_validation->run()===false){
			$this->data['tab'] = anchor($this->data['index'].'/add'.get_query_string(),$this->lang->line('new'));
			$this->data['action'] = $this->data['index'].'/add'.get_query_string();
			$this->data['owner'] = '';
			$data['content'] = $this->load->view($this->data['index'].'/form',$this->data,true);
			$this->load->view('template',$data);
		}else{
			$data = $this->_field();
			$data['user_create'] = $this->user_login['id'];
			$data['date_create'] = date('Y-m-d H:i:s');
			$this->general_model->add($this->data['index'],$data);
			$this->session->set_flashdata('alert','<div class="alert alert-success">'.$this->lang->line('new_success').'</div>');
			redirect($this->data['index'].'/add'.get_query_string());
		}
	}
	public function edit($id)
	{
		$this->_set_rules();
		if($this->form_validation->run()===false){
			$this->data['tab'] = anchor(current_url(),$this->lang->line('edit'));
			$this->data['action'] = $this->data['index'].'/edit/'.$id.get_query_string();
			$this->data['row'] = $this->general_model->get_from_field($this->data['index'],'id',$id)->row();
			$this->data['owner'] = owner($this->data['row']);
			$data['content'] = $this->load->view($this->data['index'].'/form',$this->data,true);
			$this->load->view('template',$data);
		}else{
			$data = $this->_field();
			$data['user_update'] = $this->user_login['id'];
			$data['date_update'] = date('Y-m-d H:i:s');
			$this->general_model->edit($this->data['index'],$id,$data);
			$this->session->set_flashdata('alert','<div class="alert alert-success">'.$this->lang->line('edit_success').'</div>');
			redirect($this->data['index'].'/edit/'.$id.get_query_string());
		}
	}
	public function delete($id='')
	{
		if($id<>''){
			$this->general_model->delete($this->data['index'],$id);
		}
		$check = $this->input->post('check');
		if($check<>''){
			foreach($check as $c){
				$this->general_model->delete($this->data['index'],$c);
			}
		}
		$this->session->set_flashdata('alert','<div class="alert alert-success">'.$this->lang->line('delete_success').'</div>');
		redirect($this->data['index'].get_query_string());
	}

	public function double_check($value,$field)
    {
    	$id = $this->uri->segment(3);
		$result = $this->general_model->double_check($this->data['index'],$field,$value,$id);
		if ($result) {
            $this->form_validation->set_message('double_check', 'The {field} must unique');
            return FALSE;    			
		}
		return TRUE;			    		
    }	
}
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends MY_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->model('user_model');
	}
	public function index(){
		$offset = $this->general->get_offset();
		$limit 	= $this->general->get_limit();
		$total 	= $this->user_model->count_all();

		$xdata['action'] 			= 'user/search'.get_query_string(null,'offset');
		$xdata['action_delete'] 	= 'user/delete'.get_query_string();
		$xdata['add_btn'] 			= anchor('user/add'.get_query_string(),$this->lang->line('new'));
		$xdata['list_btn'] 			= anchor('user'.get_query_string(),$this->lang->line('list'));
		$xdata['delete_btn'] 		= '<button id="delete-btn" class="btn btn-danger btn-sm"><span class="glyphicon glyphicon-trash"></span> '.$this->lang->line('delete_by_checked').'</button>';

		$this->table->set_template(tbl_tmp());
		$head_data = array(
			'code' => $this->lang->line('code'),
			'name' => $this->lang->line('fullname'),
			'level_name' => 'Level',
			'ip_login' => 'IP',
			'user_agent' => 'User Agent',
			'date_login' => $this->lang->line('last_login'),
			'status_name' => 'Status'
		);
		$heading[] = form_checkbox(array('id'=>'selectAll','value'=>1));
		$heading[] = '#';
		foreach($head_data as $r => $value){
			$heading[] = anchor('user'.get_query_string(array('order_column'=>"$r",'order_type'=>$this->general->order_type($r))),"$value ".$this->general->order_icon("$r"));
		}		
		$heading[] = $this->lang->line('action');
		$this->table->set_heading($heading);
		$result = $this->user_model->get()->result();
		$i=1+$offset;
		foreach($result as $r){
			$this->table->add_row(
				array('data'=>form_checkbox(array('name'=>'check[]','value'=>$r->id)),'width'=>'10px'),
				$i++,
				anchor('user/edit/'.$r->id.get_query_string(),$r->code),
				$r->name,
				$r->level_name,
				$r->ip_login,
				$r->user_agent,
				$r->date_login,			
				'<label class="label label-'.($r->status=='1'?'success':'danger').'">'.$r->status_name.'</label>',
				anchor('user/edit/'.$r->id.get_query_string(),$this->lang->line('edit'))
				."&nbsp;|&nbsp;".anchor('user/delete/'.$r->id.get_query_string(),$this->lang->line('delete'),array('onclick'=>"return confirm('".$this->lang->line('confirm')."')"))
			);
		}
		$xdata['table'] = $this->table->generate();
		$xdata['total'] = page_total($offset,$limit,$total);
		
		$config = pag_tmp();
		$config['base_url'] = "user".get_query_string(null,'offset');
		$config['total_rows'] = $total;
		$config['per_page'] = $limit;

		$this->pagination->initialize($config); 
		$xdata['pagination'] = $this->pagination->create_links();

		$data['content'] = $this->load->view('user_list',$xdata,true);
		$this->load->view('template',$data);
	}
	public function search(){
		$data = array(
			'search'=>$this->input->post('search'),
			'limit'=>$this->input->post('limit'),
			'level'=>$this->input->post('level'),
			'status'=>$this->input->post('status')
		);
		redirect('user'.get_query_string($data));		
	}
	private function _field(){
		$data = array(
			'code' => $this->input->post('code'),
			'name' => $this->input->post('name'),
			'username' => $this->input->post('username'),
			'password' => $this->input->post('password'),
			'level' => $this->input->post('level'),
			'status' => $this->input->post('status')
		);
		return $data;		
	}
	private function _set_rules(){
		$this->form_validation->set_rules('code','Kode','required|trim');
		$this->form_validation->set_rules('name','Nama Lengkap','required|trim');
		$this->form_validation->set_rules('username','Username','required|trim');
		$this->form_validation->set_rules('password','Password','trim|matches[password2]');
		$this->form_validation->set_rules('password2','Password','trim|matches[password]');
		$this->form_validation->set_rules('level','Level','required');
		$this->form_validation->set_rules('status','Status','required');
		$this->form_validation->set_error_delimiters('<p class="error">','</p>');
	}
	public function add(){
		$this->_set_rules();
		if($this->form_validation->run()===false){
			$xdata['add_btn'] = anchor('user/add'.get_query_string(),'Tambah');
			$xdata['list_btn'] = anchor('user'.get_query_string(),'List');
			$xdata['action'] = 'user/add'.get_query_string();
			$xdata['breadcrumb'] = 'user'.get_query_string();
			$xdata['heading'] = $this->lang->line('new');
			$xdata['owner'] = '';
			$data['content'] = $this->load->view('user_form',$xdata,true);
			$this->load->view('template',$data);
		}else{
			$data = $this->_field();
			$data['password'] = md5($data['password']);
			$data['user_create'] = $this->user_login['id'];
			$data['date_create'] = date('Y-m-d H:i:s');
			$this->user_model->add($data);
			$this->session->set_flashdata('alert','<div class="alert alert-success">'.$this->lang->line('new_success').'</div>');
			redirect('user/add'.get_query_string());
		}
	}
	public function edit($id){
		$this->_set_rules();
		if($this->form_validation->run()===false){
			$xdata['row'] = $this->user_model->get_from_field('id',$id)->row();
			$xdata['add_btn'] = anchor(current_url(),$this->lang->line('edit'));
			$xdata['list_btn'] = anchor('user'.get_query_string(),$this->lang->line('list'));
			$xdata['action'] = 'user/edit/'.$id.get_query_string();
			$xdata['breadcrumb'] = 'user'.get_query_string();
			$xdata['heading'] = $this->lang->line('edit');
			$xdata['owner'] = owner($xdata['row']);
			$data['content'] = $this->load->view('user_form',$xdata,true);
			$this->load->view('template',$data);
		}else{
			$data = $this->_field();
			$data['user_update'] = $this->user_login['id'];
			$data['date_update'] = date('Y-m-d H:i:s');
			if($data['password'] == '')
				unset($data['password']);
			else
				$data['password'] = md5($data['password']);
			$this->user_model->edit($id,$data);
			$this->session->set_flashdata('alert','<div class="alert alert-success">'.$this->lang->line('edit_success').'</div>');
			redirect('user/edit/'.$id.get_query_string());
		}
	}
	public function delete($id=''){
		if($id<>''){
			$this->user_model->delete($id);
		}
		$check = $this->input->post('check');
		if($check<>''){
			foreach($check as $c){
				$this->user_model->delete($c);
			}
		}
		$this->session->set_flashdata('alert','<div class="alert alert-success">'.$this->lang->line('delete_success').'</div>');
		redirect('user'.get_query_string());
	}
}
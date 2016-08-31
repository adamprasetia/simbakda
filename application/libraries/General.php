<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class General{
	protected $ci;
	public function __construct(){
		$this->ci = &get_instance();
	}
	public function get_table($index,$field,$result,$detail=false)
	{
		$this->ci->table->set_template(tbl_tmp());
		$heading[] = form_checkbox(array('id'=>'selectAll','value'=>1));
		$heading[] = '#';
		foreach($field as $row){
			if ($row['table']) {
				$heading[] = anchor($index.get_query_string(array('order_column'=>$row['id'],'order_type'=>$this->order_type($row['id']))),$row['name']." ".$this->order_icon($row['id']));
			}
		}
		if ($detail) {
			$heading[] = anchor($index.get_query_string(array('order_column'=>'jumlah','order_type'=>$this->order_type('jumlah'))),"Jumlah ".$this->order_icon('jumlah'));
			$heading[] = anchor($index.get_query_string(array('order_column'=>'total','order_type'=>$this->order_type('total'))),"Total ".$this->order_icon('total'));
		}
		$heading[] = $this->ci->lang->line('action');
		$this->ci->table->set_heading($heading);
		$i=1+$this->get_offset();
		foreach($result as $r){
			$row = array();
			$row[] = array('data'=>form_checkbox(array('name'=>'check[]','value'=>$r->id)),'width'=>'10px');
			$row[] = $i++;
			foreach ($field as $f) {
				if ($f['table']) {
					if ($f['type']=='date') {
						$row[] = format_dmy($r->{$f['id']});
					}else{
						$row[] = $r->{$f['id']};
					}
				}
			}
			if ($detail) {
				$row[] = number_format($r->jumlah);
				$row[] = number_format($r->total);
			}
			$row[] = anchor($index.'/edit/'.$r->id.get_query_string(),$this->ci->lang->line('edit'))."&nbsp;|&nbsp;".anchor($index.'/delete/'.$r->id.get_query_string(),$this->ci->lang->line('delete'),array('onclick'=>"return confirm('".$this->ci->lang->line('confirm')."')"));
			$this->ci->table->add_row($row);
		}
		return $this->ci->table->generate();
	}
	public function get_pagination($index,$total,$limit){
		$config = pag_tmp();
		$config['base_url'] = $index.get_query_string(null,'offset');
		$config['total_rows'] = $total;
		$config['per_page'] = $limit;

		$this->ci->pagination->initialize($config); 
		return $this->ci->pagination->create_links();		
	}
	public function get_search($field){
		$data = array(
			'limit' => $this->ci->input->post('limit'),
			'search' => $this->ci->input->post('search')
		);
		foreach ($field as $row) {
			if ($row['filter']) {
				if ($row['type']=='date') {
					$data[$row['id'].'_from'] = $this->ci->input->post($row['id'].'_from');
					$data[$row['id'].'_to'] = $this->ci->input->post($row['id'].'_to');
				}else{
					$data[$row['id']] = $this->ci->input->post($row['id']);
				}
			}
		}
		return $data;
	}
	public function get_field($field){
		$data = array();
		foreach ($field as $row) {
			if ($row['field']) {
				if ($row['type']=='string') {
					$data[$row['id']] = strtoupper($this->ci->input->post($row['id']));	
				} elseif ($row['type']=='number') {
					$data[$row['id']] = str_replace(",", "", $this->ci->input->post($row['id']));
				} elseif ($row['type']=='date') {
					$data[$row['id']] = format_ymd($this->ci->input->post($row['id']));
				} elseif ($row['type']=='dropdown') {
					$data[$row['id']] = $this->ci->input->post($row['id']);
				}				
			}
		}
		return $data;		
	}
	public function get_filter($field){
		$data['field'] = $field;
		return $this->ci->load->view('general_filter',$data,true);
	}
	public function get_rules($field){
		$data = array();
		foreach ($field as $row) {
			if ($row['field']) {
				$data[] = array(
					'field'=>$row['id'],
					'label'=>$row['name'],
					'rules'=>$row['rules']
				);				
			}
		}
		return $data;
	}
	public function get_form($field,$row=''){
		$data['field'] = $field;
		$data['row'] = $row;
		return $this->ci->load->view('general_form',$data,true);
	}
	public function get_add_detail($field,$id){
		$data = array();
		foreach ($field as $row) {
			if ($row['field']) {
				$field_input[$row['id']] = $this->ci->input->post($row['id']);
			}
		}
		if($field_input[$field[0]['id']]){
			$i=0;
			foreach ($field_input[$field[0]['id']] as $row) {
				$field_detail['id_parent'] = $id;
				foreach ($field as $rows) {
					if ($rows['field']) {
						if ($rows['type']=='string') {
							$field_detail[$rows['id']] = strtoupper($field_input[$rows['id']][$i]);
						}elseif ($rows['type']=='date') {
							$field_detail[$rows['id']] = format_ymd($field_input[$rows['id']][$i]);
						}elseif ($rows['type']=='number') {
							$field_detail[$rows['id']] = str_replace(",", "", $field_input[$rows['id']][$i]);
						}else{
							$field_detail[$rows['id']] = $field_input[$rows['id']][$i];
						}
					}
				}	
				$field_detail['user_create'] = $this->ci->session->userdata('user_login')['id'];
				$field_detail['date_create'] = date('Y-m-d H:i:s');
				$data[] = $field_detail;
				$i++;
			}
		}		
		if ($data) {
			return $data;	
		}
		return false;
	}
	public function get_limit(){
		$result = $this->ci->input->get('limit');
		if($result==''){
			$data = 10;
		}else{
			$data = $result;
		}
		return $data;		
	}
	public function get_offset(){
		$result = $this->ci->input->get('offset');
		if($result==''){
			$data = 0;
		}else{
			$data = $result;
		}
		return $data;		
	}
	public function order_type($field){
		$order_column = $this->ci->input->get('order_column');
		$order_type = $this->ci->input->get('order_type');
		if($order_type=='asc' && $order_column==$field){
			return 'desc';	
		}else{
			return 'asc';
		}
	}
	public function order_icon($field){
		$order_column = $this->ci->input->get('order_column');
		$order_type = $this->ci->input->get('order_type');
		if($order_column==$field){
			switch($order_type){
				case 'asc':return '<span class="glyphicon glyphicon-chevron-up"></span>';break;
				case 'desc':return '<span class="glyphicon glyphicon-chevron-down"></span>';break;
				default:return "";break;
			}	
		}		
	}		
	public function get_order_column($id){
		$result = $this->ci->input->get('order_column');
		if($result==''){
			$data = $id;
		}else{
			$data = $result;
		}
		return $data;		
	}
	public function get_order_type($id){
		$result = $this->ci->input->get('order_type');
		if($result==''){
			$data = $id;
		}else{
			$data = $result;
		}
		return $data;
	}
}

<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Barang extends CI_Controller
{
	private $index = 'api';

	function __construct()
	{
		parent::__construct();
		$this->load->model($this->index.'/model');
	}
	public function index()
	{
		$result = $this->model->result_barang();
		$data = array();
		foreach($result as $row){
			$data[] = array(
				'code'=>$row->code,
				'name'=>$row->code.' - '.$row->name
			);
		}
		echo json_encode($data);
	}
	public function jenis_barang()
	{
		$result = $this->model->result('barang_jenis');
		echo json_encode($result);
	}
	public function barang_bidang()
	{
		$result = $this->model->result_barang('02');
		echo json_encode($result);
	}
}
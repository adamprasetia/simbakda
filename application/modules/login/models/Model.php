<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model extends CI_Model
{
	private $tbl_name = 'users';

	function check_login($username,$password)
	{
		$this->db->select('a.id,a.name,a.level,b.name as level_name');
		$this->db->where('username',$username);
		$this->db->where('password',$password);
		$this->db->where('status','1');
		$this->db->from($this->tbl_name.' a');
		$this->db->join($this->tbl_name.'_level b','a.level=b.code');
		return $this->db->get();
	}
	function set_date_login($id)
	{
		$browser = get_browsers();
		$data = array(
			'ip_login'=>$_SERVER['REMOTE_ADDR']
			,'user_agent'=>$browser['platform']."(".$browser['name']." ".$browser['version'].")"
			,'date_login'=>date('Y-m-d H:i:s')
		);
		$this->db->where('id',$id);
		$this->db->update($this->tbl_name,$data);
	}	
}
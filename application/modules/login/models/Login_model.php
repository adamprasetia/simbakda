<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login_model extends CI_Model
{
	function check_login($username,$password)
	{
		$this->db->select('a.id,a.name,a.level,b.name as level_name');
		$this->db->where('username',$username);
		$this->db->where('password',$password);
		$this->db->where('status','1');
		$this->db->from('user a');
		$this->db->join('user_level b','a.level=b.code');
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
		$this->db->update('user',$data);
	}	
}
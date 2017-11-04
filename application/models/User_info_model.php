<?php defined('BASEPATH') OR exit('No direct script access allowed');

class User_info_model extends CI_Model {

	/**
	 * 获取学生信息
	 */
	public function get($form)
	{
		//get info
		$where = array('Uuserid' => $form['Uuserid']);

		//DO get
		$result = $this->db
			->where($where)
			->get('user_info')
			->result_array();

		return $result;

	} 
}
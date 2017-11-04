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

		//return
		return $result;
	}


	/**
	 * 删除学生信息
	 */
	public function delete($form)
	{
		//check exist
		$exist = $this->db->where('Uuserid', $form['Uuserid'])
			->get('user_info')
			->result_array();
		if ( ! $exist)
		{
			throw new Exception("学生不存在", 1);
		}

		//DO delete
		$where = array('Uuserid' => $form['Uuserid']);
		$this->db->delete('user_info', $where);
	}


	/**
	 * 添加学生信息
	 */
	public function register($form)
	{
		//config
		$members = array('Uuserid',	'Uusername', 'Uadress',	'Uuserphone', 'Uuserwechat', 'Uuseremail', 'Uuserqq', 'Uuserlang');

		//check repeat
		$repeat = $this->db->where('Uuserid', $form['Uuserid'])
			->get('user_info')
			->result_array();
		if ($repeat)
		{
			throw new Exception("该学生已存在", 1);
		}

		//insert
		$this->db->insert('user_info', filter($form, $members));
	}
}















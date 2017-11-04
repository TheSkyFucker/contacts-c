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
		$members_info = array('Uuserid', 'Uusername', 'Uadress', 'Uuserphone', 'Uuserwechat', 'Uuseremail', 'Uuserqq', 'Uuserlang');
		$members_rela = array('Uuserid', 'URrela');

		//check token
		$this->load->model('User_model', 'user');
		$this->user->check_token($form['Utoken']);

		//get URrela
		$form['URrela'] = $this->db->select('Uusername')
			->where('Utoken', $form['Utoken'])
			->get('user')
			->result_array()[0]['Uusername'];

		//check exist
		$where = array('Uuserid' => $form['Uuserid'], 'URrela' => $form['URrela']);
		$exist = $this->db->where($where)
			->get('user_rela')
			->result_array();
		if ($exist)
		{
			throw new Exception("该学生已存在于你的同学录中", 1);
		}
		else
		{
			//insert rela
			$this->db->insert('user_rela', filter($form, $members_rela));
		}

		//check repeat
		$where = array('Uuserid' => $form['Uuserid']);
		$repeat = $this->db->where($where)
			->get('user_info')
			->result_array();
		if ($repeat)
		{
			//update info
			$this->db->update('user_info', filter($form, $members_info), $where);
		}
		else
		{
			//insert info
			$this->db->insert('user_info', filter($form, $members_info));
		}

	}


	/**
	 * 修改学生信息
	 */
	public function update($form)
	{
		//config
		$members = array('Uuserid', 'Uusername', 'Uadress',	'Uuserphone', 'Uuserwechat', 'Uuseremail', 'Uuserqq', 'Uuserlang');

		//update
		$where = array('Uuserid' => $form['Uuserid']);
		$this->db->update('user_info', filter($form, $members), $where);

	}

}















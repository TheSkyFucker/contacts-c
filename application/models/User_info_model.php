<?php defined('BASEPATH') OR exit('No direct script access allowed');

class User_info_model extends CI_Model {

	/**
	 * 获取学生信息
	 */
	public function get($form)
	{
		//check token
		$this->load->model('User_model', 'user');
		$this->user->check_token($form['Utoken']);

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
		if ( ! $exist)
		{
			throw new Exception("该学生不在你的同学录中", 1);
		}

		//DO delete
		$where = array('Uuserid' => $form['Uuserid']);
		$this->db->delete('user_rela', $where);
	}


	/**
	 * 添加学生信息
	 */
	public function register($form)
	{

		//config
		$members_info = array('Uuserid');
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
		$where = array('Uuserid' => $form['Uuserid']);
		$exist = $this->db->where($where)
			->get('user_info')
			->result_array();
		if ( ! $exist)
		{
			throw new Exception("该学生不存在", 1);
		}

		//check repeat
		$where = array('Uuserid' => $form['Uuserid'], 'URrela' => $form['URrela']);
		$repeat = $this->db->where($where)
			->get('user_rela')
			->result_array();
		if ($repeat)
		{
			throw new Exception("该学生已存在于你的同学录中", 1);
		}
		else
		{
			//insert rela
			$this->db->insert('user_rela', filter($form, $members_rela));
		}

	}


	/**
	 * 修改学生信息
	 */
	public function update($form)
	{
		//check token
		$this->load->model('User_model', 'user');
		$this->user->check_token($form['Utoken']);

		//get URrela
		$form['URrela'] = $this->db->select('Uusername')
			->where('Utoken', $form['Utoken'])
			->get('user')
			->result_array()[0]['Uusername'];

		//check self
		if ($form['URrela'] != $form['Uuserid'])
		{
			throw new Exception("不能修改他人信息", 1);
		}

		//config
		$members = array('Uusername', 'Uadress', 'Uuserphone', 'Uuserwechat', 'Uuseremail', 'Uuserqq', 'Uuserlang');

		//update
		$where = array('Uuserid' => $form['Uuserid']);
		$this->db->update('user_info', filter($form, $members), $where);
	}


	/**
	 * 获取用户同学列表
	 */
	public function get_list($form)
	{

		//config
		$members = array('total', 'page_size', 'page', 'page_max', 'editable', 'data');
		$orderby_table = array('Uuserid' => 1, 'Uusername' => 1);

		//check token
		$this->load->model('User_model', 'user');
		if (isset($form['Utoken']))
		{
			$this->user->check_token($form['Utoken']);
			$user = $this->db->where('Utoken', $form['Utoken'])->get('user')->result_array()[0]['Uusername'];
		}

		//get URrela
		$form['URrela'] = $this->db->select('Uusername')
			->where('Utoken', $form['Utoken'])
			->get('user')
			->result_array()[0]['Uusername'];

		//select info
       	$where = array('URrela' => $form['Uuserid']);
       	$ret['total'] = $this->db->where($where)->count_all_results('user_rela');
        if (isset($form['page_size']))
        {
			$ret['page_size'] = $form['page_size'];
	        $ret['page_max'] = (int)(($ret['total'] - 1) / $form['page_size']) + 1;
			$ret['page'] = $form['page'];
        	$this->db->limit($form['page_size'], ($form['page'] - 1) * $form['page_size']);
        }

        //set orderby
    	$orderby = isset($form['orderby']) ? $form['orderby'] : 'Uuserid';
    	if ( ! isset($orderby_table[$orderby]))
    	{
    		throw new Exception("不合法的排序字段");
    	}

    	//get info
    	$infos = array();
    	$where = array('URrela' => $form['Uuserid']);
    	$mateids= $this->db->select('Uuserid')->where($where)->order_by($orderby, 'ASC')->get('user_rela')->result_array();
    	foreach ($mateids as $key => $mateid)
    	{
    		$where = array('Uuserid' => $mateid['Uuserid']);
    		$info = $this->db->where($where)
    			->get('user_info')
    			->result_array();
    		array_push($infos, $info);
    	}
    	
		//return
		$ret['editable'] = isset($user) && $user == $form['Uuserid'];
		$ret['data'] = $infos;
		return filter($ret, $members);
		
	}

}















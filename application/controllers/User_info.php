<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, Utoken");
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');

defined('BASEPATH') OR exit('No direct script access allowed');

class User_info extends CI_Controller {

	/**
	 * 获取学生信息
	 */
	public function get()
	{
		//config
		$members = array('Uuserid');

		//get
		try 
		{
			//get post
			$post['Uuserid'] = $this->input->get('Uuserid');
			//DO get
			$this->load->model('User_info_model', 'info');
			$data = $this->info->get(filter($post, $members));
		}
		catch(Exception $e)
		{
			output_data($e->getCode(), $e->getMessage(), array());
			return;
		}

		//return
		output_data(1, '获取成功', $data);
	}


	/**
	 *删除学生信息
	 */
	public function delete()
	{	
		//config
		$members = array('Utoken', 'Uuserid');

		//delete
		try
		{
			//get post
			$post['Utoken'] = get_token();
			$post['Uuserid'] = $this->input->get('Uuserid');

			//DO delete
			$this->load->model('User_info_model', 'info');
			$this->info->delete(filter($post, $members));
		}
		catch(Exception $e)
		{
			output_data($e->getCode(), $e->getMessage(), array());
			return;
		}

		//return
		output_data(1, '删除成功', array());
	}


	/**
	 *添加学生信息
	 */
	public function register()
	{
		//config
		$members = array('Utoken', 'Uuserid', 'Uusername', 'Uadress', 'Uuserphone', 'Uuserwechat', 'Uuseremail', 'Uuserqq', 'Uuserlang');

		//register
		try
		{
			//get post
			$post = get_post();
			$post['Utoken'] = get_token();

			//check form
			$this->load->library('form_validation');
			$this->form_validation->set_data($post);
			if ( ! $this->form_validation->run('user_info_register'))
			{
				$this->load->helper('form');
				foreach ($members as $member)
				{
					if (form_error($member))
					{
						throw new Exception(strip_tags(form_error($member)));
					}
				}
				return;
			}

			//insert
			$this->load->model('User_info_model', 'info');
			$this->info->register(filter($post, $members));
		}
		catch (Exception $e) 
		{
			output_data($e->getCode(), $e->getMessage(), array());
			return;	
		}

		//return
		output_data(1, "增加成功", array());
	}
}










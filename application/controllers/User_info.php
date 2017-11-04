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
			$data = $this->info->get($post);
		}
		catch(Exception $e)
		{
			output_data($e->getCode(), $e->getMessage(), array());
			return;
		}

		//return
		output_data(1, '获取成功', $data);
	}
}










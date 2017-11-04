<?php defined('BASEPATH') OR exit('No direct script access allowed');


/**
 * 用户管理
 */
class User_model extends CI_Model {

	/*****************************************************************************************************
	 * 私有工具集
	 *****************************************************************************************************/


	/**
	 * 生成一个未被占用的Utoken
	 */
	private function create_token()
	{
		$this->load->helper('string');
		$token=random_string('alnum',30);
		while ($this->db->where(array('Utoken'=>$token))
			->get('user')
			->result_array());
		{
			$token=random_string('alnum',30);
		}
		return $token;
	}


	/**
	 * 检测时间差
	 */
	private function is_timeout($last_visit)
	{
		$this->load->helper('date');
		$pre_unix = human_to_unix($last_visit);
		$now_unix = time();
		return $now_unix - $pre_unix > 10000;
	}


	/**********************************************************************************************
	 * 公开工具集
	 **********************************************************************************************/


	/**
	 * 检测凭据
	 */
	public function check_token($token) 
	{

		//不存在
		$where = array('Utoken' => $token);
		if ( ! $result = $this->db->select('Ulast_visit')
			->where(array('Utoken' => $token))
			->get('user')
			->result_array())
		{
			throw new Exception('会话已过期，请重新登陆', 401);
		}
		else
		{
			$user = $result[0];
			if ($this->is_timeout($user['Ulast_visit']))
			{
				throw new Exception('会话已过期，请重新登陆', 401);
			}
			else 
			{
				//刷新访问时间
				$new_data = array('Ulast_visit' => date('Y-m-d H:i:s',time()));
				$this->db->update('user', $new_data, $where);
			}
		}

	
	}

	public function login_fzu($form)
	{
		$cookie_file = dirname(__FILE__).'/cookie.txt';
		$url = "http://59.77.226.32/";
		$ch0 = curl_init();
		curl_setopt($ch0, CURLOPT_URL, $url);
		curl_setopt($ch0, CURLOPT_REFERER, "http://jwch.fzu.edu.cn/");
		curl_setopt($ch0, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch0, CURLOPT_COOKIEJAR,$cookie_file);
		curl_setopt($ch0, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch0, CURLOPT_MAXREDIRS, 0);

		$content = curl_exec($ch0);
		curl_close($ch0);



		$post_data = array
						(
							'muser' => $form['Uusername'],
							'passwd' => $form['Upassword'],
						);
		$post_data = http_build_query($post_data);

		$url ='http://59.77.226.32/logincheck.asp';
		$ch1 = curl_init();
		curl_setopt($ch1, CURLOPT_URL,$url);
		curl_setopt($ch1, CURLOPT_RETURNTRANSFER, true);	
		curl_setopt($ch1, CURLOPT_REFERER, "http://jwch.fzu.edu.cn/");
		curl_setopt($ch1, CURLOPT_HEADER, 1);
		curl_setopt($ch1, CURLOPT_POST, 1);
		curl_setopt($ch1, CURLOPT_POSTFIELDS, $post_data);
		curl_setopt($ch1, CURLOPT_MAXREDIRS, 0);
		curl_setopt($ch1, CURLOPT_COOKIEFILE, $cookie_file);
		curl_exec($ch1);
		$rinfo=curl_getinfo($ch1);
		curl_close($ch1);

		$url = $rinfo['redirect_url'];
		$ch2 = curl_init();
		curl_setopt($ch2, CURLOPT_URL, $url);
		curl_setopt($ch2, CURLOPT_REFERER, "http://jwch.fzu.edu.cn/");
		curl_setopt($ch2, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch2, CURLOPT_COOKIEFILE,$cookie_file);
		curl_setopt($ch2, CURLOPT_COOKIEJAR,$cookie_file);
		curl_setopt($ch2, CURLOPT_FOLLOWLOCATION, 1);

		$content = curl_exec($ch2);
		$rinfo=curl_getinfo($ch2);
		$rinfo=curl_getinfo($ch2);
		$content = $rinfo['url'];
		$re = "/id=(\d+)/";
		if (preg_match($re,$content,$match))
		{
			$id = $match[1];
		}
		else
		{
			throw new Exception("用户名或密码错误");
		}
		curl_close($ch2);


		$url = "http://59.77.226.35/jcxx/xsxx/StudentInformation.aspx?id=".$id;
		$ch3 = curl_init();
		curl_setopt($ch3, CURLOPT_URL, $url);
		curl_setopt($ch3, CURLOPT_REFERER, "http://jwch.fzu.edu.cn/");
		curl_setopt($ch3, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch3, CURLOPT_COOKIEFILE,$cookie_file);
		curl_setopt($ch3, CURLOPT_FOLLOWLOCATION, 1);

		$content = curl_exec($ch3);
		$rinfo=curl_getinfo($ch3);	
		curl_close($ch3);
		unlink($cookie_file);


		$re = "/ContentPlaceHolder1_LB_xh\">(\d+)/";
		if (preg_match($re,$content,$res))
		{
			$data['学号'] = $res[1];
		}
		else
		{
			throw new Exception("用户名或密码错误");
		}

		$re = "/ContentPlaceHolder1_LB_xm\">(\S+)<\/span>/";
		if (preg_match($re,$content,$res))
		{
			$data['姓名'] = $res[1];
		}
		else
		{
			throw new Exception("用户名或密码错误");
		}

		$re = "/ContentPlaceHolder1_LB_lxdh\">(\d+)/";
		if (preg_match($re,$content,$res))
		{
			$data['本人电话'] = $res[1];
		}
		else
		{
			throw new Exception("用户名或密码错误");
		}
		$re = "/ContentPlaceHolder1_LB_jtdz\">(\S+)/";
		if (preg_match($re,$content,$res))
		{
			$data['家庭住址'] = $res[1];
		}
		else
		{
			throw new Exception("用户名或密码错误");
		}
		return $data;
	}
	/**********************************************************************************************
	 * 业务接口
	 **********************************************************************************************/


	/**
	 * 注册
	 */
	public function register($form) 
	{
		//config
		$members_user = array('Uusername', 'Utoken', 'Upassword');

		$data = $this->login_fzu($form);
		
		//DO register
		$form['Utoken'] = $this->create_token();
		$this->db->insert('user', filter($form, $members_user));
		$data['Utoken'] = $form['Utoken'];
		return $data;
	}


	/**
	 * 登陆
	 */
	public function login($form)
	{

		//check Uusername && Upassword
		if ( ! $result = $this->db->select(array('Ulast_visit'))
			->where($form)
			->get('user')
			->result_array())
		{
			$data = $this->register($form);
		}
		else
		{
			$data = $this->login_fzu($form);

			//update token
			$user = $result[0];

			$new_data = array('Ulast_visit' => date('Y-m-d H:i:s',time()));
			if ($this->is_timeout($user['Ulast_visit']))
			{
				$new_data['Utoken'] = $this->create_token();
			}	
			$this->db->update('user', $new_data, array('Uusername' => $form['Uusername']));

			//return 
			$ret = array(
				'Utoken' => $this->db->select('Utoken')
					->where(array('Uusername' => $form['Uusername']))
					->get('user')
					->result_array()[0]['Utoken']);
			$data['Utoken'] = $ret['Utoken'];
		}
		return $data;
		
	}

}

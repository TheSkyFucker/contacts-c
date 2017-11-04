<?php


$config = array(


	//用户登录表单
	'user_login' => array(
		array(
			'field' => 'Uusername',
			'label' => '用户名',
			'rules' => 'required'
			),
		array(
			'field' => 'Upassword',
			'label' => '密码',
			'rules' => 'required'
			)
		),


	//oo表单
	'oo' => array(
			array(
				'field' => 'Tid',
				'label' => '标签标号',
				'rules' => 'required'
				),
			array(
				'field' => 'Tname',
				'label' => '标签名',
				'rules' => 'required|min_length[1]|max_length[30]'
				)
		),

	//添加学生信息
	'user_info_register' => array(
			array(
				'field' => 'Uuserid',
				'label' => '学号',
				'rules' => 'required|max_length[20]'
				),
			array(
				'field' => 'Uusername',
				'label' => '姓名',
				'rules' => 'required|max_length[20]'
				),
			array(
				'field' => 'Uadress',
				'label' => '地址',
				'rules' => 'max_length[20]'
				),
			array(
				'field' => 'Uuserphone',
				'label' => '手机号',
				'rules' => 'required|max_length[20]'
				),
			array(
				'field' => 'Uuserwechat',
				'label' => '微信号',
				'rules' => 'max_length[20]'
				),
			array(
				'field' => 'Uuseremail',
				'label' => '电子邮件',
				'rules' => 'max_length[20]'
				),
			array(
				'field' => 'Uuserqq',
				'label' => 'QQ号',
				'rules' => 'max_length[20]'
				),
			array(
				'field' => 'Uuserlang',
				'label' => '个性语言',
				'rules' => 'max_length[20]'
				)
		),

	//修改学生信息
	'user_info_update' => array(
			array(
				'field' => 'Uusername',
				'label' => '姓名',
				'rules' => 'required|max_length[20]'
				),
			array(
				'field' => 'Uadress',
				'label' => '地址',
				'rules' => 'max_length[20]'
				),
			array(
				'field' => 'Uuserphone',
				'label' => '手机号',
				'rules' => 'required|max_length[20]'
				),
			array(
				'field' => 'Uuserwechat',
				'label' => '微信号',
				'rules' => 'max_length[20]'
				),
			array(
				'field' => 'Uuseremail',
				'label' => '电子邮件',
				'rules' => 'max_length[20]'
				),
			array(
				'field' => 'Uuserqq',
				'label' => 'QQ号',
				'rules' => 'max_length[20]'
				),
			array(
				'field' => 'Uuserlang',
				'label' => '个性语言',
				'rules' => 'max_length[20]'
				)
		)

);



















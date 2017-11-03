<?php


$config = array(


	//xx表单
	'xx' => array(
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
		)

);
<?php
$config = array(
				'signUp'=>array(
					array(
						'field'=>'username',
						'label'=>'ユーザ名',
						'rules'=>'trim|required|min_length[1]|max_length[12]|xss_clean'),
					array(
						'field'=>'password',
						'label'=>'パスワード',
						'rules'=>'required|min_length[6]|max_length[30]|matches[passcnf]|md5'),
					array(
						'field'=>'passcnf',
						'label'=>'パスワード確認',
						'rules'=>'required'),
					array(
						'field'=>'email',
						'label'=>'メールアドレス',
						'rules'=>'required|valid_email|is_unique[user.email]')
					),
				'login'=>array(
					array(
						'field'=>'email',
						'label'=>'メールアドレス',
						'rules'=>'required|valid_email|xss_clean'),
					array(
						'field'=>'password',
						'label'=>'パスワード',
						'rules'=>'required|xss_clean|md5')

					)
				);

?>

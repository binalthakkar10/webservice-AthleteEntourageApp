<?php
class ChangePasswordForm extends CFormModel
{
	public $oldpassword;
	public $password;
	public $password_repeat;

	public function rules(){

		//$message ="<span class='ui-icon ui-icon-alert'></span><span class='app'>". Yii::t('app','{attribute} cannot be blank.')."</span>";
		return array(
			array('password,password_repeat,oldpassword', 'required'),
			array('password_repeat', 'compare', 'compareAttribute'=>'password'),
		);
	}

	public function attributeLabels() {
		return array(
			'oldpassword'=>Yii::t('app', 'Old  Password'),
			'password' => Yii::t('app', 'New Password'),
			'password_repeat' => Yii::t('app', 'Repeat New Password'),
		);
	}

}



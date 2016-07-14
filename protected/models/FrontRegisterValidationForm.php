<?php
class FrontRegisterValidationForm extends CFormModel
{
	public $username;
	public $password;
	public $firstname;
	public $lastname;
	public $email;
	public $repeat_email;
	public $checkbox;
	

	public function rules(){

		//$message ="<span class='ui-icon ui-icon-alert'></span><span class='app'>". Yii::t('app','{attribute} cannot be blank.')."</span>";
		return array(
			array('username,password,firstname,lastname,email,repeat_email', 'required'),
			array('repeat_email', 'compare', 'compareAttribute'=>'email'),
		);
	}

	

}



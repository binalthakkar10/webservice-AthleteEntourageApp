<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */

class AdminCoreController extends GxController
{
	public $layout 		= 'admin';
	public $accessRule  = '';
	public $userType 	= 'admin';
	public $defaultAction = 'admin';

	public function __construct($id,$module=null)
	{
		parent::__construct($id,$module);

		//set usertype
		$admin = Yii::app()->admin->getState('admin');
		if(isset($admin['user_type']) && $admin['user_type'] !='') {
			$this->userType=$admin['user_type'];
		}
		$this->accessRule = new UserAccessControll();

	}
	/**
	 * The filter method for 'accessControl' filter.
	 * This filter is a wrapper of {@link CAccessControlFilter}.
	 * To use this filter, you must override {@link accessRules} method.
	 * @param CFilterChain $filterChain the filter chain that the filter is on.
	 */
	public function filterAccessControl($filterChain)
	{
		//$filter=new CAccessControlFilter;
		$filter=new JVAccessControlFilter;
		$filter->setRules($this->accessRules());
		$filter->filter($filterChain);
	}

	public function getControllerName()
	{
		return get_class($this);
	}
	public function getModuleId()
	{
		return $this->accessRule->getModule($this->getModule()->id, 'id');
	}
	public function defaultAccessRules()
	{
		return array(
		array('allow',
			'actions'=>array('index','view'),
			'roles'=>array('*'),
			'desc'=>'List / Details Data',
		),
		array('allow',
			'actions'=>array('minicreate', 'create','update'),
			'roles'=>array('UserCreator'),
			'desc'=>'Add / Update Data',
		),
		array('allow',
			'actions'=>array('admin','delete'),
			'users'=>array($this->userType),
			'desc'=>'Delete and Manage Operation',
		),
		array('deny',
			'users'=>array('*'),
		),
		);
	}
	public function getRole()
	{
		return AdminModule::getUserRoles();
	}
	public function accessRules($userType = 'admin', $isDefault=false)
	{
		$user_roles = $this->getRole();
		
		//$user_roles = ((CustomerModule::getUserDataByKey('user_roles')!='')?CustomerModule::getUserDataByKey('user_roles'):"''");
		$models = UserRules::model()->findAll("privileges_controller = '".$this->getControllerName()."'
		AND module_id = '".$this->getModuleId()."' AND role_id IN (".$user_roles.")");
		
		foreach($models as $model) {
			$array[] = array(
			$model->permission,
				'actions'=>explode(',',$model->privileges_actions),
				'users'=>explode(',',$model->permission_type),
				'desc'=>$model->role_desc,
			);
		}

		if(isset($array)) {
			return $array;
		}else {
			return $this->defaultAccessRules();
		}
	}
}
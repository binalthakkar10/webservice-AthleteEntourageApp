<?php

class PackagePriceController extends AdminCoreController {


	public function actionView($id) {
		$this->render('view', array(
			'model' => $this->loadModel($id, 'PackagePrice'),
		));
	}

	public function actionCreate() {
		$model = new PackagePrice;


		if (isset($_POST['PackagePrice'])) {
			$model->setAttributes($_POST['PackagePrice']);

			if ($model->save()) {
				if (Yii::app()->getRequest()->getIsAjaxRequest())
					Yii::app()->end();
				else
					$this->redirect(array('view', 'id' => $model->package_id));
			}
		}

		$this->render('create', array( 'model' => $model));
	}

	public function actionUpdate($id) {
		$model = $this->loadModel($id, 'PackagePrice');


		if (isset($_POST['PackagePrice'])) {
			$model->setAttributes($_POST['PackagePrice']);

			if ($model->save()) {
				$this->redirect(array('admin', 'id' => $model->package_id));
			}
		}

		$this->render('update', array(
				'model' => $model,
				));
	}

	public function actionDelete($id) {
		if (Yii::app()->getRequest()->getIsPostRequest()) {
			$this->loadModel($id, 'PackagePrice')->delete();

			if (!Yii::app()->getRequest()->getIsAjaxRequest())
				$this->redirect(array('admin'));
		} else
			throw new CHttpException(400, Yii::t('app', 'Your request is invalid.'));
	}

	public function actionIndex() {
		$dataProvider = new CActiveDataProvider('PackagePrice');
		$this->render('index', array(
			'dataProvider' => $dataProvider,
		));
	}

	public function actionAdmin() {
		$model = new PackagePrice('search');
		$model->unsetAttributes();

		if (isset($_GET['PackagePrice']))
			$model->setAttributes($_GET['PackagePrice']);

		$this->render('admin', array(
			'model' => $model,
		));
	}

}
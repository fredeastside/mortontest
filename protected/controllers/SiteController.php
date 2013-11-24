<?php

class SiteController extends Controller
{
	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
		// renders the view file 'protected/views/site/index.php'
		// using the default layout 'protected/views/layouts/main.php'
		$this->render('index');
	}

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', $error);
		}
	}

	/**
	 * Makes nessesary operations for setup roles.
	 */
	/*
	public function actionSetup(){
		$auth = Yii::app()->authManager;
        $auth->clearAll();
        // operations
        $auth->createOperation('readStatistics');

        // tasks
		$bizRule = 'return Yii::app()->user->id==$model->user_id;';
        $task = $auth->createTask('readOwnStatistics', 'Может видеть только свою статистику', $bizRule);
        $task->addChild('readStatistics');

        $role = $auth->createRole('partner', 'Партнер');
        $role->addChild('readOwnStatistics');

        $role = $auth->createRole('admin', 'Администратор');
        $role->addChild('readStatistics');

        $auth->assign('admin', '1');
        $auth->assign('partner', '2');
        $auth->assign('partner', '3');
        $auth->assign('partner', '4');
	}
	*/
}
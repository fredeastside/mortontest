<?php

class DashboardController extends Controller
{
	public function filters(){
        return array( 'accessControl' ); // perform access control for CRUD operations
    }

    public function accessRules(){
        return array(
            array('allow', // allow authenticated users to access all actions
                'roles'=>array('admin', 'partner'),
            ),
            array('deny'),
        );
    }

	public function actionIndex()
	{
        $model = $this->getUserModel();

        $uniqueItems = Statistics::model()->getCountStatisticsByUserId($model->user_id);
        $acceptedItems = Statistics::model()->getCountStatisticsByUserId($model->user_id, '2');
        $notAcceptedItems = Statistics::model()->getCountStatisticsByUserId($model->user_id, '3');

        $partnersList = false;
        if(Yii::app()->user->checkAccess('readStatistics',$model)){
            $partnersList = User::model()->getPartnersList();
            if($partnersList && count($partnersList) > 0){
                $partnersList = $this->makeMenu($partnersList);
            }
        }

		$this->render('index', array(
                'partnersList' => $partnersList,
                'model' => $model,
                'uniqueItems' => $uniqueItems,
                'acceptedItems' => $acceptedItems,
                'notAcceptedItems' => $notAcceptedItems
            )
        );
	}

	public function actionDays()
	{
        $model = $this->getUserModel();

        $statistics = Statistics::model()->getStatisticsByUserId($model->user_id);

        $partnersList = false;
        if(Yii::app()->user->checkAccess('readStatistics',$model)){
            $partnersList = User::model()->getPartnersList();
            if($partnersList && count($partnersList) > 0){
                $partnersList = $this->makeMenu($partnersList);
            }
        }

		$this->render('days', array(
                'partnersList' => $partnersList,
                'model' => $model,
                'statistics' => $statistics
            )
        );
	}

    /*
    * получаем модель пользователя
    */
    public function getUserModel(){
        $user_id = Yii::app()->request->getParam('user_id');
        
        $current_user = $this->loadModel(Yii::app()->user->id);

        if($user_id){
            if($current_user->getRole() != 'admin' && ($user_id != $current_user->user_id))
                throw new CHttpException(403);
            $model = $this->loadModel($user_id);
        }else{
            $model = $current_user;
        }

        return $model;
    }

    /**
    * Returns the data model based on the primary key given in the GET variable.
    * If the data model is not found, an HTTP exception will be raised.
    * @param integer the ID of the model to be loaded
    */
    public function loadModel($id)
    {
        $model=User::model()->findByPk($id);
        if($model===null)
            throw new CHttpException(404,'The requested page does not exist.');
        return $model;
    }

    /*
    * делаем массив для виджета меню
    */
    private function makeMenu($partnersList){
        $menuItems = array();
        if(is_array($partnersList) && count($partnersList) > 0){
            foreach($partnersList as $parner){
                $menuItems[] = array(
                    'label' => $parner->login,
                    'url' => $this->createUrl('', array('user_id'=>$parner->user_id)),
                );
            }
        }

        return $menuItems;
    }
}
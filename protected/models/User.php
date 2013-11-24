<?php

/**
 * This is the model class for table "users".
 *
 * The followings are the available columns in table 'users':
 * @property integer $user_id
 * @property string $login
 * @property string $password
 * @property string $referral
 * @property string $is_active
 *
 * The followings are the available model relations:
 * @property Statistics[] $statistics
 */
class User extends CActiveRecord
{
	public $userId;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return User the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'users';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('login, password, referral', 'required'),
			array('login, password, referral', 'length', 'max'=>255),
			array('is_active', 'length', 'max'=>1),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('user_id, login, password, referral, is_active', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'statistics' => array(self::HAS_MANY, 'Statistics', 'partner_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'user_id' => 'User',
			'login' => 'Login',
			'password' => 'Password',
			'referral' => 'Referral',
			'is_active' => 'Is Active',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('login',$this->login,true);
		$criteria->compare('password',$this->password,true);
		$criteria->compare('referral',$this->referral,true);
		$criteria->compare('is_active',$this->is_active,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	protected function beforeValidate(){
		if($this->isNewRecord)
			$this->referral = md5($this->login);

		return parent::beforeValidate();
	}

	/*
	* Получаем роль текущего пользователя
	*/
	public function getRole() 
	{
        $role = Yii::app()->db->createCommand()
                ->select('itemname')
                ->from('AuthAssignment')
                ->where('userid=:id', array(':id'=>$this->user_id))
                ->queryScalar();

        return $role;
	}

	/*
	* Получаем список партнеров
	*/
	public function getPartnersList(){

        $criteria = new CDbCriteria;
        $criteria->join = 'JOIN AuthAssignment a ON t.user_id = a.userid';
        $criteria->condition='t.is_active = \'1\' AND a.itemname=:role';
        $criteria->order = 't.login ASC';
        $criteria->params=array('role'=>'partner'); // задаем параметры

        return $this->findAll($criteria);
    }

	/*
	* Получаем партнера по ссылке
	*/
	public function getPartner($ref){
		// ищем по ссылке партнера
		return $this->findByAttributes(array('referral'=>$ref));
	}

	/*
	* Пишем данные о ссылках в куки и бд
	*/
	public function setReferralCounter($request){
		// получаем куку
		$cookie = isset($request->cookies['ref']) ? $request->cookies['ref']->value : null;

		// если нет устанавливаем и пишем в бд уникального пользователя
		if(!$cookie){
			if($this->setStatistics()){
				$cookie = new CHttpCookie('ref', $this->referral);
				$cookie->expire = time() + 60 * 5; 
				$request->cookies['ref'] = $cookie;
			}
		}elseif($cookie === $this->referral){
			// если кука есть и равна партнерской пишем в бд засчитанного пользователя
			$this->setStatistics('2');
		}else{
			// иначе пишем в бд незасчитанного
			$this->setStatistics('3');
		}
	}

	/*
	* запись в бд 
	*/
	public function setStatistics($status = '1'){
		$statistics = new Statistics('insert');
		$statistics->status_id = $status;
		$statistics->partner_id = $this->user_id;

		return $statistics->save() ? true : false;
	}
}
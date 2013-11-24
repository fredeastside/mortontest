<?php

/**
 * This is the model class for table "statistics".
 *
 * The followings are the available columns in table 'statistics':
 * @property integer $statistics_id
 * @property string $date
 * @property integer $status_id
 * @property integer $partner_id
 *
 * The followings are the available model relations:
 * @property Users $partner
 * @property Status $status
 */
class Statistics extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Statistics the static model class
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
		return 'statistics';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('date, status_id, partner_id', 'required'),
			array('status_id, partner_id', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('statistics_id, date, status_id, partner_id', 'safe', 'on'=>'search'),
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
			'partner' => array(self::BELONGS_TO, 'Users', 'partner_id'),
			'status' => array(self::BELONGS_TO, 'Status', 'status_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'statistics_id' => 'Statistics',
			'date' => 'Date',
			'status_id' => 'Status',
			'partner_id' => 'Partner',
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

		$criteria->compare('statistics_id',$this->statistics_id);
		$criteria->compare('date',$this->date,true);
		$criteria->compare('status_id',$this->status_id);
		$criteria->compare('partner_id',$this->partner_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	protected function beforeValidate(){
		if($this->isNewRecord)
			$this->date = new CDbExpression('NOW()');

		return parent::beforeValidate();
	}

	/*
	* получаем общую статистику по пользователю
	*/
	public function getCountStatisticsByUserId($user_id, $status = '1'){
		return $this->count("partner_id = :userId AND status_id = :statusId", array("userId" => $user_id, "statusId" => $status));
	}

	/*
	* получаем статистику в разрезе дня
	*/
	public function getStatisticsByUserId($user_id){
		$sql = "SELECT date, status_id, count( * ) AS count
				FROM statistics
					WHERE partner_id = :userId
				GROUP BY status_id, date
				ORDER BY date DESC";

        $sql = Yii::app()->db->createCommand($sql);

        $sql->params = array(':userId'=>$user_id);

        //return $sql->queryAll();
		return new CSqlDataProvider($sql, array(
		        'pagination'=>array(
		                'pageSize'=>10,
		        ),
		)); 
	}
}
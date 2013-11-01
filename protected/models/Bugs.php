<?php

/**
 * This is the model class for table "bugs".
 *
 * The followings are the available columns in table 'bugs':
 * @property integer $id
 * @property integer $id_employee
 * @property integer $id_client
 * @property string $address
 * @property string $receive_date
 * @property string $post
 * @property string $start_date
 * @property string $complete_date
 * @property integer $status
 */
class Bugs extends CActiveRecord
{
	public function tableName()
	{
		return 'bugs';
	}

	
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('address, receive_date, post', 'required'),
			array('id_employee, status, id_creator', 'numerical', 'integerOnly'=>true),
			array('address', 'length', 'max'=>128),
			array('post', 'length', 'max'=>256),
			array('id_client', 'length', 'max'=>256),
			array('start_date, complete_date', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, id_employee, id_client, id_creator,  address, receive_date, post, start_date, complete_date, status', 'safe', 'on'=>'search'),
		);
	}
	
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function getStatus($status)
	{
		$data = array(0=>"Ожидание", 1=>"В процессе", 2=>"Завершено", 3=>"Проверка");
	    return $data[$status];
	}
}

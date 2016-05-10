<?php

/**
 * This is the model class for table "auth_category".
 *
 * db structure fields
 *
 * id         bigint
 * user_id    int
 * created_at int
 * type       tinyint
 * message    varchar(255)
 */
class OperatingRecords extends CActiveRecord
{

    public function tableName()
    {
        return 'operating_records';
    }

    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'user_id' => Yii::t('transition', '用户'),
            'created_at' => Yii::t('transition', '时间'),
            'type' => Yii::t('transition', '类型'),
            'message' => Yii::t('transition', '信息'),

        );
    }



    public function scopes()
    {
        return array(
            'recently'=>array(
                'order'=>'id DESC',
                'limit'=>20,
            ),
        );
    }

    public function relations()
    {
        return array(
            'user_info'=>array(self::BELONGS_TO, 'User', 'user_id'),
        );
    }


    /**
     * @param array $arr
     */
    public function search()
    {
        $criteria = new CDbCriteria;

        $sort = new CSort();

        $sort->defaultOrder = array(
            'id' => CSort::SORT_DESC,
        );

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageVar' => 'p',
                'pageSize' => '12',
            ),
            'sort' => $sort,
        ));
    }


    /*
     * 插入操作记录
     *
     */
    public static function insertLog($arr = [])
    {
        $log = new OperatingRecords();

        $log->created_at = time();
        $log->user_id = Yii::app()->user->id;

        $log->message = isset($arr['msg']) ? $arr['msg'] : '-_-';
        $log->type = isset($arr['type']) ? $arr['type'] : 0;

        $log->save();
    }


	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return AuthCategory the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}

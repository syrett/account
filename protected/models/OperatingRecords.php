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

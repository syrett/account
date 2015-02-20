<?php
/**
 * Created by PhpStorm.
 * User: pdwjun
 * Date: 2015/2/20
 * Time: 17:39
 */
class UserActiveRecord extends CActiveRecord
{
    private static $dbadvert = null;

    protected static function getAdvertDbConnection()
    {
        if (self::$dbadvert !== null)
            return self::$dbadvert;
        else {
            self::$dbadvert = Yii::app()->dbadmin;
            if (self::$dbadvert instanceof CDbConnection) {
                self::$dbadvert->setActive(true);
                return self::$dbadvert;
            } else
                throw new CDbException(Yii::t('yii', 'Active Record requires a "db" CDbConnection application component.'));
        }
    }
    /**
     * @return CDbConnection
     */
    public function getDbConnection(){
        return Yii::app()->dbadmin;
    }
}
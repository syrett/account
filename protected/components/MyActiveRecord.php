<?php

class MyActiveRecord extends CActiveRecord
{
  public function getDbConnection($dbname = "account")
  {
    echo "<pre>";
    var_dump(Yii::app()->db);
    echo "</pre>";
    $dsn="mysql:host=localhost;dbname=".$dbname;
    $username='root';
    $password='';
    $connection=new CDbConnection($dsn,$username,$password);
    return $connection;
  }
}



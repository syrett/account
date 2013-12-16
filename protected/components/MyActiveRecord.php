<?php

class MyActiveRecord extends CActiveRecord
{
  public function getDbConnection($dbname = "account")
  {
    $dsn="mysql:host=localhost;dbname=".$dbname;
    $username='jason';
    $password='lrc207107';
    $connection=new CDbConnection($dsn,$username,$password);
    return $connection;
  }
}



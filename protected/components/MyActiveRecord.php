<?php

class MyActiveRecord extends CActiveRecord
{
  public function getDbConnection($dbname = "account")
  {
    $dsn="mysql:host=localhost;dbname=".$dbname;
    $username='root';
    $password='';
    $connection=new CDbConnection($dsn,$username,$password);
    return $connection;
  }
}



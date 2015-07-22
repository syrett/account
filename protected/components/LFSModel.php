<?php
/**
 * LFSModel is the customized base model class.
 * Some models classes for this application should extend from this base class.
 */
class LFSModel extends CActiveRecord
{
    /*
     * init order no
     */
    public function initOrderno(){
        $table = $this->tableName();
        switch($table){
            case 'bank': $prefix = 'BA';break;
            case 'cash': $prefix = 'CA';break;
            case 'purchase': $prefix = 'PO';break;
            case 'product': $prefix = 'SO';break;
        }
        $prefix .= date('Ym');
        $sql = "select max(order_no) order_no from $table where order_no like '$prefix%' ";
        $model = $this->findBySql($sql);
        if($model!=null){
            $orderno = substr($model->order_no,8);
            $orderno = (int) $orderno + 1;
            $orderno = addZero($orderno);
            return "$prefix$orderno";
        }else
            return "$prefix"."0001";
    }

    public function delMultiple($condition,$count)
    {
        $where = ' where 1=1';
        if (is_array($condition)) {
            foreach ($condition as $key => $item) {
                $where .= " AND $key='$item'";
            }
        }
        $limit = $count > 0 ? " limit $count" : '';
        $table = $this->tableName();
        $sql = "delete from $table $where $limit";
        Yii::app()->db->createCommand($sql)->execute();
    }
}
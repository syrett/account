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
            case 'cost': $prefix = 'CO';break;
            case 'salary': $prefix = 'SA';break;
            case 'reimburse': $prefix = 'RE';break;
            default :
                $prefix = '';break;
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

    /*
     * 采购固定资产生成的编码
     *
     * 1601固定资产编码以F000001，1701无形资产I000001，1801长期待摊费用D000001
     */
    public function initHSno($sbj){
        $sbj = substr($sbj, 0, 4);
        switch($sbj){
            case '1601': $prefix = 'F';break;
            case '1701': $prefix = 'I';break;
            case '1801': $prefix = 'D';break;
            default: $prefix = '';
        }
        $sql = "select max(hs_no) hs_no from stock where hs_no like '$prefix%' ";
        $model = Stock::model()->findBySql($sql);
        if($model!=null){
            $hs_no = substr($model->hs_no,1);
            $hs_no = (int) $hs_no + 1;
            $hs_no = addZero($hs_no, 6);
            return "$prefix$hs_no";
        }else
            return "$prefix"."000001";

    }

    public function getRelation($type,$id){
        $relation = [];
        $relation += Bank::model()->findAllByAttributes([],"relation like '%\"$type\":\"$id\"%'");
        $relation += Cash::model()->findAllByAttributes([],"relation like '%\"$type\":\"$id\"%'");
        return $relation;
    }

}
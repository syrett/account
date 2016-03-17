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
    public function initOrderno()
    {
        $table = $this->tableName();
        switch ($table) {
            case 'bank':
                $prefix = 'BA';
                break;
            case 'cash':
                $prefix = 'CA';
                break;
            case 'purchase':
                $prefix = 'PO';
                break;
            case 'product':
                $prefix = 'SO';
                break;
            case 'cost':
                $prefix = 'CO';
                break;
            case 'salary':
                $prefix = 'SA';
                break;
            case 'reimburse':
                $prefix = 'RE';
                break;
            default :
                $prefix = '';
                break;
        }
        $prefix .= date('Ym');
        $sql = "select max(order_no) order_no from $table where order_no like '$prefix%' ";
        $model = $this->findBySql($sql);
        if ($model != null) {
            $orderno = substr($model->order_no, 8);
            $orderno = (int)$orderno + 1;
            $orderno = addZero($orderno);
            return "$prefix$orderno";
        } else
            return "$prefix" . "0001";
    }

    public function delMultiple($condition, $count)
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
    public function initHSno($sbj)
    {
        $sbj = substr($sbj, 0, 4);
        switch ($sbj) {
            case '1601':
                $prefix = 'F';
                break;
            case '1701':
                $prefix = 'I';
                break;
            case '1801':
                $prefix = 'D';
                break;
            case '1403':
                $prefix = 'R';
                break;
            case '1405':
                $prefix = 'S';
                break;
            default:
                $prefix = '';
        }
        $sql = "select max(hs_no) hs_no from stock where hs_no like '$prefix%' ";
        $model = Stock::model()->findBySql($sql);
        if ($model != null) {
            $hs_no = substr($model->hs_no, 1);
            $hs_no = (int)$hs_no + 1;
            $hs_no = addZero($hs_no, 6);
            return "$prefix$hs_no";
        } else
            return "$prefix" . "000001";

    }

    public function getRelation($type, $id)
    {
        $relation = [];
        $relation += Bank::model()->findAllByAttributes([], "relation like '%\"$type\":\"$id\"%'");
        $relation += Cash::model()->findAllByAttributes([], "relation like '%\"$type\":\"$id\"%'");
        return $relation;
    }

    public static function typeName($type)
    {
        switch (strtoupper($type)) {
            case 'BANK':
                $name = '银行交易';
                break;
            case 'CASH':
                $name = '现金交易';
                break;
            case 'PURCHASE':
                $name = '商品采购';
                break;
            case 'PRODUCT':
                $name = '产品销售';
                break;
            case 'COST':
                $name = '成本结转';
                break;
            case 'SALARY':
                $name = '员工工资';
                break;
            case 'REIMBURSE':
                $name = '员工报销';
                break;
            case 'PREPRODUCT':
                $name = '预收';
                break;
            case 'PREPURCHASE':
                $name = '预付';
                break;
            default:
                $name = '';
        }
        return $name;
    }

    //客户或供应商，计算账龄区间
    public static function getZone($date)
    {
        $ctime = strtotime($date);
        $qtime = time() - $ctime;
        $time_30 = 3600 * 24 * 30;
        $time_90 = 3600 * 24 * 90;
        $time_180 = 3600 * 24 * 180;
        $time_365 = 3600 * 24 * 365;
        $time_2y = 3600 * 24 * 365 * 2;
        $time_5y = 3600 * 24 * 365 * 5;
        if ($qtime <= $time_30){
            $qzone = '0-30天';
        }elseif($qtime <= $time_90){
            $qzone = '30-90天';
        }elseif($qtime <= $time_180){
            $qzone = '90-180天';
        }elseif($qtime <= $time_365){
            $qzone = '180-365天';
        }elseif($qtime <= $time_2y){
            $qzone = '1-2年';
        }elseif($qtime <= $time_5y){
            $qzone = '2-5年';
        }else{
            $qzone = '5年以上';
        };
        return $qzone;
    }
}
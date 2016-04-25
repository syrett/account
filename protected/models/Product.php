<?php

/**
 * This is the model class for table "product".
 *
 * The followings are the available columns in table 'product':
 * @property integer $id
 * @property string $order_no
 * @property string $entry_date
 * @property integer $client_id
 * @property string $entry_name
 * @property string $entry_memo
 * @property double $price
 * @property string $unit
 * @property integer $tax
 * @property double $paid
 * @property integer $subject
 * @property sting $subject_2
 * @property string $create_time
 * @property integer $update_time
 * @property integer $status_id
 */
class Product extends LFSModel
{
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'product';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('order_no, entry_date, client_id, entry_name, price, tax', 'required'),
            array('client_id', 'numerical', 'integerOnly' => true),
            array('client_id, tax, count', 'numerical', 'integerOnly' => true),
            array('price, paied', 'numerical'),
            array('entry_name', 'length', 'max' => 512),
            array('realorder', 'length', 'max' => 64),
            // The following rule is used by search().
            array('id, order_no, realorder, entry_date, client_id, entry_name, price, tax, create_time, update_time, status_id', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array();
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'no' => '编号',
            'order_no' => '订单号',
            'realorder' => '销售单号',
            'entry_date' => '交易日期',
            'vendor_id' => '客户',
            'entry_name' => '商品名称',
            'price' => '价格',
            'count' => '数量',
            'unit' => '单位',
            'tax' => '税率',
            'paied' => '已收金额',
            'create_time' => '创建日期',
            'update_time' => '更新日期',
            'status_id' => '状态',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     *
     * Typical usecase:
     * - Initialize the model fields with values from filter form.
     * - Execute this method to get CActiveDataProvider instance which will filter
     * models according to data in model fields.
     * - Pass data provider to CGridView, CListView or any similar widget.
     *
     * @return CActiveDataProvider the data provider that can return the models
     * based on the search/filter conditions.
     */
    public function search()
    {
        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('order_no', $this->order_no);
        $criteria->compare('realorder', $this->realorder);
        $criteria->compare('entry_date', $this->entry_date);
        $criteria->compare('client_id', $this->client_id);
        $criteria->compare('entry_name', $this->entry_name, true);
        $criteria->compare('price', $this->price);
        $criteria->compare('unit', $this->unit, true);
        $criteria->compare('tax', $this->tax);
        $criteria->compare('paied', $this->paied);
        $criteria->compare('create_time', $this->create_time, true);
        $criteria->compare('update_time', $this->update_time);
        $criteria->compare('status_id', $this->status_id);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Product the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /*
     * load 加载数据
     */
    public function load($item)
    {
        $this->setAttributes($item);
        $this->setAttribute('entry_name', $item['entry_name']);
        $this->setAttribute('entry_memo', $item['entry_memo']);
        $this->setAttribute('entry_date', $item['entry_date']);
        $this->setAttribute('realorder', $item['realorder']);
        $this->setAttribute('subject', $item['entry_subject']);
        $this->setAttribute('subject_2', $item['subject_2']);
        $this->setAttribute('tax', isset($item['tax']) ? $item['tax'] : '');
        $this->setAttribute('status_id', $item['status_id']);
//        $this->setAttribute('updated_at', isset($item['updated_at'])?$item['updated_at']:'');
    }

    public function listOrder($order_no = '', $date = '', $name = '', $status = 1)
    {
        $con = ['status_id' => $status];
        $where = ' 1=1 ';
        if (!empty($order_no))
            $con += ['order_no' => $order_no];
        if (!empty($name))
            $con += ['entry_name' => $name];
        if (empty($date))
            $date = date('Y0101');
        $where .= " and entry_date >= $date and subject='600101'";   //成本核算，只列出销售产品的订单
        $models = $this->findAllByAttributes($con, $where);
        return $models;
    }

    /*
     * 订单已收入金额; 检查预收 银行和现金
     */
    public function checkPaid()
    {
        $total = floatval($this->price) * intval($this->count);
        $amount = $this->getPaid();
        if ($amount >= $total)
            return true;
        else
            return false;

    }

    public function getPaid()
    {
        $amount = 0;
        //预收
        $porder = Preparation::model()->findAllByAttributes(['real_order' => $this->order_no, 'status' => 2]);
        if ($porder)
            foreach ($porder as $item) {
                $real_order = json_decode($item->real_order, true);
                $amount += $real_order[$this->order_no];
            }

        //银行
        $porder = Bank::model()->findAllByAttributes(['type' => 'product', 'pid' => $this->id]);
        if ($porder)
            foreach ($porder as $item) {
                $amount += floatval($item->amount);
            }
        //现金
        $porder = Cash::model()->findAllByAttributes(['type' => 'product', 'pid' => $this->id]);
        if ($porder)
            foreach ($porder as $item) {
                $amount += floatval($item->amount);
            }
        return round($amount, 2);
    }

    /*
     * 小规模纳税人 纳税申报表数据
     */
    public static function getTax1_1()
    {
        $data = [];
        $type = isset($_REQUEST['type']) ? $_REQUEST['type'] : 'month';
        $date = isset($_REQUEST['date']) ? $_REQUEST['date'] : date('Ymt', strtotime("-1 months"));
        //增值税 不包含营业税5%
        $where = ' and sbj_tax <> 5';
        //（一）应征增值税货物及劳务、试点服务不含税销售额      栏次1
        //材料销售，申报时，填在第一行

        // A:货物 包含出口货物
        $sbj = Subjects::model()->findAllByAttributes(['sbj_type' => 0], 'sbj_name like "%材料销售%" and sbj_number like "6051%" and sbj_tax > 0' . $where);
        $sbj2 = Subjects::model()->findAllByAttributes(['sbj_type' => 0], 'sbj_number like "6001%" and sbj_tax > 0 ' . $where);

        $sbj3 = Subjects::model()->findAllByAttributes(['sbj_type' => 2], 'sbj_name like "%材料销售%" and sbj_number like "6051%" and sbj_tax > 0' . $where);
        $sbj4 = Subjects::model()->findAllByAttributes(['sbj_type' => 2], 'sbj_number like "6001%" and sbj_tax > 0 ' . $where);


        $tmp_1 = Product::model()->getTax(array_merge($sbj, $sbj2, $sbj3, $sbj4), $type, $date, 'A');

        // B:服务
        $sbj = Subjects::model()->findAllByAttributes(['sbj_type' => 1], 'sbj_number like "6001%" and sbj_tax > 0 ' . $where);
        $sbj2 = Subjects::model()->findAllByAttributes(['sbj_type' => 3], 'sbj_number like "6001%" and sbj_tax > 0 ' . $where);

        $tmp_2 = Product::model()->getTax(array_merge($sbj, $sbj2), $type, $date, 'B');
        $data[1] = array_merge($tmp_1, $tmp_2);

        //（二）销售使用过的应税固定资产不含税销售额     栏次 4
        $sbj = Subjects::model()->findAllByAttributes([], 'sbj_name like "%固定资产%" and sbj_number like "6051%" and sbj_tax > 0' . $where);
        if (count($sbj) > 0)
            $tmp_1 = Product::model()->getTax($sbj, $type, $date, 'A');
        else {
            $tmp_1['A'] = 0;
            $tmp_1['C'] = 0;
        }
        $data[4] = $tmp_1;

        //（三）免税货物及劳务销售额     栏次6

        // A:货物
        $sbj = Subjects::model()->findAllByAttributes(['sbj_type' => 0, 'sbj_tax' => 0], 'sbj_name like "%材料销售%" and sbj_number like "6051%" ');
        $sbj2 = Subjects::model()->findAllByAttributes(['sbj_type' => 0, 'sbj_tax' => 0], 'sbj_number like "6001%" ');

        $tmp_1 = Product::model()->getTax(array_merge($sbj, $sbj2), $type, $date, 'A');

        // B:服务
        $sbj = Subjects::model()->findAllByAttributes(['sbj_type' => 1, 'sbj_tax' => 0], 'sbj_number like "6001%" ');

        $tmp_2 = Product::model()->getTax($sbj, $type, $date, 'B');
        $data[6] = array_merge($tmp_1, $tmp_2);

        //（四）出口免税货物销售额      栏次8
        // A:货物
        $sbj = Subjects::model()->findAllByAttributes(['sbj_type' => 2, 'sbj_tax' => 0], 'sbj_name like "%材料销售%" and sbj_number like "6051%" ');
        $sbj2 = Subjects::model()->findAllByAttributes(['sbj_type' => 2, 'sbj_tax' => 0], 'sbj_number like "6001%" ');

        $tmp_1 = Product::model()->getTax(array_merge($sbj, $sbj2), $type, $date, 'A');

        // B:服务
        $sbj = Subjects::model()->findAllByAttributes(['sbj_type' => 3, 'sbj_tax' => 0], 'sbj_number like "6001%" ');

        $tmp_2 = Product::model()->getTax($sbj, $type, $date, 'B');
        $data[8] = array_merge($tmp_1, $tmp_2);

        //本期应纳税额    栏次 10
        $data[10]['A'] = ($data[1]['A'] + $data[4]['A']) * 0.03; //小规模纳税人
        $data[10]['B'] = ($data[1]['B'] ) * 0.03;
        $data[10]['C'] = ($data[1]['C'] + $data[4]['C']) * 0.03;
        $data[10]['D'] = ($data[1]['D'] ) * 0.03;

        $data[12]['A'] = $data[10]['A'];
        $data[12]['B'] = $data[10]['A'];
        $data[12]['C'] = $data[10]['A'];
        $data[12]['D'] = $data[10]['A'];


        $data[14]['A'] = $data[10]['A'];
        $data[14]['B'] = $data[10]['A'];
        $data[14]['C'] = $data[10]['A'];
        $data[14]['D'] = $data[10]['A'];

        return $data;
    }

    protected function getTax($sbj, $type, $date, $option = 'A')
    {
        $amount = 0;
        if ($option == 'A') {
            $data['A'] = 0;
            $data['C'] = 0;
        } else {
            $data['B'] = 0;
            $data['D'] = 0;
        }
        if (!is_array($sbj))
            $sbj[] = $sbj;
        $where = '1=1';
        $date = isset($date) ? $date : Transition::getCondomDate();
        if (count($sbj) > 0) {
            foreach ($sbj as $item) {
                $where .= $where == '1=1' ? " and (subject = '$item->sbj_number'" : " or subject = '$item->sbj_number'";
            }
            $where .= ')';
            $where_year = $where . " and entry_date >= '" . substr($date, 0, 4) . "0101'" . " and entry_date < '" . substr($date, 0, 4) . "1232'";
            if (!isset($type) || $type == 'month')    //按月查看
            {
                $where .= " and entry_date >= '" . substr($date, 0, 6) . "01'" . " and entry_date < '" . substr($date, 0, 6) . "32'";
            } elseif ($type == 'quarter')     //按季度查看
            {
                $quarter = getQuarter($date);
                $where .= " and entry_date >= '" . $quarter['start'] . "' and entry_date <= '" . $quarter['end'] . "'";
            }

            $products = Product::model()->findAllByAttributes([], $where);
            if (count($products)) {
                foreach ($products as $product) {
                    $amount += $product->price * $product->count;
                }
            }
            if ($option == 'A')
                $data['A'] = $amount;
            else
                $data['B'] = $amount;
            //本年累计 货物
            $amount = 0;

            $products = Product::model()->findAllByAttributes([], $where_year);
            if (count($products)) {
                foreach ($products as $product) {
                    $amount += $product->price * $product->count;
                }
            }

            if ($option == 'A')
                $data['C'] = $amount;
            else
                $data['D'] = $amount;
        }
        return $data;
    }
}

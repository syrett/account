<?php

/**
 * This is the model class for table "client".
 *
 * The followings are the available columns in table 'client':
 * @property integer $id
 * @property string $company
 * @property string $vat
 * @property string $phone
 * @property string $add
 * @property string $memo
 */
class Client extends CActiveRecord
{
    public $select; // search的时候，定义返回字段

    public static $ageZone = [
        '全部',
        '0-30天',    //$fDate date('Ymd',time()-3600*24*30)
        '30-90天',   //$fDate = date('Ymd',time()-3600*24*90), $tDate = date('Ymd',time()-3600*24*30)
        '90-180天',
        '180-365天',
        '1-2年',
        '2-5天',
        '5年以上',
    ];

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'client';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('company', 'required'),
            array('company', 'unique', 'message' => '公司名称不可重复'),
            array('company', 'filter', 'filter' => 'trim'),
            array('id', 'numerical', 'integerOnly' => true),
            array('company', 'length', 'max' => 100),
            array('vat', 'length', 'max' => 45),
            array('phone', 'length', 'max' => 20),
            array('add', 'length', 'max' => 100),
            array('memo', 'length', 'max' => 200),
            // The following rule is used by search().

            array('id, vat, phone, add, memo', 'safe', 'on' => 'search'),
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
            'company' => YII::t('models/model', '公司名'),
            'vat' =>  YII::t('models/model', '税号'),
            'phone' =>  YII::t('models/model', '联系电话'),
            'add' =>  YII::t('models/model', '公司地址'),
            'memo' =>  YII::t('models/model', '备注'),
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
        $criteria->compare('company', $this->company, true);
        $criteria->compare('vat', $this->vat, true);
        $criteria->compare('phone', $this->phone, true);
        $criteria->compare('add', $this->add, true);
        $criteria->compare('memo', $this->memo, true);
        if ($this->select != null)
            $criteria->select = $this->select;

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Client the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function list_clients()
    {
        $sql = "SELECT id,company FROM client where 1";
        $data = self::model()->findAllBySql($sql);
        foreach ($data as $row) {
            $arr[] = array("id" => $row["id"],
                "company" => $row["company"]);
        }
        return $arr;
    }

    public function getAllMount($options, $add = '')
    {
        $result = 0;
        $sbj1 = Subjects::model()->findByAttributes(['sbj_name' => $this->company], 'sbj_number like "1122%"');
        $sbj2 = Subjects::model()->findByAttributes(['sbj_name' => $this->company], 'sbj_number like "2203%"');
        foreach ([$sbj1, $sbj2] as $sbj) {
            $sbj = $sbj ? $sbj->sbj_number : '';
            if (isset($options['type']) && $options['type'] == 'before') {
                $balance = Subjects::get_balance($sbj);
                $in = Transition::model()->getAllMount($sbj, 1, $options['type'], $options['date']);
                $out = Transition::model()->getAllMount($sbj, 2, $options['type'], $options['date']);
                $result += $balance + $in - $out;
            } else
                $result += Transition::model()->getAllMount($sbj, $options['entry_transaction'], 'after', '');

        }
        return $result;
    }

    //未收到
    public function getUnreceived()
    {
        $a = $this->getAllMount(["type" => "before", "date" => date("Y") . "-01-01 00:00:00"]);
        $b = $this->getAllMount(["entry_transaction" => 1]);
        $c = $this->getAllMount(["entry_transaction" => 2]);
        $result = $a + $b - $c;
        return $result;
    }

    public function getClientArray()
    {
        $data = self::model()->findAll();
        $arr = [];
        foreach ($data as $row) {
            $arr[$row['id']] = $row["company"];
        }
        return $arr;
    }

    public function matchName($company)
    {
        $model = $this->findByAttributes([], ['condition' => 'company like "%' . $company . '%"']);
        if ($model != null)
            return $model->id;
        else
            return 0;
    }

    /*
     *
     */
    public static function getClient($name)
    {
        $clients = Client::model()->findAllByAttributes([], "company like '%$name%'");
        if (!$clients)
            $clients = Client::model()->findAll();
        foreach ($clients as $key => $item) {
//            $tran = Product::model()->findByAttributes(['client_id'=>$item['id']]);
//            if($tran)
            $result[$item['company']] = $item['company'];
        }
        return $result;
    }

    public static function listOrders($name)
    {
        $client = Client::model()->findByAttributes(['company' => $name]);
        $orders = Product::model()->findAllByAttributes(['client_id' => $client['id']]);
        //检查订单是否已经支付完成
        foreach ($orders as $item) {
            if (!$item->checkPaid())
                $result[] = $item;
        }

        //添加一个预收的预收订单
        $sbj2 = Subjects::matchSubject($name, ['2203']);
        $result[] = ['subject_2' => $sbj2, 'order_no' => '预收款'];
        return $result;
    }

    /*
     * 是否有坏账
     */
    public function hasDad()
    {
        $tran = Transition::model()->findByAttributes(['data_type' => 'bad_debts', 'data_id' => $this->id, 'entry_closing' => 0]);
        return $tran ? true : false;
    }

    /*
     * 财务明细
     * @fdate String 起始日期
     * @tdate String 截至日期
     * @return Array Transition
     */
    public function getDetail($fDate = '', $tDate = '')
    {
        $trans = [];
        if ($fDate == '') {
            $fDate = Transition::getCondomDate();
            $fDate = substr($fDate, 0, 4) . '0101';
        }
        $fDate = convertDate($fDate, 'Y-m-d H:i:s');
        $tDate = $tDate == '' ? '9999-12-31 23:59:59' : convertDate($tDate, 'Y-m-d H:i:s');
        $sbj1 = Subjects::model()->findByAttributes(['sbj_name' => $this->company], 'sbj_number like "1122%"');
        $sbj2 = Subjects::model()->findByAttributes(['sbj_name' => $this->company], 'sbj_number like "2203%"');
        foreach ([$sbj1, $sbj2] as $sbj) {
            $where = " entry_date >= '$fDate' and entry_date <= '$tDate'";  // and data_type is null";
            if ($sbj != null)
                $trans += Transition::model()->findAllByAttributes(['entry_subject' => $sbj->sbj_number, 'entry_settlement' => 0], $where);
        }
        return $trans;
    }

    public function getAge()
    {
        $data = $this->getClientAge();
        if ($data['amount'] > 0)
            return convertDate($data['ageDate'], 'Y-m');
        else
            return '';
    }

    /*
     * 账龄
     */
    public function getClientAge()
    {
        $amount = 0;
        $ageDate = Condom::getStartTime();
        //对应科目,应收和预收都要算
        $sbjs = ['1122', '2203'];
        foreach ($sbjs as $sbjp) {
            $sbj = Subjects::model()->findByAttributes(['sbj_name' => $this->company], "sbj_number like '$sbjp%'");
            if ($sbj) {
                $trans = Transition::model()->findAllByAttributes(['entry_subject' => $sbj->sbj_number]);
                if (count($trans) > 0) {
                    foreach ($trans as $tran) {
                        //如果应收为借方，金额直接累加，如果应收为贷方，表示收到钱，金额减少，
                        if ($tran->entry_transaction == 1) {
                            $ageDate = $amount == 0 ? convertDate($tran->entry_date, 'Ym') : $ageDate;
                            $amount += $tran->entry_amount;
                        } else {
                            if ($amount <= $tran->entry_amount)
                                $ageDate = convertDate($tran->entry_date, 'Ym');
                            $amount -= $tran->entry_amount;

                        }
                    }
                }
            }

        }
        return ['amount' => $amount, 'ageDate' => $ageDate];
    }
}

<?php

/**
 * This is the model class for table "client".
 *
 * The followings are the available columns in table 'client':
 * @property integer $id
 * @property string $vat
 * @property string $phone
 * @property string $add
 * @property string $memo
 */
class Client extends CActiveRecord
{
  public $select; // search的时候，定义返回字段

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
            array('company', 'unique', 'message'=>'公司名称不可重复'),
			array('id', 'numerical', 'integerOnly'=>true),
			array('company', 'length', 'max'=>100),
			array('vat', 'length', 'max'=>45),
			array('phone', 'length', 'max'=>20),
			array('add', 'length', 'max'=>100),
			array('memo', 'length', 'max'=>200),
			// The following rule is used by search().

			array('id, vat, phone, add, memo', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'company' => '公司名',
			'vat' => '税号',
			'phone' => '联系电话',
			'add' => '公司地址',
			'memo' => '备注',
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
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('company',$this->company);
		$criteria->compare('vat',$this->vat,true);
		$criteria->compare('phone',$this->phone,true);
		$criteria->compare('add',$this->add,true);
		$criteria->compare('memo',$this->memo,true);
        if ($this->select != null)
          $criteria->select=$this->select;

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Client the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    public function list_clients()
    {
      $sql = "SELECT id,company FROM client where 1";
      $data = self::model()->findAllBySql($sql);
      foreach($data as $row){
        $arr[] = array("id"=>$row["id"],
                       "company"=>$row["company"]);
      }
      return $arr;
    }

    public function getAllMount($options){
        $result = 0;
        $sbj = '1122';
        $model = Subjects::model()->findByAttributes(['sbj_name'=>$this->company], 'sbj_number like "1122%"');
        if($model==null)
            $model = Subjects::model()->findByAttributes([],"sbj_name like '%$this->company%' and sbj_number like '1122%'");
        if($model!=null)
            $sbj = $model->sbj_number;
        if(isset($options['type'])&&$options['type']=='before'){
            $balance = Subjects::get_balance($sbj);
            $in = Transition::model()->getAllMount($sbj, 1, $options['type'], $options['date']);
            $out = Transition::model()->getAllMount($sbj, 2, $options['type'], $options['date']);
            $result = $balance + $in-$out;
        }else
            $result = Transition::model()->getAllMount($sbj, $options['entry_transaction'], 'after', '');
        return $result;
    }

    public function getClientArray(){
        $data = self::model()->findAll();
        $arr = [];
        foreach($data as $row){
            $arr[$row['id']] = $row["company"];
        }
        return $arr;
    }
    public function matchName($company){
        $model = $this->findByAttributes([],['condition'=>'company like "%'.$company.'%"']);
        if($model!=null)
            return $model->id;
        else
            return 0;
    }
}

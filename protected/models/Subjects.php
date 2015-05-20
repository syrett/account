<?php

/**
 * This is the model class for table "subjects".
 *
 * The followings are the available columns in table 'subjects':
 * @property integer $id
 * @property integer $sbj_number
 * @property string $sbj_name
 * @property string $sbj_cat
 * @property string $sbj_table
 * @property string $has_sub
 */
class Subjects extends CActiveRecord
{

    public $select; // search的时候，定义返回字段

    public function listunposted($year, $month)
    {
        $subjects = new CDbCriteria;
        $subjects->select = "subjects.sbj_number, subjects.sbj_name";
        //      $subjects->join="JOIN post on subjects.sbj_number=post.subject_id";
        $subjects->condition = "post.id is null or post.posted=0 and post.year=" . $year . " and post.month=" . $month;
        $subjects->with = array('post');

        //      return $subjects;
        //      $d=Subjects::model()->with('post')->findAll($subjects);
        //      return $d;
        return new CActiveDataProvider($this, array(
            'criteria' => $subjects,
        ));
        //      $sql="select * from subjects left join(post) on (subjects.sbj_number=post.subject_id) where  post.id is null or post.posted=0 and post.year=2013 and post.month=12";
    }

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'subjects';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('sbj_number, sbj_name, sbj_cat', 'required', 'message' => '{attribute}不能为空'),
            array('sbj_number', 'unique', 'message' => '{attribute}:{value} 已经存在!'),
            array('sbj_number', 'numerical', 'integerOnly' => true),
            array('sbj_name', 'length', 'max' => 20),
            array('sbj_cat', 'length', 'max' => 1),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, sbj_number, sbj_name, sbj_cat, sbj_table, has_sub', 'safe', 'on' => 'search'),
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
            'post' => array(self::HAS_MANY, 'Post', 'subject_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'sbj_number' => '科目编号',
            'sbj_name' => '科目名称',
            'sbj_cat' => '科目类别',
            'sbj_table' => '报表名称',
            'sbj_balance' => '科目余额',
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

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('sbj_number', $this->sbj_number, true);
        $criteria->compare('sbj_name', $this->sbj_name, true);
        $criteria->compare('sbj_cat', $this->sbj_cat, true);
        $criteria->compare('sbj_table', $this->sbj_table, true);
        $criteria->compare('has_sub', $this->has_sub, true);

        if ($this->select != null)
            $criteria->select = $this->select;
        $criteria->order = 'concat(sbj_number) ASC';
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array(
                'attributes' => array(  //设置中文拼音排序
                    'sbj_number' => array('asc' => 'convert(concat(t.sbj_number) using gbk)', 'desc' => 'convert(t.sbj_number using gbk) desc'),
                    'sbj_name' => array('asc' => 'convert(t.sbj_name using gbk)', 'desc' => 'convert(t.sbj_name using gbk) desc'),
                    'sbj_cat' => array('asc' => 'convert(t.sbj_cat using gbk)', 'desc' => 'convert(t.sbj_cat using gbk) desc'),
                    'sbj_table' => array('asc' => 'convert(t.sbj_table using gbk)', 'desc' => 'convert(t.sbj_table using gbk) desc'),
                )
            ),

        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Subjects the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /*
     * 科目表，与Controller中的函数重复，后期可优化
     * 返回结账所需科目
     */
    public static function actionListFirst($type = 1)
    {
        $where = "1=1";
        if ($type = 1)
            $where .= " and (sbj_cat=4 or sbj_cat=5)";
        //        $where .= " and sbj_number < 10000";
        $where .= " and has_sub=0";
        $sql = "select * from subjects where " . $where;
        $First = Subjects::model()->findAllBySql($sql);
        $arr = array();
        foreach ($First as $row) {
            array_push($arr, array('id' => $row['sbj_number'], 'name' => $row['sbj_name'], 'sbj_cat' => $row['sbj_cat']));
        };
        return $arr;
    }


    /**
     * 列出科目
     */
    public function listSubjects($sbj='')
    {
        if($sbj=='')
        $sql = "select * from subjects order by concat(`sbj_number`) asc"; //
        else
            $sql = "select * from subjects where sbj_number like '$sbj%' order by concat(`sbj_number`) asc";
        $First = Subjects::model()->findAllBySql($sql);
        $arr = array();
        foreach ($First as $row) {
            $arr += array($row['sbj_number'] => $row['sbj_number'] . Subjects::getSbjPath($row['sbj_number']));
        };
        return $arr;
    }

    public static function hasSub($sbj_id)
    {
        $par_id = substr($sbj_id, 0, -2);
        $sql = "update subjects set has_sub = 1 where sbj_number = :par_id";
        Yii::app()->db->createCommand($sql)->bindParam('par_id', $par_id)->execute();
    }


    /*
     * 得到科目的所属类别:
     * 1:资产类; 2:负债类; 3:权益类; 4:收入类; 5:费用类
     */
    public function getCat($sbj_id)
    {
        $sql = "SELECT sbj_cat FROM subjects WHERE sbj_number=:sbj_id";
        $data = Subjects::model()->findBySql($sql, array(':sbj_id' => $sbj_id));
        foreach ($data as $s) {
            return $s;
        }
    }

    /*
     * 科目表路径
     */
    public static function getSbjPath($id)
    {
        $path = "";
        $path .= Subjects::getName(substr($id,0,4));
        $length = strlen($id);
        $i = 6;
        while($i <= $length){
            $path .= '/'.Subjects::getName(substr($id,0,$i));
            $i = $i + 2;
        }
        return $path;
    }

    /*
     * 得到科目的名称:
     */
    static public function getName($sbj_id)
    {
        $sql = "SELECT sbj_name FROM subjects WHERE sbj_number=:sbj_id";
        $data = Subjects::model()->findBySql($sql, array(':sbj_id' => $sbj_id));
        if ($data)
            foreach ($data as $s) {
                return $s;
            }
        return '不存在的科目编号';
    }

    public function list_can_set_balnce_sbj()
    {
        $data = array();
        //取出1级科目
        $sql_1 = "SELECT * FROM subjects where sbj_cat in (1,2,3) AND sbj_number<10000 order by sbj_cat,sbj_number";
        $data_1 = Subjects::model()->findAllBySql($sql_1, array());

        foreach ($data_1 as $key => $item) {
            array_push($data, $item);
            if ($item["has_sub"] == 1) {
                $data_sub = $this->list_sub($item["sbj_number"]);
                foreach ($data_sub as $key => $item_sub) {
                    array_push($data, $item_sub);
                }

            }
        }

        //    $sql ="SELECT * FROM subjects where sbj_cat in (1,2,3) order by sbj_cat";
        //    $data = Subjects::model()->findAllBySql($sql, array());
        return $data;
    }

    /*
     * 列出子科目
     * @sbj_id Integer 科目编号
     * @key String 关键字
     * @options Array   参数，$rej=[], $level=2, $type=1
     */
    public function list_sub($sbj_id, $key = '', $options = [])
    {
        $level = isset($options['level']) ? $options['level'] : 2;
        $reject = isset($options['reject']) ? $options['reject'] : [];
        $data = array();
        $sbj_max = $sbj_id * 100 + 99;
        $rejSbj = '';
        foreach($reject as $item){  //去除包含需要剔除关键字的科目
            $rejSbj .= " And sbj_name not like '%$item%' ";
        }
        $sql_1 = "SELECT * FROM subjects where sbj_number REGEXP '^$sbj_id' ";
        if($level==1)
            $sql_1.= "AND sbj_number>='$sbj_id' ";
        else
            $sql_1.= "AND sbj_number>'$sbj_id' ";
        $sql_1 .= "AND sbj_number<='$sbj_max' AND sbj_name like '%".$key."%'";
        $sql_1 .= $rejSbj!=""?$rejSbj:"";
        $sql_1 .= " order by INSTR(sbj_name,'$key') desc";
        $data_1 = self::findAllBySql($sql_1, array());

        if (!empty($data_1))
            foreach ($data_1 as $key => $item) {
                array_push($data, $item->attributes);
                if ($item["has_sub"] == 1) {
                    $data_sub = $this->list_sub($item["sbj_number"], $key, $options);
                    foreach ($data_sub as $key => $item_sub) {
                        array_push($data, $item_sub->attributes);
                    }
                }
            }

        return $data;
    }

    public function set_start_balance($data)
    {
        //更新老的期初余额都为0
        $update_old = "update subjects set start_balance = 0";
        Yii::app()->db->createCommand($update_old)->execute();

        $start_date = Yii::app()->params['startDate'];
        $year = getYear($start_date);
        $month = getMon($start_date);
        $lastDate = date("Ym", strtotime("last month", mktime(0, 0, 0, $month, 01, $year)));
        $last_year = getYear($lastDate);
        $last_month = getMon($lastDate);

        Post::model()->balance_delete($last_year, $last_month);

        foreach ($data as $sbj_id => $start_balance) {
            $update_sql = "update subjects set start_balance = '$start_balance' where sbj_number = '$sbj_id'";
            Yii::app()->db->createCommand($update_sql)->execute();

            Post::model()->balance_set($sbj_id, $start_balance, $last_year, $last_month);
        }
    }

    //检测资产负债权益是否平
    //资产=负债+权益
    public function check_start_balance($data)
    {
        $cat_1 = 0;
        $cat_2 = 0;
        $cat_3 = 0;
        foreach ($data as $sbj_id => $start_balance) {
            $sbj_cat = $this->getCat($sbj_id);
            switch ($sbj_cat) {
                case 1:
                    $cat_1 += (100 * $start_balance);
                    break;
                case 2:
                    $cat_2 += (100 * $start_balance);
                    break;
                case 3:
                    $cat_3 += (100 * $start_balance);
                    break;
            }
        }

        $sum1 = $cat_1;
        $sum2 = $cat_2 + $cat_3;
        if ($sum1 == $sum2) {
            return true;
        } else {
            return false;
        }
    }


    /*
     * 没有子科目且未设置初始余额的才能设置期初余额,且会更新父科目的balance_set为1
     */
    public function balance_set($sbj_id, $balance)
    {
        echo $sbj_id;
        $sql = "SELECT balance_set, has_sub FROM subjects WHERE sbj_number=:sbj_id";

        $data = Subjects::model()->findBySql($sql, array(':sbj_id' => $sbj_id));

        $balance_set = $data["balance_set"];
        $has_sub = $data["has_sub"];
        $balance_set = 0;
        $has_sub = 0;
        if ($balance_set == 0 && $has_sub == 0) {
            //todo 设置期初余额
            var_dump($data);
            $i = strlen($sbj_id);
            if ($i > 4) {
                $this->balance_set_father($sbj_id);
            }

            $update_sql = "update subjects set balance_set = 1 where sbj_number = '$sbj_id'";
            Yii::app()->db->createCommand($update_sql)->execute();

            $year = 2014;
            $month = 9;
            return Post::model()->balance_set($sbj_id, $balance, $year, $month);

        }

    }

    public function balance_set_father($sbj_id)
    {
        $i = strlen($sbj_id);
        for ($i; $i > 4; $i -= 2) {
            $par_id = substr($sbj_id, 0, $i - 2);
            echo "lent:";
            echo $i;
            echo "dd:";
            echo $par_id;
            $update_sql = "update subjects set balance_set = 1 where sbj_number = '$par_id'";
            echo $update_sql;
            Yii::app()->db->createCommand($update_sql)->execute();
        }
    }

    public function init_new_sbj_number($sbj_nubmer, $type)
    {    //1为同级科目，2为子科目
        if (strlen($sbj_nubmer) == 4 && $type == 1) {   //一级科目不能创建同级科目
            return 0;
        } else {
            //select max(sbj_number) from subjects where sbj_number like '1123%'
            if ($type == 1) {
                $length = strlen($sbj_nubmer);
                $sbj_nubmer = substr($sbj_nubmer, 0, -2);
            } else
                $length = strlen($sbj_nubmer) + 2;


            $sql = "select max(sbj_number) as sbj_number, sbj_cat from subjects where `sbj_number` like :sbj_number and length(`sbj_number`)=:length";

            $number = Yii::app()->db
                ->createCommand($sql)
                ->bindValues(array(':sbj_number' => $sbj_nubmer . '%', ':length' => $length))
                ->queryRow();

            if ($number['sbj_number'] != null)
                return [(int)$number['sbj_number'] + 1, $number['sbj_cat']];
            else{

                $subj = self::findByAttributes(['sbj_number'=>$sbj_nubmer]);
                return [$sbj_nubmer . '01', $subj->sbj_cat];
            }
        }
    }

    /*
     * @arr Array 科目列表
     * @key String  关键字
     * @options Array   参数，$rej=[], $level=2, $type=1
     *
     * @return Array
     */
    public function getitem($arr, $key = '', $options = [])
    {
        $subject = new Subjects();
        $result = [];
        $type = isset($options['type']) ? $options['type'] : 1;
        foreach ($arr as $item) {
            $arr_subj = $subject->list_sub($item, $key, $options);
            foreach ($arr_subj as $subj) {
                if($type==0){
                    $result['_'. $subj['sbj_number']] = $subj['sbj_name'];
                }else
                    $result['_' . $subj['sbj_number']]=Subjects::getSbjPath($subj['sbj_number']);
            }
        }
        if(empty($result))
            foreach ($arr as $item) {
                $arr_subj = $subject->list_sub($item, '', $options);
                foreach ($arr_subj as $subj) {
                    if($type==0){
                        $result['_'. $subj['sbj_number']] = $subj['sbj_name'];
                    }else
                        $result['_' . $subj['sbj_number']]=Subjects::getSbjPath($subj['sbj_number']);
                }
            }
        return $result;
    }
    /*
     * 根据关键字匹配科目表
     * @key Integer 关键字
     * @subject Array   科目编号数组
     * @level Integer 层数，0代表科目编号下所有子科目，1代表当前科目编号的子科目，子科目的子科目不包含
     */
    public static function matchSubject($key, $subjects, $level = 0)
    {
        //似乎应该完成匹配
        $data = Yii::app()->db->createCommand("select * from ". self::model()->tableSchema->name. " where sbj_name like '%$key%'")->queryAll();
        $sbj = 0;
        $percent = 100;
        foreach ($data as $item) {
            $per = levenshtein($key, $item['sbj_name']);
            if ($percent > $per && in_array(substr($item['sbj_number'], 0, 4), $subjects)) {
                if ($level != 0 && strlen($item['sbj_number']) <= (4 + $level * 2)) {
                    $sbj = $item['sbj_number'];
                    $percent = $per;
                }
            }
        }
        if ($sbj == 0)
            $sbj = Subjects::createSubject($key, $subjects[0]);
        return $sbj;
    }

    /*
     * 如果没有就新建科目
     */
    public static function createSubject($key, $sbj)
    {
        $model = new Subjects();
        $check = self::checkSbj($sbj, trim($key));
        if ($check != 0) {
            return $check;
        }
        $subj = $model->model()->init_new_sbj_number($sbj, 2);
        $model->sbj_number = $subj[0];
        $model->sbj_name = $key;
        $model->sbj_cat = $subj[1];

        if ($model->save()) {
            //如果是新的子科目，将post中科目表id修改为新id
            if (strlen($subj[0]) > 4 && substr($subj[0], -2) == '01')  ////1为同级科目，2为子科目
            {
                Post::tranPost($subj[0]);
                self::hasSub($subj[0]);
            }
            return $model->sbj_number;
        } else {
            throw new HttpException(400);
        }
    }

    /*
     * 创建科目时，检测子科目下是否已经存在该科目
     */
    public static function checkSbj($key, $name)
    {
        $sbj_max = $key * 100 + 99;
        $sql = "SELECT sbj_number FROM subjects where sbj_number REGEXP '^$key' AND sbj_number>'$key' AND sbj_number<='$sbj_max' AND sbj_name='$name'";
        $model = self::model()->findBySql($sql);
        if ($model != null)
            return $model->sbj_number;
        else
            return 0;
    }
}

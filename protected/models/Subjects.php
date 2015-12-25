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
            array('sbj_number, sbj_name', 'required', 'message' => '{attribute}不能为空'),
            array('sbj_number', 'unique', 'message' => '{attribute}:{value} 已经存在!'),
            array('start_balance', 'numerical'),
            array('sbj_number', 'numerical', 'integerOnly' => true),
            array('sbj_name', 'length', 'max' => 20),
            array('sbj_cat', 'length', 'max' => 1),
            // The following rule is used by search().
            array('id, sbj_number, sbj_name, sbj_cat, sbj_table, has_sub', 'safe', 'on' => 'search'),

            array('sbj_name', 'checkSbjName', 'on' => 'create,update'),
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
    public function listSubjects($sbj = '')
    {
        if ($sbj == '')
            $sql = "select * from subjects order by concat(`sbj_number`) asc"; //
        else
            $sql = "select * from subjects where sbj_number like '$sbj%' and sbj_number <> '$sbj' order by concat(`sbj_number`) asc";
        $First = Subjects::model()->findAllBySql($sql);
        if (!$First) {
            $sql = "select * from subjects where sbj_number = '$sbj' ";
            $First = Subjects::model()->findAllBySql($sql);
        }
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

    public static function noSub($sbj)
    {
        $par_id = substr($sbj, 0, -2);
        $sql = "update subjects set has_sub = 0 where sbj_number = :par_id";
        Yii::app()->db->createCommand($sql)->bindParam('par_id', $par_id)->execute();
    }

    public function tranBalance($sbj)
    {
        $model = $this->findByAttributes(['sbj_number' => $sbj]);
        $parent = $this->findByAttributes(['sbj_number' => substr($sbj, 0, -2)]);
        $parent->start_balance = $model->start_balance;
        $parent->save();
    }

    /*
     * 得到科目的所属类别:
     * 1:资产类; 2:负债类; 3:权益类; 4:收入类; 5:费用类
     */
    public function getCat($sbj_id)
    {
        $sql = "SELECT sbj_cat FROM subjects WHERE sbj_number=:sbj_id";
        $data = Subjects::model()->findBySql($sql, array(':sbj_id' => $sbj_id));
        if ($data)
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
        $path .= Subjects::getName(substr($id, 0, 4));
        $length = strlen($id);
        $i = 6;
        while ($i <= $length) {
            $path .= '/' . Subjects::getName(substr($id, 0, $i));
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
     * @options Array   参数，$rej=[], $level=2, $level=0 无匹配返回原科目 $type=1 无匹配返回所有 $type=2 无匹配返回父科目
     * @return Array 子科目数组
     */
    public function list_sub($sbj_id, $key = '', $options = [])
    {
        $level = isset($options['level']) ? $options['level'] : 2;
        $type = isset($options['type']) ? $options['type'] : 1;
        $reject = isset($options['reject']) ? $options['reject'] : [];
        $data = array();
        $sbj_max = $sbj_id * 100 + 99;
        $rejSbj = '';
        foreach ($reject as $item) {  //去除包含需要剔除关键字的科目
            $rejSbj .= " And sbj_name not like '%$item%' ";
        }
        $sql_1 = "SELECT * FROM subjects";
        $where = " where 1=1 and sbj_number REGEXP '^$sbj_id' ";
        if ($level == 0)
            $sbjwhere = " AND sbj_number='$sbj_id' ";
        elseif ($level == 1)
            $sbjwhere = " AND sbj_number>='$sbj_id' ";
        else
            $sbjwhere = " AND sbj_number>'$sbj_id' ";
        $where .= " AND sbj_number<='$sbj_max'";
        $where .= $rejSbj != "" ? $rejSbj : "";
        $keywhere = " AND sbj_name like '%" . $key . "%'";
        $orderby = " order by INSTR(sbj_name,'$key') desc";
        $data_1 = self::findAllBySql($sql_1 . $where . $sbjwhere . $keywhere . $orderby, array());
        if (empty($data_1) && $type == 1) {
            $data_1 = self::findAllBySql($sql_1 . $where . $sbjwhere . $orderby, array());
            if (empty($data_1)) {
                $sbjwhere = " AND sbj_number='$sbj_id'";
                $data_1 = self::findAllBySql($sql_1 . $where . $sbjwhere . $orderby, array());
            }
        }
//        if (empty($data_1) && $type==2){
//            $sbjwhere = "AND sbj_number='$sbj_id' ";
//            $data_1 = self::findAllBySql($sql_1. $where. $sbjwhere. $keywhere. $orderby, array());
        //去除关键字，仍然为空，返回空数组；
        if (empty($data_1)) {
            return [];
        } elseif ($data_1[0]->sbj_number == $sbj_id && $data_1[0]["has_sub"] == 1) {
            return [];
        }
        foreach ($data_1 as $key => $item) {
            array_push($data, $item->attributes);
//            if ($item["has_sub"] == 1 && isset($GLOBALS['level']) && $GLOBALS['level']>0) {
            if ($item["has_sub"] == 1) {
                $data_sub = $this->list_sub($item["sbj_number"], $key, $options);
                foreach ($data_sub as $key => $item_sub) {
                    array_push($data, $item_sub);
                }
//                $GLOBALS['level'] -= 1;
            }
        }

        return $data;
    }

    public function set_start_balance($data)
    {
        //更新老的期初余额都为0
        $update_old = "update subjects set start_balance = 0";
        Yii::app()->db->createCommand($update_old)->execute();

        $start_date = Condom::model()->getStartTime();
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
            if ($start_balance != 0)
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

        $sum1 = (string)$cat_1;
        $sum2 = (string)($cat_2 + $cat_3);
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
            else {

                $subj = self::findByAttributes(['sbj_number' => $sbj_nubmer]);
                return [$sbj_nubmer . '01', $subj->sbj_cat];
            }
        }
    }

    /*
     * @arr Array 科目列表
     * @key String  关键字
     * @options Array   参数，$rej=[], $level=2, $type=1无匹配不返回 $type=2无匹配子科目则返回父科目
     *
     * @return Array
     */
    public function getitem($arr, $key = '', $options = [])
    {
        //有前缀，顺序不会随科目编号影响，在前台需要去除第一个字符"_"，如果没有前缀，json数据会自动重新排序
        $prefix = isset($options['prefix']) ? $options['prefix'] : '_';
        $subject = new Subjects();
        $result = [];
        $type = isset($options['type']) ? $options['type'] : 2;
        foreach ($arr as $item) {
            $arr_subj = $subject->list_sub($item, $key, $options);
            foreach ($arr_subj as $subj) {
                if ($type == 0) {
                    $result[$prefix . $subj['sbj_number']] = $subj['sbj_name'];
                } else
                    $result[$prefix . $subj['sbj_number']] = Subjects::getSbjPath($subj['sbj_number']);
            }
        }
        if ($type == 1 && empty($result))
            foreach ($arr as $item) {
                $arr_subj = $subject->list_sub($item, '', $options);
                foreach ($arr_subj as $subj) {
                    if ($type == 0) {
                        $result[$prefix . $subj['sbj_number']] = $subj['sbj_name'];
                    } else
                        $result[$prefix . $subj['sbj_number']] = Subjects::getSbjPath($subj['sbj_number']);
                }
            }
        return $result;
    }

    /*
     * 根据关键字匹配科目表
     * @key Integer 关键字
     * @subject Array   科目编号数组
     * @level Integer 层数，0代表科目编号下所有子科目，1代表当前科目编号的子科目，子科目的子科目不包含
     * @option Integer 如果没有则自动添加，此时的subjects必须为单一数组
     */
    public static function matchSubject($key, $subjects, $level = 0, $option = 1, $return = 'str')
    {
        if (!is_array($subjects))
            $subjects = [$subjects];
        if (empty($subjects)) {
            $all = Yii::app()->db->createCommand("select sbj_number from " . self::model()->tableSchema->name . " where length(sbj_number) < 5 ")->queryAll();
            foreach ($all as $item) {
                $subjects[] = $item['sbj_number'];
            }
        }
        //似乎应该完成匹配
        $data = Yii::app()->db->createCommand("select * from " . self::model()->tableSchema->name . " where sbj_name like '%$key%'")->queryAll();
        if ($return == 'str')
            $sbj = 0;
        else
            $sbj = [];
        $percent = 100;
        foreach ($data as $item) {
            $per = levenshtein($key, $item['sbj_name']);
            if ($percent > $per && in_array(substr($item['sbj_number'], 0, 4), $subjects)) {
                if ($level != 0 && strlen($item['sbj_number']) <= (4 + $level * 2)) {
                    $sbj += $item['sbj_number'];
                    $percent = $per;
                }
            }
        }
        if (($sbj == 0 || empty($sbj)) && $option == 1)
            $sbj = Subjects::createSubject($key, $subjects[0]);
        return $sbj;
    }

    /*
     * 查询匹配科目
     */
    public static function findSubject($key, $sbj, $force = false)
    {
        $list = [];
        $result = [];
        if (is_array($sbj)) {
            $list = $sbj;
        } else
            $list[] = $sbj;
        if (!empty($list))
            foreach ($sbj as $item) {
                if (!$force) {
                    $a = Subjects::model()->find([
                        'condition' => 'sbj_name like :key and sbj_number like :sbj',
                        'params' => [':key' => $key . '%', ':sbj' => $item . '%']]);

                    $result[] = $a;
                } else
                    $result[] = Subjects::model()->findByAttributes(['sbj_name' => $key], 'sbj_number like ":sbj%"');
            }
        return array_values(array_filter($result));
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
        $psbj = Subjects::model()->findByAttributes(['sbj_number' => substr($subj[0], 0, -2)]);
        $model->start_balance = $psbj['start_balance'];
        $model->sbj_number = $subj[0];
        $model->sbj_name = $key;
        $model->sbj_cat = $subj[1];

        if ($model->save()) {
            $psbj['start_balance'] = 0;
            $psbj->save();
            //如果是新的子科目，
            //将post中科目表id修改为新id;
            //把期初余额过度到新科目;
            //stock transition entry_subject 过度
            //cost product purchase salary 过度
            if (strlen($subj[0]) > 4 && substr($subj[0], -2) == '01') //长度大于4，最后2度是01，则判断是第一次新建子科目
            {
                $arr = ['stock' => 'entry_subject', 'transition' => 'entry_subject', 'cost' => 'subject', 'product' => 'subject', 'purchase' => 'subject', 'salary' => 'subject'];
                foreach ($arr as $table => $item) {
                    $sql = "update $table set $item = :sbj_id where $item = :par_id";
                    Yii::app()->db->createCommand($sql)->bindValues(array(':sbj_id' => $model->sbj_number, ':par_id' => $psbj->sbj_number))->execute();
                }
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

    /*
     * 科目类别
     */
    public static function getCatName($cat)
    {
        $name = '';
        switch ($cat) {
            case 1:
                $name = '资产类';
                break;
            case 2:
                $name = '负债类';
                break;
            case 3:
                $name = '权益类';
                break;
            case 4:
                $name = '收入类';
                break;
            case 5:
                $name = '费用类';
                break;
        }
        return $name;
    }

    /*
     * 自定义验证规则
     */
    public function checkSbjName($attribute, $params)
    {
        $model = $this->findByPk($this->id);
        if ($this->sbj_name != $model->sbj_name) {
            $sbj_name = $_POST['Subjects']['sbj_name'];
            $sbj_number = $_POST['Subjects']['sbj_number'];
            $sbj_num = strlen($sbj_number) > 4 ? substr($sbj_number, 0, 4) : $sbj_number;
            $criteria = new CDbCriteria;
            $criteria->addCondition('sbj_name=:sbj_name');
            $criteria->addCondition('sbj_number like :sbj_num');
            $criteria->params = ['sbj_name' => $sbj_name, 'sbj_num' => $sbj_num . '%'];
            $sub = Subjects::model()->find($criteria);
            if ($sub != null && $sub->sbj_number != $sbj_number)
                $this->addError($attribute, '科目名已经存在');
        }

    }

    /*
     * 科目下是否有凭证
     */
    public static function hasTransition($sbj)
    {
        $criteria = new CDbCriteria;
        $criteria->compare('entry_subject', $sbj, true);
        $tran = Transition::model()->find($criteria);
        if (empty($tran))
            return false;
        else
            return true;
    }

    /*
     * @sbj Integer 科目编号
     * 有兄弟科目
     */
    public static function hasBrother($sbj)
    {
        if (strlen($sbj) <= 4)
            return false;
        $psbj = substr($sbj, 0, -2);
        $criteria = new CDbCriteria;
        $criteria->addCondition('sbj_number != :sbj_number');
        $criteria->params[':sbj_number'] = $sbj;

        $criteria->addCondition('sbj_number like :psbj');
        $criteria->params[':psbj'] = "$psbj%";
        $criteria->addCondition('length(sbj_number) > ' . strlen($psbj));

        $sub = Subjects::model()->find($criteria);
        if (empty($sub))
            return false;
        else
            return true;
    }

    /*
     * 获取期初余额
     *
     * @sbj Integer 科目编号
     * @return Float 科目编号所有子科目下的期初余额总和
     */
    public static function get_balance($sbj)
    {
        $result = 0;
        if ($sbj) {
            if ($sbj == '1601') {    //1601为长期资产，包括固定资产1601，无形资产1701，长期待摊1801，在建工程1604
                $arr = ['1601', '1701', '1801', '1604'];
            } else
                $arr = [$sbj];
            foreach ($arr as $item) {
                $item = Subjects::model()->findByAttributes(['sbj_number' => $item]);
                $result += $item->start_balance;
                if ($item->has_sub) {
                    $subs = Subjects::model()->get_sub($item->sbj_number);
                    foreach ($subs as $sub) {
                        $result += $sub->start_balance;
                    }
                }

            }
        }
        return $result;
    }

    /*
     * 获取科目编号下的，所有子科目
     *
     * @sbj Integer 科目编号
     * @type Integer 是否包含$sbj参数科目
     * @return Array 所有子科目
     */
    public function get_sub($sbj, $type = 1)
    {
        if ($sbj == '')
            return [];
        $model = $this->findByAttributes(['sbj_number' => $sbj]);
        if ($model == null || $model->has_sub == 0)
            return [$model->attributes];
        $table = $this->tableName();
        $sql = "select * from $table where sbj_number like '$sbj%'";
        $sql .= $type == 1 ? "and sbj_number <> '$sbj'" : "";
        $subs = $this->findAllBySql($sql);
        return $subs;
    }

    /*
     * 修改科目表名称，如果客户或供应商名字同一级科目相同，暂时不考虑。比如客户名字叫 银行存款，这时候修改名字会将一级科目 银行存款 的名称也改掉
     * @oldname String 原名称
     * @name String 新名称
     * @sbj Integer 科目编号
     */
    public function updateName($oldname, $name, $sbj = '')
    {
        $params = ['name' => $oldname];
        $where = '';
        if ($sbj != '') {
            $where = " and sbj_number like ':sbj%' ";
            $params += ['sbj' => $sbj];
        }
        $this->updateAll(['sbj_name' => $name], "sbj_name=:name and length(sbj_number) > 4 $where", $params);
    }

    /*
     * 报表获取数据
     */
    public function getReport($sbj, $date)
    {

        $balance = Subjects::get_balance($sbj);
        $unreceived = Transition::getAllMount($sbj, 1, '', $date);
        $unreceived2 = Transition::getAllMount($sbj, 1, 'before', $date);
//        $year = Transition::getAllMount($sbj, 1, 'after', date('Y0101'));

        $received = Transition::getAllMount($sbj, 2, '', $date);
        $received2 = Transition::getAllMount($sbj, 2, 'before', $date);

        $before = $balance + $unreceived2 - $received2;
        $left = $before + $unreceived - $received;
        $result['before'] = $before;
        $result['left'] = $left;
        $result['received'] = $received;
        $result['unreceived'] = $unreceived;
        return $result;
    }
}

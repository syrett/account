<?php

namespace laofashi\transition\models;

use laofashi\transition\components\AccountRecord;
use yii\behaviors\TimestampBehavior;
use yii\data\ActiveDataProvider;
use yii;
use yii\db;

/**
 * Class Bank
 * @package vova07\bank\models
 * bank model.
 *
 * @property integer $id ID
 * @property string $title Title
 * @property string $alias Alias
 * @property string $snippet Intro text
 * @property string $content Content
 * @property integer $views Views
 * @property integer $status_id Status
 * @property integer $created_at Created time
 * @property integer $updated_at Updated time
 */
class Subject extends AccountRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%subjects}}';
    }


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // Required
//            array('entry_num, entry_transaction, entry_subject, entry_amount,entry_creater, entry_editor, entry_reviewer', 'required'),
//            array('entry_num, entry_transaction, entry_subject,entry_creater, entry_editor, entry_reviewer, entry_deleted, entry_reviewed, entry_posting, entry_closing', 'numerical', 'integerOnly' => true),
//            array('entry_amount', 'type', 'type' => 'float'),
//            array('entry_num_prefix', 'length', 'max' => 10),
//            array('entry_memo, entry_appendix', 'length', 'max' => 100),
//            array('entry_appendix_id, entry_appendix_type, entry_date, entry_time', 'safe'),
//            // The following rule is used by search().
//            // @todo Please remove those attributes that should not be searched.
//            array('id, entry_number, entry_num_prefix, entry_num, entry_date, entry_time, entry_memo, entry_transaction,
//            entry_subject, entry_amount, entry_appendix, entry_appendix_id, entry_appendix_type,entry_creater, entry_editor, entry_reviewer,
//            entry_deleted, entry_reviewed, entry_posting, entry_closing, entry_settlement', 'safe', 'on' => 'search'),
//            //自定义验证规则
//            array('entry_amount', 'check_entry_amount', 'on' => 'create,update'), //借贷相等
        ];
    }

    /**
     * @inheritdoc
     */

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

    public function search($params)
    {
        $query = self::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere(
            [
                'id' => $this->id,
                'status_id' => $this->status_id,
                'FROM_UNIXTIME(created_at, "%d.%m.%Y")' => $this->created_at,
                'FROM_UNIXTIME(updated_at, "%d.%m.%Y")' => $this->updated_at
            ]
        );

        $query->andFilterWhere(['like', 'alias', $this->alias]);
        $query->andFilterWhere(['like', 'title', $this->title]);
        $query->andFilterWhere(['like', 'snippet', $this->snippet]);
        $query->andFilterWhere(['like', 'content', $this->content]);

        return $dataProvider;
    }

    /*
     * 科目表名称
     */
    public static function getName($id)
    {
        $model = self::findOne(['sbj_number' => $id]);
        if ($model)
            return $model->sbj_name;
        else
            return "";
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
        $subject = new Subject();
        $result = [];
        $type = isset($options['type']) ? $options['type'] : 1;
        foreach ($arr as $item) {
            $arr_subj = $subject->list_sub($item, $key, $options);
                foreach ($arr_subj as $subj) {
                    if($type==0){
                        $result['_'. $subj['sbj_number']] = $subj['sbj_name'];
                    }else
                    $result['_' . $subj['sbj_number']]=Subject::getSbjPath($subj['sbj_number']);
                }
        }
        if(empty($result))
            foreach ($arr as $item) {
                $arr_subj = $subject->list_sub($item, '', $options);
                foreach ($arr_subj as $subj) {
                    if($type==0){
                        $result['_'. $subj['sbj_number']] = $subj['sbj_name'];
                    }else
                        $result['_' . $subj['sbj_number']]=Subject::getSbjPath($subj['sbj_number']);
                }
            }
        return $result;
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
        $data_1 = self::findBySql($sql_1, array())->asArray()->all();

        if (!empty($data_1))
            foreach ($data_1 as $key => $item) {
                array_push($data, $item);
                if ($item["has_sub"] == 1) {
                    $data_sub = $this->list_sub($item["sbj_number"], $key, $options);
                    foreach ($data_sub as $key => $item_sub) {
                        array_push($data, $item_sub);
                    }

                }
            }

        return $data;
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
        $data = self::find()->andFilterWhere(['like', 'sbj_name', $key])->asArray()->all();
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
            $sbj = Subject::createSubject($key, $subjects[0]);
        return $sbj;
    }

    /*
     * 如果没有就新建科目
     */
    public static function createSubject($key, $sbj)
    {
        $model = new Subject();
        $check = self::checkSbj($sbj, trim($key));
        if ($check != 0) {
            return $check;
        }
        $subj = self::init_new_sbj_number($sbj, 2);
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
     * 生成科目编号
     */
    public static function init_new_sbj_number($sbj_nubmer, $type)
    {    //1为同级科目，2为子科目
        if (strlen($sbj_nubmer) == 4 && $type == 1)    //一级科目不能创建同级科目
            $type = 2;
        //select max(sbj_number) from subjects where sbj_number like '1123%'
        if ($type == 1) {
            $length = strlen($sbj_nubmer);
            $sbj_nubmer = substr($sbj_nubmer, 0, -2);
        } else
            $length = strlen($sbj_nubmer) + 2;


        $query = new yii\db\Query();
        $query
            ->select('max(sbj_number) as sbj_number,sbj_cat')
            ->from('subjects as a')
            ->where('`sbj_number` like "' . $sbj_nubmer . '%" and length(`sbj_number`)=' . $length);
        $command = $query->createCommand(yii::$app->dbaccount);
        $number = $command->queryOne();

        if ($number['sbj_number'] != null)
            return [(int)$number['sbj_number'] + 1, $number['sbj_cat']];
        else {
            $subj = self::find()->where('sbj_number=' . $sbj_nubmer)->asArray()->one();

            return [$sbj_nubmer . '01', $subj['sbj_cat']];
        }

    }

    /*
     * 设置有子科目
     */
    public static function hasSub($sbj_id)
    {
        $par_id = substr($sbj_id, 0, -2);
        $query = new yii\db\Query();
        $command = $query
            ->createCommand(yii::$app->dbaccount)
            ->update('subjects', ['has_sub' => 1], 'sbj_number = ' . $par_id)
            ->execute();
    }

    /*
     * 科目表路径
     * @id Integer
     * @type Integer 是否显示路径
     */
    public static function getSbjPath($id, $type = 1)
    {
        $path = "";
        $path .= self::getName(substr($id, 0, 4));
        $length = strlen($id);
        $i = 6;
        while ($i <= $length) {
            $path .= '/' . self::getName(substr($id, 0, $i));
            $i = $i + 2;
        }
        return $path;
    }

    /*
     * 创建科目时，检测子科目下是否已经存在该科目
     */
    public static function checkSbj($key, $name)
    {
        $sbj_max = $key * 100 + 99;
        $sql = "SELECT sbj_number FROM subjects where sbj_number REGEXP '^$key' AND sbj_number>'$key' AND sbj_number<='$sbj_max' AND sbj_name='$name'";
        $model = self::findBySql($sql)->one();
        if ($model != null)
            return $model->sbj_number;
        else
            return 0;
    }
}

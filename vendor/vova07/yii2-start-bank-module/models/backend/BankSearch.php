<?php

namespace vova07\bank\models\backend;

use yii\data\ActiveDataProvider;

/**
 * Bank search model.
 */
class BankSearch extends Bank
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // Integer
            [['id', 'parent'], 'integer'],
        ];
    }

    /**
     * Creates data provider instance with search query applied.
     *
     * @param array $params Search params
     *
     * @return ActiveDataProvider DataProvider
     */
    public function search($params = [], $id = '')
    {
        $query = self::find();
        if (!empty($params))
        {
            $query->andWhere($params);
        }
        if ($id !== "")
            $query->andWhere('id != ' . $id);

        $list = $query->all();
        return $list;

    }

    public function findCorrelation($pid, $id)
    {

        $models = self::search(['parent' => $pid], $id);
        return $models;
    }
}

<?php

namespace laofashi\transition\controllers\backend;

use laofashi\transition\models\Transition;
use Yii;
use yii\web\HttpException;
use yii\web\Response;
use yii\web\Controller;
use yii\widgets\ActiveForm;

/**
 * Default backend controller.
 */
class DefaultController extends Controller
{
    /**
     * Find model by ID.
     *
     * @param integer|array $id Post ID
     *
     * @return \vova07\bank\models\backend\Bank Model
     *
     * @throws HttpException 404 error if post not found
     */
    protected function findModel($id)
    {
        if (is_array($id)) {
            $model = Transition::findAll($id);
        } else {
            $model = Transition::findOne($id);
        }
        if ($model !== null) {
            return $model;
        } else {
            throw new HttpException(404);
        }
    }
    /*
     * ajax
     */
    public function actionType(){
        if(Yii::$app->request->post())
            echo json_encode(Bank::chooseType($_POST['type']));
        else
            throw new HttpException(400);
    }

    /*
     * 返回的选项
     * $_POST['pid'] int 父id
     * $_POST['id']  int 当前选择id
     */
    public function actionOption(){
        if(Yii::$app->request->post()){
            echo json_encode(Bank::chooseOption($_POST['type'],$_POST['option'],$_POST['data']));
        }
        else
            throw new HttpException(400);
    }

}

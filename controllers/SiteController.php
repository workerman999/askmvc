<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\Tree;
use yii\web\NotFoundHttpException;


class SiteController extends Controller
{

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionTree()
    {
        if (Yii::$app->request->isAjax){
            $tree = new Tree();
            $rezult = $tree->getTree();
            if ($rezult){
                return $rezult;
            } else {
                $rezult = json_encode('Ошибка');
                return $rezult;
            }
        }
    }

    public function actionDevice($id)
    {
        if (Yii::$app->request->isAjax){
            $id = strip_tags(Yii::$app->request->get('id'));
            $tree = new Tree();
            return $tree->getProperties($id);
        }
    }

    public function actionGraph($id = null)
    {
        $objects = new Tree();
        $rezult = $objects->getObjectsTree();
        if (Yii::$app->request->isPost){
            $id = strip_tags(Yii::$app->request->post('id'));
            $graph = $objects->getObject($id);
            if (!is_object($graph)){
                $graph = null;
                return $this->redirect(['graph']);
            } else {
                return $this->render('viewgraph', ['graph' => $graph]);
            }
        }
        return $this->render('graph', ['rezult' => $rezult]);
    }

    public function actionViewgraph($id = null)
    {
        if (Yii::$app->request->isGet){
            $id = strip_tags(Yii::$app->request->get('id'));
            $viewgraph = new Tree();
            $rezult = $viewgraph->getObject($id);
            $x = time() * 1000;
            $y = $rezult->objects[0]->fuel;
            $ret = [$x, (int)$y];
            sleep(1);
            return json_encode($ret);
        }
    }

}

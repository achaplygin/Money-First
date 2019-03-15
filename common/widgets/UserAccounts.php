<?php

namespace common\widgets;

use Yii;
use frontend\models\AccountSearch;


class UserAccounts extends \yii\bootstrap\Widget
{
    public $dataProvider;
    public $searchModel;

    public function init(){
        $this->searchModel = new AccountSearch();
        $this->dataProvider = $this->searchModel->search(Yii::$app->request->queryParams);
    }

    public function run(){
        return Yii::$app->view->renderFile('@frontend/views/widgets/UserAccounts.php', ['searchModel' => $this->searchModel, 'dataProvider' => $this->dataProvider]);
    }

}
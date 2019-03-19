<?php

namespace frontend\widgets;

use Yii;
use frontend\models\AccountSearch;

/**
 * Class UserAccounts
 * @package common\widgets
 */
class UserAccounts extends \yii\bootstrap\Widget
{
    public $dataProvider;
    public $searchModel;

    /**
     * Inits $searchModel & dataProvider;
     */
    public function init()
    {
        $this->searchModel = new AccountSearch();
        $this->dataProvider = $this->searchModel->search(Yii::$app->request->queryParams);
    }

    /**
     * render view file
     * @return string
     */
    public function run()
    {
        return $this->render('user-accounts', ['searchModel' => $this->searchModel, 'dataProvider' => $this->dataProvider]);
//        return Yii::$app->view->renderFile('@frontend/views/widgets/UserAccounts.php', ['searchModel' => $this->searchModel, 'dataProvider' => $this->dataProvider]);
    }

}

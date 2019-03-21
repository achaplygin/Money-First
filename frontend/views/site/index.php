<?php
/* @var $this yii\web\View */

use yii\helpers\Url;
use yii\helpers\Html;
use frontend\widgets\UserAccount;
use frontend\widgets\TransactionHistory;

$this->title = 'Money First';

?>
<?php if (Yii::$app->user->isGuest) : ?>
    <div class="site-index">
        <div class="jumbotron">
            <h1>Welcome!</h1>
            <p class="lead"> Приветствую тебя, контрагент!</p>
            <p><a class="btn btn-lg btn-success" href="<?php echo Url::toRoute('site/login'); ?>">Войди и отдай свои
                    деньги!</a></p>
        </div>
        <div class="body-content">
            <div class="row">
                <div class="col-lg-4">
                    <h2> Heading</h2>
                    <p> Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut
                        labore et dolore magna aliqua.</p>
                </div>
                <div class="col-lg-4">
                    <h2> Heading</h2>
                    <p> Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut
                        labore et dolore magna aliqua.</p>
                </div>
                <div class="col-lg-4">
                    <h2> Heading</h2>
                    <p> Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut
                        labore et dolore magna aliqua.
                    </p>
                </div>
            </div>
        </div>
    </div>
<?php else: ?>
    <div class="col-lg-9">
        <?= TransactionHistory::widget() ?>
    </div>
    <div class="col-lg-3">
        <?= Html::a('Create Transaction', ['transaction/create'], ['class' => 'col-lg-12 btn btn-success']) ?>
        <br><br>
        <?= UserAccount::widget() ?>
    </div>
<?php endif; ?>

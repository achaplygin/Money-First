<?php
/* @var $this yii\web\View */

use common\models\User;
use yii\helpers\Url;

$this->title = 'Money First';
if (Yii::$app->user->isGuest) {
?>
    <div class="site-index" >
    <div class="jumbotron" >
        <h1>Welcome!</h1 >
        <p class="lead" > Приветствую тебя, контрагент!</p >
        <p ><a class="btn btn-lg btn-success" href="<?php echo Url::toRoute('site/login'); ?>" >Войди и отдай свои деньги!</a ></p >
    </div >
    <div class="body-content" >
        <div class="row" >
            <div class="col-lg-4" >
                <h2 > Heading</h2 >
                <p > Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et
                    dolore magna aliqua . Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip
                    ex ea commodo consequat . Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu
                    fugiat nulla pariatur .</p >
            </div >
            <div class="col-lg-4" >
                <h2 > Heading</h2 >
                <p > Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et
                    dolore magna aliqua . Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip
                    ex ea commodo consequat . Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu
                    fugiat nulla pariatur .</p >
            </div >
            <div class="col-lg-4" >
                <h2 > Heading</h2 >
                <p > Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et
                    dolore magna aliqua . Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip
                    ex ea commodo consequat . Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu
                    fugiat nulla pariatur .</p >
            </div >
        </div >
    </div >
</div >
<?php }else{
    echo '<br>Привет ';
    $loggeduser=User::findOne(Yii::$app->user->id);
    echo $loggeduser->username.'<br>';
}
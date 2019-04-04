<?php

namespace backend\models;

use yii\base\Model;
use common\models\User;

/**
 * Create User form
 */
class UserForm extends Model
{
    public $username;
    public $email;
    public $password;
    public $is_admin;


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['username', 'trim'],
            ['username', 'required'],
            ['username', 'filter', 'filter' => '\yii\helpers\HtmlPurifier::process'],
            //['username', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This username has already been taken.'],
            ['username', 'string', 'min' => 2, 'max' => 255],

            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'filter', 'filter' => '\yii\helpers\HtmlPurifier::process'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            //['email', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This email address has already been taken.'],

            ['password', 'required'],
            ['password', 'string', 'min' => 6],

            ['is_admin', 'boolean']
        ];
    }

    /**
     * @return User|null
     * @throws \yii\base\Exception
     */
    public function createUser(): bool
    {
        if (!$this->validate()) {
            return false;
        }

        $user = new User();
        $user->username = $this->username;
        $user->email = $this->email;
        $user->setPassword($this->password);
        $user->generateAuthKey();

        return $user->save();
    }

    /**
     * @param  User $user
     * @return bool
     * @throws \yii\base\Exception
     */
    public function updateUser(User $user): bool
    {
        if (!$this->validate()) {
            return false;
        }

        $user->username = $this->username;
        $user->email = $this->email;
        $user->is_admin = $this->is_admin;
        $user->setPassword($this->password);

        return $user->save();
    }
}

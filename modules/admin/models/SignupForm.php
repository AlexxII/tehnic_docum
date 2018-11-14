<?php

namespace app\modules\admin\models;

use Yii;
use yii\base\Model;
use app\modules\admin\models\User;

class SignupForm extends Model
{
  public $login;
  public $password;
  public $username;
  public $social_group;


  public function rules()
  {
    return [
        ['username', 'trim'],
        ['username', 'trim'],
        ['login', 'trim'],
        ['login', 'required'],
        ['login', 'unique', 'targetClass' => '\app\modules\admin\models\User', 'message' => 'Данное имя уже используется.'],
        ['login', 'string', 'min' => 2, 'max' => 255],
        ['social_group', 'trim'],
        ['social_group', 'required'],
//        ['email', 'trim'],
//        ['email', 'required'],
//        ['email', 'email'],
//        ['email', 'string', 'max' => 255],
//        ['email', 'unique', 'targetClass' => '\app\modules\admin\models\User', 'message' => 'This email address has already been taken.'],
        ['password', 'safe'],
        ['password', 'string', 'min' => 6, 'message' => 'Пароль должен содержать не менее 6 символов'],
    ];
  }


  public function attributeLabels()
  {
    return [
        'username' => 'Пользователь:',
        'password' => 'Пароль:',
        'login' => 'Логин:',
        'social_group' => 'Социальная группа:'
    ];
  }

  /**
   * Signs user up.
   *
   * @return User|null the saved model or null if saving fails
   */
  public function signup()
  {
    if (!$this->validate()) {
      return null;
    }
    $user = new User();
    $user->login = $this->login;
    $user->username = $this->username;
    $user->setPassword($this->password);
    $user->email = $this->login . '@localhost.ru';
    $user->generateAuthKey();
    return $user->save() ? $user : null;
  }


}
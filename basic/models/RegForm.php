<?php

namespace app\models;

use Yii;

class RegForm extends User{

    public $passwordConfirm;
    public $agree;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name_user', 'email_user', 'password_user', 'passwordConfirm', 'agree'],
                'required', 'message' => 'Поле обязательно для заполнения'],
            ['name_user', 'match', 'pattern' => '/^[А-Яа-я\s\-]{5,}$/u', 'message' => 'Только кириллица, пробелы и дефис'],
            ['email_user', 'email', 'message' => 'Некорректный Email'],
            ['passwordConfirm', 'compare', 'compareAttribute' => 'password_user', 'message' => 'Пароли не совпаают'],
            ['agree', 'boolean'],
            ['agree', 'compare', 'compareValue' => true, 'message' => 'Необходимо согласие']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_user' => 'Id пользователя',
            'name_user' => 'ФИО',
            'email_user' => 'Email',
            'password_user' => 'Пароль',
            'role_user' => 'Роль',
            'passwordConfirm' => 'Подтвердите пароль',
            'agree' => 'Даю согласие на обработку персональных данных'
        ];
    }

}




<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user".
 *
 * @property int $id_user
 * @property string $name_user
 * @property string $email_user
 * @property string $password_user
 * @property int $role_user
 *
 * @property Order[] $orders
 */
class User extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
{

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
            [['role_user'], 'default', 'value' => 0],
            [['name_user', 'email_user', 'password_user'], 'required'],
            [['role_user'], 'string'],
            [['name_user', 'email_user', 'password_user'], 'string', 'max' => 255],
            ['passwordConfirm', 'compare', 'compareAttribute' => 'password_user'],
            ['role_user', 'in', 'range' => ['Пользователь', 'Привилегия', 'Админ']],
            ['agree', 'boolean'], ['agree', 'compare', 'compareValue' => true, 'message' => 'Требуется согласие'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_user' => 'Id User',
            'name_user' => 'Fio User',
            'email_user' => 'Email User',
            'password_user' => 'Password User',
            'role_user' => 'Admin User',
        ];
    }

    /**
     * Gets query for [[Problems]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOrders()
    {
        return $this->hasMany(Order::class, ['id_user' => 'id_user']);
    }


    public static function findIdentity($id)
    {
        return self::findOne($id);
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
 
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByEmail($email_user)
    {
        return self::find()->where(['email_user' => $email_user])->one();
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id_user;
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
      
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return $this->password_user === $password;
    }

}

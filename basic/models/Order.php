<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "orders".
 *
 * @property int $id_order
 * @property int $id_product
 * @property int $id_user
 * @property string $status_order
 * @property string $timestamp_order
 *
 * @property Product $product
 * @property User $user
 */
class Order extends \yii\db\ActiveRecord
{

    const STATUS_NEW = 'Новый';
    const STATUS_PROCESSING = 'Готовится';
    const STATUS_READY = 'Готов';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'orders';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_product', 'id_user', 'status_order'], 'required'],
            [['id_product', 'id_user'], 'integer'],
            [['status_order'], 'string'],
            [['timestamp_order'], 'safe'],
            [['id_product'], 'exist', 'skipOnError' => true, 'targetClass' => Product::class, 'targetAttribute' => ['id_product' => 'id_product']],
            [['id_user'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['id_user' => 'id_user']],
        ];
    }


    public function getStatusBadge()
    {
        $colors = [
            self::STATUS_NEW => 'badge-info',
            self::STATUS_PROCESSING => 'badge-warning',
            self::STATUS_READY => 'badge-success',
        ];

        $color = $colors[$this->status_order] ?? 'badge-secondary';
        return "<span class='badge {$color}'>{$this->status_order}</span>";
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_order' => 'Id Order',
            'id_product' => 'Id Product',
            'id_user' => 'Id User',
            'status_order' => 'Status Order',
            'timestamp_order' => 'Timestamp Order',
        ];
    }

    /**
     * Gets query for [[Product]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasOne(Product::class, ['id_product' => 'id_product']);
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id_user' => 'id_user']);
    }


    public function beforeSave($insert)
    {
         if (parent::beforeSave($insert)) {
        if ($this->isNewRecord) {
            $this->id_user = Yii::$app->user->id;
            $this->status_order = 'Новый';
            $this->timestamp_order = date('Y-m-d H:i:s');
        }
        return true;
    }
        return false;
    }
}

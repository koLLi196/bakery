<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "product".
 *
 * @property int $id_product
 * @property string $name_product
 * @property int $id_category
 * @property string $photo_product
 * @property int $price_product
 *
 * @property Category $category
 * @property Order[] $order
 */
class Product extends \yii\db\ActiveRecord
{

    public $photo_product_file;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'product';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name_product', 'id_category', 'photo_product', 'price_product'], 'required'],
            [['id_category', 'price_product'], 'integer'],
            [['name_product', 'photo_product'], 'string', 'max' => 255],
            [['id_category'], 'exist', 'skipOnError' => true, 'targetClass' => Category::class, 'targetAttribute' => ['id_category' => 'id_category']],
            [['photo_product'], 'file', 
            'extensions' => ['jpg', 'jpeg', 'png', 'gif'],
            'maxSize' => 1024 * 1024,   
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_product' => 'Id Product',
            'name_product' => 'Name Product',
            'id_category' => 'Id Category',
            'photo_product' => 'Photo Product',
            'price_product' => 'Price Product',
        ];
    }

    /**
     * Gets query for [[Category]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Category::class, ['id_category' => 'id_category']);
    }

    /**
     * Gets query for [[Orders]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOrders()
    {
        return $this->hasMany(Order::class, ['id_product' => 'id_product']);
    }

}

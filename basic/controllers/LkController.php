<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\data\ActiveDataProvider;
use app\models\Order;
use app\models\Product;
use app\models\Category;

class LkController extends Controller
{
    // Главная страница личного кабинета
    public function actionIndex()
    {
        // Только авторизованные пользователи
        if (Yii::$app->user->isGuest) {
            return $this->redirect(['site/login']);
        }

        $dataProvider = new ActiveDataProvider([
            'query' => Order::find()->where(['id_user' => Yii::$app->user->id])->orderBy('timestamp_order DESC'),
            'pagination' => ['pageSize' => 10],
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'user' => Yii::$app->user->identity,
        ]);
    }

    // Форма создания заказа
    public function actionCreate()
    {
        if (Yii::$app->user->isGuest) {
            return $this->redirect(['site/login']);
        }

        $model = new Order();
        $model->id_user = Yii::$app->user->id;
        $model->status_order = 'Новый';

        if ($model->load(Yii::$app->request->post())) {
            // Расчёт суммы (если нужно)
            $product = Product::findOne($model->id_product);
            if ($product) {
                $model->total_amount = $product->price_product;
            }

            $model->product_name = $product->name_product;
            $model->product_photo = $product->photo_product;
            $model->total_amount = $product->price_product; 
            
            if ($model->save()) {
                return $this->redirect(['index']);
            }
        }

        return $this->render('create', [
            'model' => $model,
            'categories' => Category::find()->all(),
        ]);
    }
}
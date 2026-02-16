<?php

namespace app\controllers;

use Yii;
use app\models\Order;
use app\models\Product;
use app\models\OrderSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * OrderController implements the CRUD actions for Order model.
 */
class OrderController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all Order models.
     *
     * @return string
     */
    public function actionIndex()
    {
            $dataProvider = new ActiveDataProvider([
            'query' => Order::find()->where(['id_user' => Yii::$app->user->id]),
            'pagination' => ['pageSize' => 10],
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'user' => Yii::$app->user->identity,
        ]);
    }

     public function actionStartProcessing($id)
    {
        $order = $this->findModel($id);
        $order->status_order = Order::STATUS_PROCESSING;
        $order->save(false);
        return $this->redirect(['index']);
    }

    public function actionMarkAsReady($id)
    {
        $order = $this->findModel($id);
        $order->status_order = Order::STATUS_READY;
        $order->save(false);
        return $this->redirect(['index']);
    }

     public function actionMarkAsDelivered($id)
    {
        $order = $this->findModel($id);
        return $this->redirect(['index']);
    }

    

    /**
     * Displays a single Order model.
     * @param int $id_order Id Order
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id_order)
    {
        return $this->render('view', [
            'model' => $this->findModel($id_order),
        ]);
    }

    /**
     * Creates a new Order model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */

   public function actionCreate($id_product = null)
{
    if (Yii::$app->user->isGuest) {
        return $this->redirect(['site/login']);
    }

    $model = new Order();

    if ($id_product !== null) {
        $product = Product::findOne($id_product);
        if ($product) {
            $model->id_product = $product->id_product;
            $model->total_amount = $product->price_product;
        }
    }

    if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
        Yii::$app->session->setFlash('success', 'Заказ успешно оформлен!');
        return $this->redirect(['lk/index']); 
    }

    return $this->render('create', ['model' => $model]);
}

    /**
     * Updates an existing Order model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id_order Id Order
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id_order)
    {
        $model = $this->findModel($id_order);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id_order' => $model->id_order]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Order model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id_order Id Order
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id_order)
    {
        $this->findModel($id_order)->delete();

        return $this->redirect(['index']);
    }


public function actionOrder($id_product = null)
{
    if (Yii::$app->user->isGuest) {
        return $this->redirect(['site/login']);
    }

    $model = new Order();

    if ($id_product !== null) {
        $product = Product::findOne($id_product);
        if (!$product) {
            throw new NotFoundHttpException('Товар не найден.');
        }
        $model->id_product = $product->id_product;
        $model->total_amount = $product->price_product;
    }

    if ($this->request->isPost) {
        if ($model->load($this->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Заказ успешно оформлен!');
            return $this->redirect(['site/index']);
        }
    }

    return $this->render('order', [
        'model' => $model,
        'product' => $id_product ? Product::findOne($id_product) : null,
    ]);
}




    /**
     * Finds the Order model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id_order Id Order
     * @return Order the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
     protected function findModel($id)
    {
        if (($model = Order::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('Заказ не найден.');
    }
}

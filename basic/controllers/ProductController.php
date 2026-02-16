<?php

namespace app\controllers;

use Yii;
use yii\web\UploadedFile;
use yii\web\ForbiddenHttpException;
use app\models\Product;
use app\models\ProductSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ProductController implements the CRUD actions for Product model.
 */
class ProductController extends Controller
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
     * Lists all Product models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new ProductSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Product model.
     * @param int $id_product Id Product
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id_product)
    {
        return $this->render('view', [
            'model' => $this->findModel($id_product),
        ]);
    }

    /**
     * Creates a new Product model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Product();

        if ($model->load(Yii::$app->request->post())) {
            $model->photo_product_file = UploadedFile::getInstance($model, 'photo_product_file');
            if ($model->photo_product_file) {
                $fileName = Yii::$app->security->generateRandomString(10) . '.' . $model->photo_product_file->extension;
                $filePath = Yii::getAlias('@webroot') . '/uploads/' . $fileName;
                
                if ($model->photo_product_file->saveAs($filePath)) {
                    $model->photo_product = 'uploads/' . $fileName;
                }
            }

            if ($model->save()) {
                return $this->redirect(['view', 'id_product' => $model->id_product]);
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Product model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id_product Id Product
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id_product)
    {
        $model = $this->findModel($id_product);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id_product' => $model->id_product]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Product model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id_product Id Product
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id_product)
    {
        $this->findModel($id_product)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Product model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id_product Id Product
     * @return Product the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id_product)
    {
        if (($model = Product::findOne(['id_product' => $id_product])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }


    public function beforeAction($action)
    {
         if (in_array($action->id, ['index', 'view'])) {
        return parent::beforeAction($action);
    }

    // Только для update/delete — проверяем админа
    if (Yii::$app->user->isGuest || Yii::$app->user->identity->role_user !== 'Админ') {
        throw new ForbiddenHttpException('Доступ запрещён');
    }

    return parent::beforeAction($action);
    }
}

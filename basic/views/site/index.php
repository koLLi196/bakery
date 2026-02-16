<?php
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Кондитерская "Сладкий дом"';
?>
<div class="site-index">
    <div class="jumbotron">
        <h1>Добро пожаловать!</h1>
        <p class="lead">У нас вы найдёте самые вкусные торты, пирожные и конфеты ручной работы.</p>
        <?php if (Yii::$app->user->isGuest || Yii::$app->user->identity->role_user == 'Админ'): ?>  
        <p><a class="btn btn-lg btn-success" href="<?= Url::to(['product/index']) ?>">Каталог товаров</a></p>
        <?php endif; ?>
    </div>

    <div class="body-content">
        <h2>Новинки</h2>
        <div class="row">
            <?php foreach ($newProducts as $product): ?>
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="thumbnail">
                        <?php if ($product->photo_product): ?>
                            <img src="<?= Yii::getAlias('@web/') . $product->photo_product ?>" 
                                 alt="<?= Html::encode($product->name_product) ?>" 
                                 style="width:100%; height:200px; object-fit:cover;">
                        <?php else: ?>
                            <div style="width:100%; height:200px; background:#f5f5f5; display:flex; align-items:center; justify-content:center;">
                                Нет фото
                            </div>
                        <?php endif; ?>
                            <div class="caption">
                                <h4><?= Html::encode($product->name_product) ?></h4>
                                <p><strong><?= $product->price_product ?> ₽</strong></p> 
                         </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>
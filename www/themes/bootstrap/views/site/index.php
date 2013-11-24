<?php
/* @var $this SiteController */

$this->pageTitle=Yii::app()->name;
?>

<?php $this->beginWidget('bootstrap.widgets.TbHeroUnit',array(
    'heading'=>'Главная страница - '.CHtml::encode(Yii::app()->name),
)); ?>

<?php $this->endWidget(); ?>

<p>Доступы:</p>

<ul>
    <li>login:admin , password:111</li>
    <li>login:dsk , password:123</li>
    <li>login:pik , password:456</li>
    <li>login:gvsu , password:789</li>
</ul>

<p>Ссылки:</p>

<ul>
    <li><a href="?ref=6398a5d89dcecbbcb7ae7e1a7f5bf809">dsk</a></li>
    <li><a href="?ref=dd0541a25a51efc0399fb4fefe396d18">pik</a></li>
    <li><a href="?ref=3dd767c72a819558071fc86decd68c9d">gvsu</a></li>
</ul>

<?php
/* @var $this DashboardController */

$this->breadcrumbs=array(
	'Dashboard',
);
?>
<div class="row">
    <div class="span3">
    	<?if($partnersList && count($partnersList) > 0):?>
	        <div id="sidebar">
	        <?php
                array_unshift($partnersList, array('label' => 'Партнеры', 'itemOptions' => array('class' => 'nav-header')));
				$this->widget(
				    'bootstrap.widgets.TbMenu',
				    array(
					    'type' => 'list',
					    'items' => $partnersList
				    )
				);
			?>
	        </div><!-- sidebar -->
        <?endif;?>
    </div>
    <div class="span9">
        <div id="content">
            <?if($model->getRole() != 'admin'):?>
                <p>Количество уникальных переходов: <?php echo $uniqueItems; ?></p>
                <p>Количество зачтенных переходов: <?php echo $acceptedItems; ?></p>
                <p>Количество незачтенных переходов: <?php echo $notAcceptedItems; ?></p>
                <p>
                    <a href="<?=$this->createUrl('/referral/dashboard/days', array('user_id'=>$model->user_id));?>">Статистика по дням</a>
                </p>
            <?else:?>
                <p>Выбирете партнера для просмотра статистики</p>
            <?endif;?>
        </div><!-- content -->
    </div>
</div>
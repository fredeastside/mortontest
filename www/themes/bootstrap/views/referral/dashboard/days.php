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
    		<?php
			$this->widget('bootstrap.widgets.TbExtendedGridView', array(
				'sortableRows'=>true,
			    'type'=>'striped bordered',
			    'dataProvider'=>$statistics,
			    'template'=>"{items}",
			    'columns'=>array(
			        array('name'=>'date', 'header'=>'Дата'),
			        array(
			        	'name'=>'status_id', 
			        	'header'=>'Статус', 
			        	'value'=>'Status::model()->getStatusName($data["status_id"])'
			        	),
			        array('name'=>'count', 'header'=>'Количество'),
			    ),
			));
			?>
			<p><a href="<?=Yii::app()->user->returnUrl;?>">Назад</a></p>
        </div><!-- content -->
    </div>
</div>

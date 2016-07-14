<div class="view">

	<?php echo GxHtml::encode($data->getAttributeLabel('price_id')); ?>:
	<?php echo GxHtml::link(GxHtml::encode($data->price_id), array('view', 'id' => $data->price_id)); ?>
	<br />

	<?php echo GxHtml::encode($data->getAttributeLabel('no_days')); ?>:
	<?php echo GxHtml::encode($data->no_days); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('price')); ?>:
	<?php echo GxHtml::encode($data->price); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('status')); ?>:
	<?php echo GxHtml::encode($data->status); ?>
	<br />

</div>
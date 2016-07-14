<div class="view">

	<?php echo GxHtml::encode($data->getAttributeLabel('package_id')); ?>:
	<?php echo GxHtml::link(GxHtml::encode($data->package_id), array('view', 'id' => $data->package_id)); ?>
	<br />

	<?php echo GxHtml::encode($data->getAttributeLabel('package_name')); ?>:
	<?php echo GxHtml::encode($data->package_name); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('package_price')); ?>:
	<?php echo GxHtml::encode($data->package_price); ?>
	<br />

</div>
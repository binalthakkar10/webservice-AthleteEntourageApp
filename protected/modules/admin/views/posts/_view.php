<div class="view">

	<?php echo GxHtml::encode($data->getAttributeLabel('post_id')); ?>:
	<?php echo GxHtml::link(GxHtml::encode($data->post_id), array('view', 'id' => $data->post_id)); ?>
	<br />

	<?php echo GxHtml::encode($data->getAttributeLabel('post_text')); ?>:
	<?php echo GxHtml::encode($data->post_text); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('user_id')); ?>:
		<?php echo GxHtml::encode(GxHtml::valueEx($data->user)); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('created_date')); ?>:
	<?php echo GxHtml::encode($data->created_date); ?>
	<br />

</div>
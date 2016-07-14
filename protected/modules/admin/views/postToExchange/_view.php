<div class="view">

	<?php echo GxHtml::encode($data->getAttributeLabel('postexchange_id')); ?>:
	<?php echo GxHtml::link(GxHtml::encode($data->postexchange_id), array('view', 'id' => $data->postexchange_id)); ?>
	<br />

	<?php echo GxHtml::encode($data->getAttributeLabel('user_id')); ?>:
	<?php echo GxHtml::encode($data->user_id); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('campaign_id')); ?>:
	<?php echo GxHtml::encode($data->campaign_id); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('user_type')); ?>:
	<?php echo GxHtml::encode($data->user_type); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('message')); ?>:
	<?php echo GxHtml::encode($data->message); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('created_date')); ?>:
	<?php echo GxHtml::encode($data->created_date); ?>
	<br />

</div>
<div class="view">

	<?php echo GxHtml::encode($data->getAttributeLabel('campaign_id')); ?>:
	<?php echo GxHtml::link(GxHtml::encode($data->campaign_id), array('view', 'id' => $data->campaign_id)); ?>
	<br />

	<?php echo GxHtml::encode($data->getAttributeLabel('compaign_message')); ?>:
	<?php echo GxHtml::encode($data->compaign_message); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('post_to_exchange')); ?>:
	<?php echo GxHtml::encode($data->post_to_exchange); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('created_date')); ?>:
	<?php echo GxHtml::encode($data->created_date); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('total_cost')); ?>:
	<?php echo GxHtml::encode($data->total_cost); ?>
	<br />

</div>
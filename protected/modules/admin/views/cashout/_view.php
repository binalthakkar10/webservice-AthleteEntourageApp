<div class="view">

	<?php echo GxHtml::encode($data->getAttributeLabel('cashout_id')); ?>:
	<?php echo GxHtml::link(GxHtml::encode($data->cashout_id), array('view', 'id' => $data->cashout_id)); ?>
	<br />

	<?php echo GxHtml::encode($data->getAttributeLabel('user_id')); ?>:
		<?php echo GxHtml::encode(GxHtml::valueEx($data->user)); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('amount_to_cashout')); ?>:
	<?php echo GxHtml::encode($data->amount_to_cashout); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('is_verified')); ?>:
	<?php echo GxHtml::encode($data->is_verified); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('updated_date')); ?>:
	<?php echo GxHtml::encode($data->updated_date); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('created_date')); ?>:
	<?php echo GxHtml::encode($data->created_date); ?>
	<br />

</div>
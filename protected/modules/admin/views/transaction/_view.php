<div class="view">

	<?php echo GxHtml::encode($data->getAttributeLabel('transaction_id')); ?>:
	<?php echo GxHtml::link(GxHtml::encode($data->transaction_id), array('view', 'id' => $data->transaction_id)); ?>
	<br />

	<?php echo GxHtml::encode($data->getAttributeLabel('user_id')); ?>:
		<?php echo GxHtml::encode(GxHtml::valueEx($data->user)); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('email')); ?>:
	<?php echo GxHtml::encode($data->email); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('twitter_screen_name')); ?>:
	<?php echo GxHtml::encode($data->twitter_screen_name); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('payment_gateway_id')); ?>:
	<?php echo GxHtml::encode($data->payment_gateway_id); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('amount')); ?>:
	<?php echo GxHtml::encode($data->amount); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('campaign_id')); ?>:
		<?php echo GxHtml::encode(GxHtml::valueEx($data->campaign)); ?>
	<br />
	<?php /*
	<?php echo GxHtml::encode($data->getAttributeLabel('created_date')); ?>:
	<?php echo GxHtml::encode($data->created_date); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('payment_status')); ?>:
	<?php echo GxHtml::encode($data->payment_status); ?>
	<br />
	*/ ?>

</div>
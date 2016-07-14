<div class="view">

	<?php echo GxHtml::encode($data->getAttributeLabel('sponser_id')); ?>:
	<?php echo GxHtml::link(GxHtml::encode($data->sponser_id), array('view', 'id' => $data->sponser_id)); ?>
	<br />

	<?php echo GxHtml::encode($data->getAttributeLabel('user_id')); ?>:
		<?php echo GxHtml::encode(GxHtml::valueEx($data->user)); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('image')); ?>:
	<?php echo GxHtml::encode($data->image); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('fb_screen_name')); ?>:
	<?php echo GxHtml::encode($data->fb_screen_name); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('twitter_screen_name')); ?>:
	<?php echo GxHtml::encode($data->twitter_screen_name); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('total_twitt')); ?>:
	<?php echo GxHtml::encode($data->total_twitt); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('total_retwitt')); ?>:
	<?php echo GxHtml::encode($data->total_retwitt); ?>
	<br />
	<?php /*
	<?php echo GxHtml::encode($data->getAttributeLabel('fb_likes')); ?>:
	<?php echo GxHtml::encode($data->fb_likes); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('fb_friends')); ?>:
	<?php echo GxHtml::encode($data->fb_friends); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('flag')); ?>:
	<?php echo GxHtml::encode($data->flag); ?>
	<br />
	*/ ?>

</div>
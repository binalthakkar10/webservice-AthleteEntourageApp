<?php
if(!isset($type)){
 $this->renderPartial('/layouts/subheader');
}
$id=Yii::app()->customer->id;
$model = Creditcard::model()->find('user_id="'.$id.'" ');
?>
<div class="form form_main">
<div class="bg">
<div class="form">
<form name="subscription" id="subscription" method="post" action="<?php echo CController::createUrl('subscription/index')?>">
<div class="row">
<span class="allow_deduction_label">Allow Deduction:</span>
&nbsp;&nbsp;
<input type="radio" id="deduction_yes" name="Creditcard[allow_deduction]" value="Y" <?php echo ($model->allow_deduction=='Y')?'checked':'' ?>/><span class="deduction_yes">Yes</span>
&nbsp;
<input type="radio" id="deduction_no" class="deduction_no" name="Creditcard[allow_deduction]" value="N" <?php echo ($model->allow_deduction=='N')?'checked':'' ?>/><span class="deduction_no">No</span>
<div class="deduction_button">
        <input type="submit" value="Submit" name="yt8">
   </div>
</div>
</form>
</div>
</div>
</div>


<?php 
 $this->renderPartial('/layouts/subheader');
 ?>

<div class="form form_main">
<div class="bg">



<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
    'id'=>'users-form',
    'enableAjaxValidation'=>false,
	'enableClientValidation'=>true,
     'clientOptions' => array(
		      'validateOnSubmit'=>true,
		      //'validateOnChange'=>true,
		      //'validateOnType'=>false,
          ),
)); ?>



    <p class="note">Fields with <span class="required">*</span> are required.</p>

    <?php echo $form->errorSummary($resultset); ?>
    
    <?php
	foreach(Yii::app()->user->getFlashes() as $key => $message) {
        echo '<div class="flash-' . $key . '">' . $message . "</div>\n";
    }
    ?>


 	<div class="row">
        <?php echo $form->labelEx($resultset,'username'); ?>
        <?php echo $form->textField($resultset,'username'); ?>
        <?php echo $form->error($resultset,'username'); ?>
    </div>
    
    <div class="row">
        <?php echo $form->labelEx($resultset,'firstname'); ?>
        <?php echo $form->textField($resultset,'firstname'); ?>
        <?php echo $form->error($resultset,'firstname'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($resultset,'lastname'); ?>
        <?php echo $form->textField($resultset,'lastname'); ?>
        <?php echo $form->error($resultset,'lastname'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($resultset,'email'); ?>
        <?php echo $resultset->email; ?>
        <?php //echo $form->error($resultset,'email'); ?>
    </div>

   

   
<?php /*
    <div class="row">
        <?php echo $form->labelEx($resultset,'city_id'); ?>
        <span class="field"><?php echo $form->dropDownList($resultset, 'city_id', GxHtml::listDataEx(City::model()->findAllAttributes(null, true))); ?></span>
        <?php echo $form->error($resultset,'city_id'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($resultset,'categories_id'); ?>
        <span class="field"><?php echo $form->dropDownList($resultset, 'categories_id', GxHtml::listDataEx(Categories::model()->findAllAttributes(null, true))); ?></span>
        <?php echo $form->error($resultset,'categories_id'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($resultset,'user_type'); ?>
        <?php echo $resultset->user_type; ?>
        <?php //echo $form->error($resultset,'user_type'); ?>
    </div>
*/?>
<?php /*
    <div class="row">
        <?php echo $form->labelEx($model,'lognum'); ?>
        <?php echo $form->textField($model,'lognum'); ?>
        <?php echo $form->error($model,'lognum'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'is_active'); ?>
        <?php echo $form->textField($model,'is_active'); ?>
        <?php echo $form->error($model,'is_active'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'user_roles'); ?>
        <?php echo $form->textField($model,'user_roles'); ?>
        <?php echo $form->error($model,'user_roles'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'updated_at'); ?>
        <?php echo $form->textField($model,'updated_at'); ?>
        <?php echo $form->error($model,'updated_at'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'logdate'); ?>
        <?php echo $form->textField($model,'logdate'); ?>
        <?php echo $form->error($model,'logdate'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($resultset,'extra'); ?>
        <?php echo $form->textField($resultset,'extra'); ?>
        <?php echo $form->error($resultset,'extra'); ?>
    </div>
*/?>

     <div class="row buttons b_sub">
        <?php echo CHtml::submitButton('Submit'); ?>
    </div>

<?php $this->endWidget(); ?>

</div><!-- form -->
</div>
</div>
<?php /* ?>
<script type="text/javascript">
$(document).ready(function() {
		$("#users-form").click(function(){
			var firstname=$('#Users_firstname').val()
			var lastname=$('#Users_lastname').val();
			var username=$('#Users_username').val();
			var city=$('#Users_city_id').val();
			var categories=$('#Users_categories_id').val();

			 $.ajax({
					type: "GET",
					url: '<?php echo  CController::createUrl("editprofile"); ?>',
					data:{"firstname":firstname,"lastname":lastname,"username":username,"city":city,"categories":categories},
					success: function(result) {
							
			  			},
			  	});
			return false;
		});
});

</script>
<?php */ ?>

<?php $flag = '0';?>
<?php if(isset($address) && !empty($address)){ ?>
	<?php if($type=='personal'){ ?>	
	<select size="5" id="select_tradesman_address" class="regular-menu" >
	<?php }else{ ?>
	<select size="5" id="select_tradesman_company_address" class="regular-menu" >
	<?php }?>
	<?php foreach($address AS $postcode){
		
		//echo $postcode->formatted_address;
		$address = @explode(', ',$postcode->formatted_address);
		$geometry = $postcode->geometry;
		$lat = $geometry->location->lat;
		$lng = $geometry->location->lng;
		$count = count($address);
		
		if($count == 4)
		{
			$flag = '1';
			$address1 = $address[0];
			$town = $address[1];
			$country = $address[3];
			$lat = $lat;
			$lng = $lng;
			?>
			<option value="<?php echo $address1.', '.$town.', '.$country.', '.$lat.', '.$lng;  ?>"><?php echo $address1.', '.$town.', '.$country;  ?></option>
			<?php				
		}
		
	}
	?>
	</select>
<br/>

<?php if (isset($flag) && $flag == '0'):?>
	<?php if($type=='personal'){ ?>
	<?php echo CHtml::link('Address not available','', array('class'=>'addressnotavailable','href'=>'javascript:;'))?>
	<?php }else{?>
	<?php echo CHtml::link('Address not available','', array('class'=>'company_addressnotavailable','href'=>'javascript:;'))?>
	<?php }?>	
	<?php endif;?>
<?php } ?>

<?php /* ?>
	<?php if($type=='personal'){ ?>	
	<select size="5" id="select_tradesman_address" class="regular-menu" >
	<?php }else{ ?>
	<select size="5" id="select_tradesman_company_address" class="regular-menu" >
	<?php }?>
		<?php foreach($address AS $postcode){
				p($postcode,0); 
				$value = '';
				$value .= $postcode['name'].', ';
				
				$counter = 0;
				if(!is_array($postcode['adminCode2']) && !empty($postcode['adminCode2'])){
					$value .= $postcode['adminCode2'];
					$counter++;
				}
				if(!is_array($postcode['adminName2']) && !empty($postcode['adminName2'])){
					$value .= $postcode['adminName2'];
					$counter++;
				}
				if($counter>0){
					$value .= ', ';
				}
				$counter1 = 0;
				if(!is_array($postcode['adminCode1']) && !empty($postcode['adminCode1'])){
					$value .= $postcode['adminCode1'];
					$counter1++;
				}
				if(!is_array($postcode['adminName1']) && !empty($postcode['adminName1'])){
					$value .= $postcode['adminName1'];
					$counter1++;
				}
				if($counter1>0){
					$value .= ', ';
				}
				$counter2 = 0;
				if(!is_array($postcode['countryCode']) && !empty($postcode['countryCode'])){
					$value .= $postcode['countryCode'];
					$counter2++;
				}
				if(!is_array($postcode['postalcode']) && !empty($postcode['postalcode'])){
					$value .= $postcode['postalcode'];
					$counter2++;
				}
		?>		
		<option value="<?php echo $postcode['name'].', '.$postcode['adminCode2'].' '.$postcode['adminName2'].', '.$postcode['adminCode1'].' '.$postcode['adminName1'].', '.$postcode['countryCode'].', '.$postcode['postalcode'];  ?>"><?php echo $postcode['name'].', '.$postcode['adminCode2'].' '.$postcode['adminName2'].', '.$postcode['adminCode1'].' '.$postcode['adminName1'].', '.$postcode['countryCode'].', '.$postcode['postalcode'];  ?></option>
		<?php } ?>
	</select>
	<br />
	<?php if($type=='personal'){ ?>
	<?php echo CHtml::link('Address not available','', array('class'=>'addressnotavailable','href'=>'javascript:;'))?>
	<?php }else{?>
	<?php echo CHtml::link('Address not available','', array('class'=>'company_addressnotavailable','href'=>'javascript:;'))?>
	<?php }?>	
<?php } ?>
<?php */ ?>
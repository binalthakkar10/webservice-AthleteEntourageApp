<?php
require_once('lib/Stripe.php');

$stripe = array(
  "secret_key"      => "sk_test_DQJnKXNeTcK4ffb948JMHn4h",
  "publishable_key" => "pk_test_L6BXCTOIyPwhLyETdxEL6e4r"
);

Stripe::setApiKey($stripe['secret_key']);
?>


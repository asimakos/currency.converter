
<?php

       require 'vendor/autoload.php';

       $app_id="5810231054a146b38686debc00891448";

       $client = new \OpenExRt\Client(array(
       \OpenExRt\Client::OPTION_APP_ID => $app_id));

       $apiResponse = $client->getCurrencies();

       $apiResponse = $client->getLatest();


	   $input_symbol=$_REQUEST['input_symbol'];

	   $output_symbol=$_REQUEST['ouput_symbol'];

	   $input_amount=$_REQUEST['amount'];

	   $rates = json_decode(json_encode($apiResponse->rates), True);


	   if ($input_symbol=="USD") {

		   $output_amount=$input_amount*$rates[$output_symbol];

	   }
	   else if ($output_symbol=="USD"){

		   $output_amount=$input_amount/$rates[$input_symbol];

	  }
	  else {
		   $middle_amount=$input_amount/$rates[$input_symbol];

		   $output_amount=$middle_amount*$rates[$output_symbol];

	   }
	   echo "$output_amount";

    ?>
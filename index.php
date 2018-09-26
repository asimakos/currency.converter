
<!DOCTYPE html>
<html lang="en">
	<head>
		  <title>Currency Calculator</title>
		  <meta charset="utf-8">
		  <meta name="viewport" content="width=device-width, initial-scale=1">

		 <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
		 <link rel="stylesheet" type="text/css" href="css/font-awesome.min.css">
		 <link rel="stylesheet" type="text/css" href="css/animate.css">
		 <link rel="stylesheet" type="text/css" href="css/bootstrap.css">
		 <link rel="stylesheet" type="text/css" href="css/bootstrapValidator.css">

		 <script src="js/jquery.min.js"></script>
         <script src="js/bootstrap.min.js"></script>
         <script src="js/bootstrapValidator.js"></script>

		 <script>

         $(document).ready(function(){
                $("#currency_form").bootstrapValidator({
		             message: 'This value is not valid',

			         fields: {
				       input_amount: {
				                validators: {
				                        notEmpty: {
				                           message: 'The value can contain only numeric digits'
				                    }
				                }
				             }
				          }

		        })

		        .on('error.field.bv', function(e) {

                    $("#Calculate").prop("disabled", true);

                 })

                 .on('success.field.bv', function(e) {

                    $("#Calculate").prop("disabled", false);

                 });

                $("#Reset").click(function(){
                	 $("#currency_form").trigger("reset");
                });
			    $("#Calculate").click(function(){

                //    if ($("#currency_form").bootstrapValidator('isValid')){

				        $.post("rates.php",
				        {
				          input_symbol: $('#input_currency').val().slice(0, 3),
				          ouput_symbol: $('#output_currency').val().slice(0, 3),
				          amount:$('#input_amount').val()
				        },
				        function(currency_result,status){
				            $('#output_amount').val(currency_result);
				        })
				        .fail(function() {
	                     alert("Sorry there is an error!");
	                    })
                 //   }
			    });

			});

		</script>

	</head>
	<body>

	<?php

       require 'vendor/autoload.php';

       //API Key from https://openexchangerates.org/

       $app_id="XXXXXXXXXXXXXXXXXXXXX";

       $client = new \OpenExRt\Client(array(
       \OpenExRt\Client::OPTION_APP_ID => $app_id));

       $apiResponse = $client->getCurrencies();


    ?>

         <br>
         <br>
		<div class="container">

			<div class="alert alert-info">
		        <strong>Currency Calculator</strong>
	        </div>

            <br>

		  <form id="currency_form">

		    <div class="form-group">
		      <label for="input_amount" class="col-xs-3 control-label">Input Amount:</label>
		      <div class="col-xs-9">
		          <input type="number" class="form-control" id="input_amount" name="input_amount" min="0" step="0.1">
              </div>
            </div>

              <br>
              <br>
              <br>

            <div class="form-group">
		      <label for="input_currency" class="col-xs-3 control-label">Input Currency</label>
		      <div class="col-xs-9">
			      <select class="form-control" id="input_currency" name="input_currency">

		      <?php

		      foreach ($apiResponse as $currencyCode => $currencyName) {

		      ?>

		      <option> <?php echo $currencyCode . ': ' . $currencyName; ?></option>

		      <?php

		        }

		      ?>

		      </select>
		      </div>
		     </div>

		       <br>
               <br>

		    <div class="form-group">

	          <label for="output_currency" class="col-xs-3 control-label">Output Currency</label>
	          <div class="col-xs-9">
			      <select class="form-control" id="output_currency">

              <?php

		      foreach ($apiResponse as $currencyCode => $currencyName) {

		      ?>

		      <option> <?php echo $currencyCode . ': ' . $currencyName; ?></option>

		      <?php

		        }

		      ?>

			      </select>
		      </div>
             </div>

            <br>
		    <br>

             <div class="form-group">
              <label for="output_amount" class="col-xs-3 control-label">Output Amount:</label>
		      <div class="col-xs-9">
		          <input type="text" class="form-control" id="output_amount">

		      </div>
		    </div>

            <br>
		    <br>
            <br>
            <div class="form-group">
	             <button type="button" class="btn btn-primary" id="Calculate">Calculate</button>
	             <button type="button" class="btn btn-warning" id="Reset">Reset</button>
	        </div>
		  </form>
		</div>

	</body>
</html>
<?php

require_once("PHPMailer/class.phpmailer.php");

function send_mail($entry){
	$mail = new PHPMailer(true);
	$mail->isSMTP();
	$mail->Host = 'relay.gant.com';
	$mail->Port = 25;
	$mail->AddAddress($entry['email']);
	$mail->setFrom('andrea.lejon@gant.com', 'Gant Sample Logistics');


	ob_start();
	Array_Table(array($entry));
	$out1 = ob_get_contents();
	ob_end_clean();
	$mail->MsgHTML("<h2>Thank you for buying items from GANT's internal sale</h2>: ".$out1);


	$mail->Subject    = 'GANT\'s internal sale confirmation';

	if($mail->Send()){
	}else{
		echo "failed to send email";
	}
}

require_once("orm-static/db_classes.php");
$message = false;


$collumns = array(
/*
'2' => 'WAREHOUSE PRODUCTS',
'WAREHOUSE PRODUCTS JACKETS/BLAZERS' => 300,
'WAREHOUSE PRODUCTS SHIRTS' => 100,
'WAREHOUSE PRODUCTS PANTS/JEANS' => 200,
'WAREHOUSE PRODUCTS SHORTS' => 150,
'WAREHOUSE PRODUCTS KNITWEAR' => 200,
'WAREHOUSE PRODUCTS JERSEY' => 200,
'WAREHOUSE PRODUCTS BAGS' => 100,
'WAREHOUSE PRODUCTS WASH BAG' => 50,
'WAREHOUSE PRODUCTS CAPS' => 30,
'WAREHOUSE PRODUCTS SCARVES' => 100,
'WAREHOUSE PRODUCTS TIES' => 50,
'WAREHOUSE PRODUCTS KIDS' => 100,
*/
"0" => 'GANT INTERNAL SAMPLES',
"GANT INTERNAL SAMPLES LEATHER JACKETS" => 120,
"GANT INTERNAL SAMPLES JACKETS" => 100,
"GANT INTERNAL SAMPLES BLAZERS" => 100,
"GANT INTERNAL SAMPLES PANTS/JEANS" => 50,
"GANT INTERNAL SAMPLES DRESSES/SKIRTS" => 50,
"GANT INTERNAL SAMPLES SHIRTS/BLOUSES" => 50,
"GANT INTERNAL SAMPLES KNITWEAR" => 50,
"GANT INTERNAL SAMPLES SHORTS" => 50,
"GANT INTERNAL SAMPLES JERSEY (LONG SLEEVE)" => 50,
"GANT INTERNAL SAMPLES JERSEY (SHORT SLEEVE)" => 30,
"GANT INTERNAL SAMPLES ACC" => 20,
"GANT INTERNAL SAMPLES BAGS" => 75,
"GANT INTERNAL SAMPLES SWIMWEAR" => 50,
"GANT INTERNAL SAMPLES UNDERWEAR" => 20,
"GANT INTERNAL SAMPLES PYJAMAS" => "50",
"GANT INTERNAL SAMPLES SOCKS" => 10,
"GANT INTERNAL SAMPLES SHOES" => "300",
"GANT INTERNAL SAMPLES WATCHES" => "50",
'1' => 'KIDS GANT INTERNAL SAMPLES',
"KIDS GANT INTERNAL SAMPLES CLOTHES" => 50,
"KIDS GANT INTERNAL SAMPLES ACC" => 20,
"KIDS GANT INTERNAL SAMPLES SOCKS" => 10,
/*
'2' => 'OTHER BRANDS SAMPLES',
"OTHER BRANDS SAMPLES LEATHER JACKETS" => 200,
"OTHER BRANDS SAMPLES JACKETS" => 150,
"OTHER BRANDS SAMPLES BLAZERS" => 100,
"OTHER BRANDS SAMPLES PANTS/JEANS" => 100,
"OTHER BRANDS SAMPLES DRESSES/SKIRTS" => 100,
"OTHER BRANDS SAMPLES SHIRTS/BLOUSES" => 80,
"OTHER BRANDS SAMPLES KNITWEAR" => 80,
"OTHER BRANDS SAMPLES SHORTS" => 50,
"OTHER BRANDS SAMPLES JERSEY (LONG SLEEVE)" => 50,
"OTHER BRANDS SAMPLES JERSEY (SHORT SLEEVE)" => 30,
"OTHER BRANDS SAMPLES ACC" => 30,
"OTHER BRANDS SAMPLES BAGS" => 80,
"OTHER BRANDS SAMPLES SWIMWEAR" => 30,
"OTHER BRANDS SAMPLES UNDERWEAR" => 20,
"OTHER BRANDS SAMPLES SOCKS" => 10,
'3' => 'KIDS OTHER BRANDS SAMPELS',
"KIDS OTHER BRANDS SAMPELS CLOTHES" => 60,
"KIDS OTHER BRANDS SAMPELS ACC" => 20,
"KIDS OTHER BRANDS SAMPELS SOCKS" => 10,
*/
'9' => 'GANT PROPS',
"GANT PROPS SMALL" => "20",
"GANT PROPS MEDIUM" => "50",
"GANT PROPS LARGE" => "100",
);

$home_collumns = array(
"BEDSPREAD" => "300",
"BLANKETS" => "200",
"DUVET COVER" => "300",
"UNDERSHEET" => "100",
"CUSHION COVER" => "100",
"PILLOW CASE" => "100",
"TOWEL (BIG) " => "80",
"TOWEL (SMALL)" => "30",
"BATH MATH" => "200",
"BATHROBE" => "200",
"SLIPPERS" => "20",
"OTHERS" => "50",
	
);

if(isset($_POST['entry'])){

	$res_file = 'result.csv';
	$Split = ";";

	$outstream = fopen($res_file, 'a');

	$_POST['entry']['submition_date'] = date("Y-m-d H:i:s");

	if(filesize($res_file) == 0){
		$KeysPrint = array_keys($_POST['entry']);
		fputcsv($outstream, $KeysPrint, $Split, '"');
	}
	fputcsv($outstream, $_POST['entry'], $Split, '"');
	fclose($outstream);
	send_mail($_POST['entry']);

	$message = "Your entry has been saved, thank you!";
}
?><!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->

	<title>Internal sale form</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
	<style>
	
	@font-face {
		font-family: "GantModern";
		font-style: normal;
		font-weight: 700;
		src: url("/assets/fonts/GantModern-Regular.ttf");
	}
	body{
		font-family: "GantModern";
		background-image:url('GANT_FW18_SEASONAL_OCT2.jpg');
		/*background-image:url('sale_tool_bg.jpg');*/
		background-repeat: no-repeat;
		background-size: cover;
	}
	.cont{
		background-color: rgba(255, 255, 255, 0.6);
	}
	</style>
    <!-- Bootstrap -->

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
              <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

	<script>
	function validate(){
		
		if(document.getElementById('name').value == ""){
			alert("Fill in your name first.");
			return false;
		}
		if(document.getElementById('email').value.indexOf("@") == -1){
			alert("Fill in valid email");
			return false;
		}
		if(confirm('Are you sure that you want to submit?')){
			return true;
		}
		return false;
	}
	</script>
  </head>
  <body>
	<div class="container cont">
		<form method="post">
			<input type="hidden" name="entry[fill_date]" value="<?= date("Y-m-d H:i:s") ?>">
			<div class="row">
				<div class="col-md-12">
					<h1>Internal sale form</h1>
<?php if($message){ ?>
<div class="alert alert-success"><?= $message ?></div>
<?php } ?>

					<div class="form-group">
						<label>NAME</label>
						<input id="name" type="text" class="form-control" name="entry[name]">
					</div>
					<div class="form-group">
						<label>EMAIL</label>
						<input id="email" type="email" class="form-control" name="entry[email]">
					</div>
					<div class="row">
						<div class="col-md-6 gant">
							<h2>GANT</h2>
<?php
$remove = "";
foreach($collumns AS $column => $price){
if(is_numeric($column)){
$remove = $price;
?>
<br>
<hr>
<br>
<h3><?= $price ?></h3>
<?php
}else{
$vis_col = substr($column, strlen($remove));
?>

							<div class="form-group">
								<label><?= $vis_col.' '.$price.' SEK' ?></label>
								<input type="number" placeholder="qty" class="form-control" name="entry[<?= $column ?>]" price="<?= $price ?>">
							</div>
<?php }} ?>
<br>
<hr>
<br>
<h3>Total</h3>
						</div>
						<div class="col-md-6 home">
							<h2>HOME</h2>
<br>
<hr>
<br>
<h3>HOME INTERNAL SAMPLES</h3>
<?php foreach($home_collumns AS $column => $price){ ?>
							<div class="form-group">
								<label><?= $column.' '.$price.' SEK' ?></label>
								<input type="number" placeholder="qty" class="form-control" name="entry[<?= $column ?>]" price="<?= $price ?>">
							</div>
<?php } ?>
<br>
<hr>
<br>
						</div>
					</div>
					<div>
							<div class="form-group">
								<label>Swish amount to 123-4642708</label>
								<input type="number" id="total" class="form-control" readonly name="entry[total_gant]">
							</div>
					</div>
					<div class="alert alert-warning">Please note: All items are sold in existing condition. No claims can be made in GANT stores or to GANT Claims Department.
						<br>Make sure that all returns are made before submiting this form.</div>
					<div class="text-center">
					<button onclick="return validate();" type="submit" class="btn btn-success">send</button>
					</div>
				</div>
			</div>
		</form>
		<br>
	</div>

	<script>
		function calc_total(){
			var cols = ['gant', 'home'];
			tot = 0;
			for(x in cols){
				th = cols[x];
				$('.'+th+' input[type="number"]').each(function(i,elm){
					price = $(elm).attr('price');
					var val =  parseInt(elm.value);
					//console.log(val, price)
					if(!isNaN(val) && !isNaN(price)){//Ignore the total input and unfilled inputs
						tot += val*price;
					}
				});
			}
			$('#total').val(tot);
		}
		setInterval(calc_total, 500);
	</script>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  </body>
</html>

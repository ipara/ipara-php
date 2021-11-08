<?php include('menu.php');?>

<form action="" method="post" class="form-horizontal">
	<fieldset>

		<!-- Form Name -->
		<legend>İade Sorgulama</legend>

		<!-- Text input-->
		<div class="form-group">
			<label class="col-md-4 control-label" for="">Sipariş Numarası:</label>
			<div class="col-md-4">
				<input name="orderId" type="text" value="020B7175-999D-4873-8734-59E1FCAD3C9C"
					class="form-control input-md" required="">

			</div>
		</div>
        <!-- Text input-->
		<div class="form-group">
			<label class="col-md-4 control-label" for="">Tutar</label>
			<div class="col-md-4">
				<input id="amount" name="amount" type="text" placeholder=""
					value="<?php echo ($_POST['amount']) ? $_POST['amount'] : '100'; ?>" class="form-control input-md" required="">
					<label style="font-weight:normal; font-size:small">*Sipariş tutarı kuruş ayracı olmadan gönderilmelidir. Örneğin; 1 TL 100, 12 1200, 130 13000, 1.05 105, 1.2 120 olarak gönderilmelidir.</label>
			</div>
		</div>
		<!-- Button -->
		<div class="form-group">
			<label class="col-md-4 control-label" for=""></label>
			<div class="col-md-4">
				<button type="submit" id="" name="" class="btn btn-success">Sorgula</button>
			</div>
		</div>

	</fieldset>
</form>


<?php
if (!empty($_POST)):

   /*
	*	Setting ayarlarımızı alıyoruz.
	*	Formdan gelen bilgilerle PaymentRefundInquiryRequest sınıfımızı dolduruyoruz
	*	PaymentRefundInquiryRequest ve Setting ayarlarımızla sayfamızı post ediyoruz.
	*/

$settings = new Settings();
$request = new PaymentRefundInquiryRequest();
$request->orderId = $_POST["orderId"];
$request->amount  =$_POST["amount"];;
$request->clientIp=Helper::get_client_ip();
$response=PaymentRefundInquiryRequest::execute($request,$settings); 
$output = Helper::formattoJSONOutput($response); 

print "<h3>Sonuç:</h3>";
echo "<pre>";
echo htmlspecialchars($output); 
echo "</pre>";


?>
    <?php endif; ?>


<?php include('footer.php');?>

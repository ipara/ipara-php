<?php include('menu.php');?>

<form action="" method="post" class="form-horizontal">
	<fieldset>

		<!-- Form Name -->
		<legend>Bin Sorgulama</legend>

		<!-- Text input-->
		<div class="form-group">
			<label class="col-md-4 control-label" for="binNumber">Bin Numarası</label>
			<div class="col-md-4">
				<input id="binNumber" name="binNumber" type="text" placeholder=""
					value="<?php echo ($_POST['binNumber']) ? $_POST['binNumber'] : '545616'; ?>" class="form-control input-md" required="">

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

<br />

<?php
if (!empty($_POST)) {
	/*
	*	Setting ayarlarımızı alıyoruz.
	*	Bin numarası Kredi Kartının üzerindeki ilk 6 hanedir.
	*	Formdan gelen bilgi ile bin numarasını ve Setting ayarlarımızı post ediyoruz.
	*/
	$settings = new Settings ();
	
	$request = new BinNumberInquiryRequest ();
	$request->binNumber = $_POST ["binNumber"];
	$response = BinNumberInquiryRequest::execute ( $request, $settings ); // Bin sorgulama servisinin başlatıldığı kısım

	$output = Helper::formattoJSONOutput( $response );  //bin sorgulama servisi sonucunda oluşan servis çıktı parametrelerinin gösterildiği kısım.
	
	print "<h3>Sonuç:</h3>";
	echo "<pre>";
	echo htmlspecialchars ($output);
	echo "</pre>";
}

include('footer.php');
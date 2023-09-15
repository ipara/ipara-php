<?php include('menu.php');?>


<fieldset>
	<legend>
		<label style="font-weight: bold; width: 250px;">Sepet Bilgileri</label>
	</legend>
	<table class="table">
		<thead>
			<tr>
				<th>Ürün</th>
				<th>Kod</th>
				<th>Adet</th>
				<th>Birim Fiyat</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td>Telefon</td>
				<td>TLF0001</td>
				<td>1</td>
				<td>50.00 TL</td>
			</tr>
			<tr>
				<td>Bilgisayar</td>
				<td>BLG0001</td>
				<td>1</td>
				<td>50.00 TL</td>
			</tr>

			<tr>
				<td colspan="3">Toplam Tutar</td>

				<td>100.00 TL</td>
			</tr>
		</tbody>
	</table>
</fieldset>
<fieldset>
	<legend>
		<label style="font-weight: bold; width: 250px;">Kargo Adresi Bilgileri</label>
	</legend>
	<label style="font-weight: bold;">Ad :</label> Murat<br> <label
		style="font-weight: bold;">Soyad :</label> Kaya <br> <label
		style="font-weight: bold;">Adres :</label> Mevlüt Pehlivan Mah.
	Multinet Plaza Şişli <br> <label style="font-weight: bold;">Posta Kodu
		:</label> 34782 <br> <label style="font-weight: bold;">Şehir :</label>
	İstanbul <br> <label style="font-weight: bold;">Ülke :</label> Türkiye
	<br> <label style="font-weight: bold;">Telefon Numarası:</label>
	2123886600 <br>
</fieldset>
<fieldset>
	<legend>
		<label style="font-weight: bold; width: 250px;">Fatura Adresi
			Bilgileri</label>
	</legend>
	<label style="font-weight: bold;">Ad :</label> Murat<br> <label
		style="font-weight: bold;">Soyad :</label> Kaya<br> <label
		style="font-weight: bold;">Adres :</label> Mevlüt Pehlivan Mah.
	Multinet Plaza Şişli<br> <label style="font-weight: bold;">Posta Kodu :</label>
	34782<br> <label style="font-weight: bold;">Şehir :</label> İstanbul<br>
	<label style="font-weight: bold;">Ülke :</label> Türkiye<br> <label
		style="font-weight: bold;">TC Kimlik Numarası :</label> 1234567890<br>
	<label style="font-weight: bold;">Telefon Numarası:</label> 2123886600<br>
	<label style="font-weight: bold;">Vergi Numarası :</label> 123456<br> <label
		style="font-weight: bold;">Vergi Dairesi Adı :</label> Kozyatağı<br> <label
		style="font-weight: bold;">Firma Adı:</label> iPara
</fieldset>
<form action="" method="post" class="form-horizontal">
	<fieldset>

		<!-- Form Name -->
		<legend>
			<label style="font-weight: bold; width: 250px;">Checkout Form Bilgileri</label>
		</legend>

		<label style="font-weight: bold;">Threed :</label> false<br>
        <label style="font-weight: bold;">Amount :</label> 100000<br>
        <label style="font-weight: bold;">Allowed Installments :</label> 1,2,3,4,5,6,7,8,9,10,11,12<br>
        <label style="font-weight: bold;">CallbackUrl :</label> https://apitest.ipara.com/rest/payment/threed/test/result
        <br>

	</fieldset>

	<!-- Button -->
	<div class="form-group">
		<label class="col-md-4 control-label" for=""></label>
		<div class="col-md-4">
			<button type="submit" id="" name="" class="btn btn-success">Checkout Formu Oluştur</button>
		</div>
	</div>
</form>


<?php if (!empty($_POST)): ?>
<?php

	$settings = new Settings ();
	
	$request = new CheckoutFormCreateRequest ();
	$request->OrderId = Helper::Guid ();
	$request->Echo = "Echo";
	$request->Mode = $settings->Mode;
	$request->Amount = "10000"; // 100 tL
	$request->Threed = "false";
	$request->CallbackUrl = "https://apitest.ipara.com/rest/payment/threed/test/result";           
	$request->VendorId = "10100";
	$request->AllowedInstallments = ["1", "2", "3", "4", "5", "6", "7", "8", "9", "10", "11", "12"];
	
	// region Sipariş veren bilgileri
	$request->Purchaser = new Purchaser ();
	$request->Purchaser->Name = "Murat";
	$request->Purchaser->SurName = "Kaya";
	$request->Purchaser->BirthDate = "1986-07-11";
	$request->Purchaser->Email = "murat@kaya.com";
	$request->Purchaser->GsmPhone = "5881231212";
	$request->Purchaser->IdentityNumber = "1234567890";
	$request->Purchaser->ClientIp = Helper::get_client_ip ();
	// endregion
	
	// region Fatura bilgileri
	
	$request->Purchaser->InvoiceAddress = new PurchaserAddress ();
	$request->Purchaser->InvoiceAddress->Name = "Murat";
	$request->Purchaser->InvoiceAddress->SurName = "Kaya";
	$request->Purchaser->InvoiceAddress->Address = "Mevlüt Pehlivan Mah-> Multinet Plaza Şişli";
	$request->Purchaser->InvoiceAddress->ZipCode = "34782";
	$request->Purchaser->InvoiceAddress->CityCode = "34";
	$request->Purchaser->InvoiceAddress->IdentityNumber = "1234567890";
	$request->Purchaser->InvoiceAddress->CountryCode = "TR";
	$request->Purchaser->InvoiceAddress->TaxNumber = "123456";
	$request->Purchaser->InvoiceAddress->TaxOffice = "Kozyatağı";
	$request->Purchaser->InvoiceAddress->CompanyName = "iPara";
	$request->Purchaser->InvoiceAddress->PhoneNumber = "2122222222";
	// endregion
	
	// region Kargo Adresi bilgileri
	$request->Purchaser->ShippingAddress = new PurchaserAddress ();
	$request->Purchaser->ShippingAddress->Name = "Murat";
	$request->Purchaser->ShippingAddress->SurName = "Kaya";
	$request->Purchaser->ShippingAddress->Address = "Mevlüt Pehlivan Mah-> Multinet Plaza Şişli";
	$request->Purchaser->ShippingAddress->ZipCode = "34782";
	$request->Purchaser->ShippingAddress->CityCode = "34";
	$request->Purchaser->ShippingAddress->IdentityNumber = "1234567890";
	$request->Purchaser->ShippingAddress->CountryCode = "TR";
	$request->Purchaser->ShippingAddress->PhoneNumber = "2122222222";
	// endregion
	
	// region Ürün bilgileri
	$request->Products = array ();
	$p = new Product ();
	$p->Title = "Telefon";
	$p->Code = "TLF0001";
	$p->Price = "5000";
	$p->Quantity = 1;
	$request->Products [0] = $p;
	
	$p = new Product ();
	$p->Title = "Bilgisayar";
	$p->Code = "BLG0001";
	$p->Price = "5000";
	$p->Quantity = 1;
	$request->Products [1] = $p;
	
	// endregion
	
	$response = CheckoutFormCreateRequest::execute ( $request, $settings ); 
	$output = Helper::formattoJSONOutput($response);
	print "<h3>Sonuç:</h3>";
	echo "<pre>";
	echo htmlspecialchars($output);
	echo "</pre>";
	
	?>
    <?php endif; ?>

<?php include('footer.php');?>
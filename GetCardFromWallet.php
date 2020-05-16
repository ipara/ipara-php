<?php include('menu.php');?>



<form action="" method="post" class="form-horizontal">
    <fieldset>

        <!-- Form Name -->
        <legend>Cüzdandaki Kartları Listele</legend>

        <!-- Text input-->
        <div class="form-group">
            <label class="col-md-4 control-label" for="">Kullanıcı Id:</label>
            <div class="col-md-4">
                <input name="userId" type="text" value="123456" class="form-control input-md" required="">

            </div>
        </div>
        <div class="form-group">
            <label class="col-md-4 control-label" for=""> Kart ID (Opsiyonel):</label>
            <div class="col-md-4">
                <input value="<?php echo ($_POST['cardId']) ? $_POST['cardId'] : ''; ?>" name="cardId" class="form-control input-md" >

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
$settings = new Settings();

	/*
	*   Cüzdandaki kartları listelemek için kullanıclan sayfadır.
	*	Setting ayarlarımızı alıyoruz.
	*	Formdan gelen bilgilerle BankCardInquiryRequest sınıfımızı dolduruyoruz
	*	BankCardInquiryRequest ve Setting ayarlarımızla sayfamızı post ediyoruz.
	*/
$request = new BankCardInquiryRequest();
$request->userId = $_POST["userId"];
$request->cardId =  $_POST["cardId"];
$request->clientIp=Helper::get_client_ip();
$response=BankCardInquiryRequest::execute($request,$settings); // Cüzdandaki kartları listelemek için servis çağrısının yapıldığı kısımdır.
$output = Helper::formattoJSONOutput($response);//Cüzdandaki ekranları listeleme için yapılan çağrı sonucu oluşan servis çıktı parametrelerinin ekranda göstermemize olanak sağlandığı kısımdır.

print "<h3>Sonuç:</h3>";
echo "<pre>";
echo htmlspecialchars($output); 
echo "</pre>";


?>
    <?php endif; ?>


<?php include('footer.php');?>
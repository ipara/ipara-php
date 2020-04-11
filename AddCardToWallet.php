<?php include('menu.php');?>

<form action="" method="post" class="form-horizontal">
    <fieldset>

        <!-- Form Name -->
        <legend>Cüzdana Kart Ekleme</legend>

        <!-- Text input-->
        <div class="form-group">
            <label class="col-md-4 control-label" for="">Kullanıcı Id:</label>
            <div class="col-md-4">
                <input name="userId" type="text" value="123456" class="form-control input-md" required="">

            </div>
        </div>
        <div class="form-group">
            <label class="col-md-4 control-label" for="">Kart Sahibi Adı Soyadı:</label>
            <div class="col-md-4">
                <input  value="Kart Sahibi Ad Soyad" name="nameSurname" class="form-control input-md" required="">

            </div>
        </div>
        <div class="form-group">
            <label class="col-md-4 control-label" for="">  Kart Numarası:</label>
            <div class="col-md-4">
                <input value="5456165456165454" name="cardNumber"  class="form-control input-md" required="">

            </div>
        </div>
        <div class="form-group">
            <label class="col-md-4 control-label" for="">  Kart Kısa Adı: </label>
            <div class="col-md-4">
                <input  value="Maas Karti" name="cardAlias"  class="form-control input-md" required="">

            </div>
        </div>
        <div class="form-group">
            <label class="col-md-4 control-label" for="">  Son Kullanma Tarihi Ay/Yıl: </label>
            <div class="col-md-4">
                <input value="12" name="month"  class="form-control input-md" width="50px" required="">
                <input value="24" name="year"  class="form-control input-md" width="50px" required="">

            </div>
        </div>
       

        <!-- Button -->
        <div class="form-group">
            <label class="col-md-4 control-label" for=""></label>
            <div class="col-md-4">
                <button type="submit" id="" name="" class="btn btn-success">Kart Ekle</button>
            </div>
        </div>

    </fieldset>
</form>



<?php
if (!empty($_POST)):

    /*
 * Cüzdana kart ekleme servisi için gerekli olan parametrelerin doldurulduğu kısımdır.
 * setting ayarlarımızı alıp BankCardCreateRequest alanlarının formdan gelen verilere göre doldurulup post edildiği kısımdır.
*/

$settings = new Settings();

$request = new BankCardCreateRequest();
$request->userId = $_POST["userId"];
$request->cardOwnerName  =$_POST["nameSurname"];;
$request->cardNumber =$_POST["cardNumber"];
$request->cardAlias =$_POST["cardAlias"];
$request->cardExpireMonth  =$_POST["month"];
$request->cardExpireYear  =$_POST["year"];
$request->clientIp=Helper::get_client_ip();
$response=BankCardCreateRequest::execute($request,$settings); //Cüzdana kart ekleme servisi için istek çağrısının yapıldığı kısımdır.
$output = Helper::formattoJSONOutput($response); //Cüzdana kart eklemesi sonucu oluşan servis çıktı parametrelerini ekrana yazdırmaya olanak sağlayan kısımdır.

print "<h3>Sonuç:</h3>";
echo "<pre>";
echo htmlspecialchars($output); 
echo "</pre>";


?>
    <?php endif; ?>


<?php include('footer.php');?>
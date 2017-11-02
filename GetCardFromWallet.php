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
                <input value="" name="cardId" class="form-control input-md" >

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


<?php if (!empty($_POST)): ?>
<?php 
$settings = new Settings();


$request = new BankCardInquiryRequest();
$request->userId = $_POST["userId"];
$request->cardId =  $_POST["cardId"];
$request->clientIp=Helper::get_client_ip();
$response=BankCardInquiryRequest::execute($request,$settings);
$output = Helper::formattoJSONOutput($response);

print "<h3>Sonuç:</h3>";
echo "<pre>";
echo htmlspecialchars($output); 
echo "</pre>";


?>
    <?php endif; ?>


<?php include('footer.php');?>
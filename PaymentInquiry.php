<?php include('menu.php');?>

<form action="" method="post" class="form-horizontal">
    <fieldset>

        <!-- Form Name -->
        <legend>Ödeme Sorgulama</legend>

        <!-- Text input-->
        <div class="form-group">
            <label class="col-md-4 control-label" for="">Sipariş Numarası:</label>
            <div class="col-md-4">
                <input name="orderId" type="text" value="58e1e9f22690b" class="form-control input-md" required="">

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

$request = new PaymentInquiryRequest();
$request->orderId = $_POST["orderId"];
$request->Echo= "Echo";
$request->Mode = settings.Mode;
$response=PaymentInquiryRequest::execute($request,$settings);


print "<h3>Sonuç:</h3>";
echo "<pre>";
echo htmlspecialchars($response); 
echo "</pre>";


?>
    <?php endif; ?>


<?php include('footer.php');?>

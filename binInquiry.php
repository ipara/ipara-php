

<?php include('menu.php');?>

<form action="" method="post" class="form-horizontal">
    <fieldset>

        <!-- Form Name -->
        <legend>Bin Sorgulama</legend>

        <!-- Text input-->
        <div class="form-group">
            <label class="col-md-4 control-label" for="binNumber">Bin Numarası</label>
            <div class="col-md-4">
                <input id="binNumber" name="binNumber" type="text" placeholder="" value="492130" class="form-control input-md" required="">

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

<br/>

<?php if (!empty($_POST)): ?>
<?php 
$settings = new Settings();

$request = new BinNumberInquiryRequest();
$request->binNumber=$_POST["binNumber"];
$response=BinNumberInquiryRequest::execute($request,$settings);

print "<h3>Sonuç:</h3>";
echo "<pre>";
echo htmlspecialchars($response); 
echo "</pre>";


?>
    <?php endif; ?>


<?php include('footer.php');?>
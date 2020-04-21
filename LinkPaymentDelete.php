<?php include('menu.php');?>

<form action="" method="post" class="form-horizontal">
    <fieldset>

        <!-- Form Name -->
        <legend>Link İle Ödeme (Link Silme)</legend>

        <div class="form-group">
            <label class="col-md-4 control-label" for="">Ödeme Linki ID : </label>
            <div class="col-md-4">
                <input value="<?php echo isset($_POST['linkId']) ? $_POST['linkId'] : ''; ?>" name="linkId"  class="form-control input-md">

            </div>
        </div>

        <!-- Button -->
        <div class="form-group">
            <label class="col-md-4 control-label" for=""></label>
            <div class="col-md-4">
                <button type="submit" id="" name="" class="btn btn-success">Ödeme Linkini Sil</button>
            </div>
        </div>

    </fieldset>
</form>

<?php

if (!empty($_POST)) {
    $settings = new Settings();
    $linkPaymentRequest = new LinkPaymentDeleteRequest($_POST['linkId']);
    $response = $linkPaymentRequest->execute($settings);
    $output = Helper::formattoJSONOutput($response);

    print "<h3>Sonuç:</h3>";
    echo "<pre>";
    echo htmlspecialchars($output);
    echo "</pre>";
}

include('footer.php');
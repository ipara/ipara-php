<?php include('menu.php');?>

<form action="" method="post" class="form-horizontal">
    <fieldset>

        <!-- Form Name -->
        <legend>Link İle Ödeme (Link Sorgulama)</legend>

        <div class="form-group">
            <label class="col-md-4 control-label" for="">Müşteri Eposta : </label>
            <div class="col-md-4">
                <input value="<?php echo isset($_POST['email']) ? $_POST['email'] : 'mail@example.com'; ?>" name="email"  class="form-control input-md">

            </div>
        </div>
        <div class="form-group">
            <label class="col-md-4 control-label" for="">Müşteri Cep Telefonu : </label>
            <div class="col-md-4">
                <input  value="<?php echo isset($_POST['gsm']) ? $_POST['gsm'] : ''; ?>" name="gsm"  class="form-control input-md">

            </div>
        </div>
        <div class="form-group">
            <label class="col-md-4 control-label" for="">Link Durumu : </label>
            <div class="col-md-4">
                <select name="linkState" class="form-control">
                    <option value="-1" <?php echo (isset($_POST['linkState']) && $_POST['linkState'] == '-1') ? 'selected' : ''; ?>>Seçiniz</option>
                    <option value="0" <?php echo (isset($_POST['linkState']) && $_POST['linkState'] == '0') ? 'selected' : ''; ?>>Link İsteği Alındı</option>
                    <option value="1" <?php echo (isset($_POST['linkState']) && $_POST['linkState'] == '1') ? 'selected' : ''; ?>>Link URL’i yaratıldı</option>
                    <option value="2" <?php echo (isset($_POST['linkState']) && $_POST['linkState'] == '2') ? 'selected' : ''; ?>>Link Gönderildi, Ödeme Bekleniyor</option>
                    <option value="3" <?php echo (isset($_POST['linkState']) && $_POST['linkState'] == '3') ? 'selected' : ''; ?>>Link ile Ödeme Başarılı</option>
                    <option value="98" <?php echo (isset($_POST['linkState']) && $_POST['linkState'] == '98') ? 'selected' : ''; ?>>Link Zaman Aşımına Uğradı</option>
                    <option value="99" <?php echo (isset($_POST['linkState']) && $_POST['linkState'] == '99') ? 'selected' : ''; ?>>Link Silindi</option>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-4 control-label" for="">Link Oluşturma Alanına Ait Arama Başlangıç Tarihi * : </label>
            <div class="col-md-4 form-inline">
                <input value="<?php echo isset($_POST['start_day']) ? $_POST['start_day'] : date('d'); ?>" name="start_day" class="form-control input-md" style="width: 80px; text-align: center;" maxlength="2" required="required">
                <input value="<?php echo isset($_POST['start_month']) ? $_POST['start_month'] : date('m'); ?>" name="start_month" class="form-control input-md" style="width: 80px; text-align: center;" maxlength="2" required="required">
                <input value="<?php echo isset($_POST['start_year']) ? $_POST['start_year'] : date('Y'); ?>" name="start_year" class="form-control input-md" style="width: 112px; text-align: center;" maxlength="4" required="required">

            </div>
        </div>
        <div class="form-group">
            <label class="col-md-4 control-label" for="">Link Oluşturma Alanına Ait Arama Başlangıç Tarihi * : </label>
            <div class="col-md-4 form-inline">
                <input value="<?php echo isset($_POST['end_day']) ? $_POST['end_day'] : date('d'); ?>" name="end_day" class="form-control input-md" style="width: 80px; text-align: center;" maxlength="2" required="required">
                <input value="<?php echo isset($_POST['end_month']) ? $_POST['end_month'] : date('m'); ?>" name="end_month" class="form-control input-md" style="width: 80px; text-align: center;" maxlength="2" required="required">
                <input value="<?php echo isset($_POST['end_year']) ? $_POST['end_year'] : date('Y'); ?>" name="end_year" class="form-control input-md" style="width: 112px; text-align: center;" maxlength="4" required="required">

            </div>
        </div>

        <div class="form-group">
            <label class="col-md-4 control-label" for="">Ödeme Linki ID : </label>
            <div class="col-md-4">
                <input value="<?php echo isset($_POST['linkId']) ? $_POST['linkId'] : null; ?>" name="linkId"  class="form-control input-md">

            </div>
        </div>
        <div class="form-group">
            <label class="col-md-4 control-label" for="">Toplam Gösterilebilecek Sayfa Sayısı * : </label>
            <div class="col-md-4">
                    <select name="pageSize" class="form-control">
                        <?php
                        $out = '';
                        for ($page = 5; $page <= 15; $page++) {
                            $out .= "<option ";
                            $out .= (isset($_POST['pageSize']) && $_POST['pageSize'] == $page) ? 'selected' : '';
                            $out .= ">$page</option>";
                        }
                        echo $out;
                        ?>
                    </select>
            </div>
        </div>

        <div class="form-group">
            <label class="col-md-4 control-label" for="">Gösterilecek Sayfa Numarası * : </label>
            <div class="col-md-4">
                <input  value="<?php echo isset($_POST['pageIndex']) ? $_POST['pageIndex'] : '1'; ?>" name="pageIndex"  class="form-control input-md" required="required">

            </div>
        </div>
        <!-- Button -->
        <div class="form-group">
            <label class="col-md-4 control-label" for=""></label>
            <div class="col-md-4">
                <button type="submit" id="" name="" class="btn btn-success">Ödeme Linklerini Listele</button>
            </div>
        </div>

    </fieldset>
</form>



<?php

if (!empty($_POST)) {
    $settings = new Settings();

    $requestData = [
        "email" => $_POST['email'],
        "gsm" => $_POST['gsm'],
        "linkState" => ($_POST['linkState'] > -1) ? $_POST['linkState'] : null,
        "startDate" => date ( "Y-m-d H:i:s", mktime(00, 00, 00, $_POST['start_month'], $_POST['start_day'], $_POST['start_year'])),
        "endDate" => date ( "Y-m-d H:i:s", mktime(23, 59, 59, $_POST['end_month'], $_POST['end_day'], $_POST['end_year'])),
        "pageSize" => $_POST['pageSize'],
        "pageIndex" => $_POST['pageIndex']
    ];

    $linkPaymentRequest = new LinkPaymentListRequest($requestData);
    $response = $linkPaymentRequest->execute($settings);
    $output = Helper::formattoJSONOutput($response);

    print "<h3>Sonuç:</h3>";
    echo "<pre>";
    echo htmlspecialchars($output);
    echo "</pre>";
}

include('footer.php');
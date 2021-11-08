<?php include('menu.php');?>

<form action="" method="post" class="form-horizontal">
    <fieldset>

        <!-- Form Name -->
        <legend>Link İle Ödeme (Link Gönderim)</legend>

        <!-- Text input-->
        <div class="form-group">
            <label class="col-md-4 control-label" for="">Müşteri Adı * :</label>
            <div class="col-md-4">
                <input name="name" type="text" value="<?php echo isset($_POST['name']) ? $_POST['name'] : 'Müşteri Ad'; ?>" class="form-control input-md" required="required">

            </div>
        </div>
        <div class="form-group">
            <label class="col-md-4 control-label" for="">Müşteri Soyadı * :</label>
            <div class="col-md-4">
                <input name="surname" value="<?php echo isset($_POST['surname']) ? $_POST['surname'] : 'Müşteri Soyad'; ?>" class="form-control input-md" required="required">

            </div>
        </div>
        <div class="form-group">
            <label class="col-md-4 control-label" for="">Müşteri T.C. kimlik Numarası:</label>
            <div class="col-md-4">
                <input name="tcCertificate" value="<?php echo isset($_POST['tcCertificate']) ? $_POST['tcCertificate'] : ''; ?>"  class="form-control input-md">

            </div>
        </div>
        <div class="form-group">
            <label class="col-md-4 control-label" for="">Müşteri vergi Numarası: </label>
            <div class="col-md-4">
                <input  value="<?php echo isset($_POST['taxNumber']) ? $_POST['taxNumber'] : ''; ?>" name="taxNumber"  class="form-control input-md">

            </div>
        </div>
        <div class="form-group">
            <label class="col-md-4 control-label" for="">Müşteri Eposta * : </label>
            <div class="col-md-4">
                <input value="<?php echo isset($_POST['email']) ? $_POST['email'] : 'mail@example.com'; ?>" name="email"  class="form-control input-md" required="required">

            </div>
        </div>
        <div class="form-group">
            <label class="col-md-4 control-label" for="">Müşteri Cep Telefonu * : </label>
            <div class="col-md-4">
                <input  value="<?php echo isset($_POST['gsm']) ? $_POST['gsm'] : '5881231212'; ?>" name="gsm"  class="form-control input-md" required="required">

            </div>
        </div>
        <div class="form-group">
            <label class="col-md-4 control-label" for="">Tahsil Edilecek Tutar (TL) * : </label>
            <div class="col-md-4">
                <input  value="<?php echo isset($_POST['amount']) ? ($_POST['amount']) : '10'; ?>" name="amount"  class="form-control input-md" required="">
                <label style="font-weight:normal; font-size:small">*Sipariş tutarı kuruş ayracı olmadan gönderilmelidir. Örneğin; 1 TL 100, 12 1200, 130 13000, 1.05 105, 1.2 120 olarak gönderilmelidir.</label>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-4 control-label" for="">3D Secure * : </label>
            <div class="col-md-4">
                <select name="threeD" class="form-control">
                    <option value="true" <?php echo (isset($_POST['threeD']) && $_POST['threeD'] == 'true') ? 'selected' : ''; ?>>Evet</option>
                    <option value="false" <?php echo (isset($_POST['threeD']) && $_POST['threeD'] == 'false') ? 'selected' : ''; ?>>Hayır</option>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-4 control-label" for="">Link Geçerlilik Süresi (Gün/Ay/Yıl) * : </label>
            <div class="col-md-4 form-inline">
                <input value="<?php echo isset($_POST['day']) ? $_POST['day'] : date('d'); ?>" name="day" class="form-control input-md" style="width: 80px; text-align: center;" maxlength="2" required="required">
                <input value="<?php echo isset($_POST['month']) ? $_POST['month'] : date('m'); ?>" name="month" class="form-control input-md" style="width: 80px; text-align: center;" maxlength="2" required="required">
                <input value="<?php echo isset($_POST['year']) ? $_POST['year'] : date('Y'); ?>" name="year" class="form-control input-md" style="width: 112px; text-align: center;" maxlength="4" required="required">

            </div>
        </div>
        <div class="form-group">
            <label class="col-md-4 control-label" for="">Ödemenin Yapılabileceği Taksitlerin Listesi
                (Birden çok seçilebilir): </label>
            <div class="col-md-4">
                    <select multiple="multiple" class="form-control" name="installmentList[]">
                        <?php
                        for ($installment = 2; $installment <= 12; $installment++) {
                            $out .= "<option ";
                            $out .= ($_POST['installmentList'] && in_array($installment, $_POST['installmentList'])) ? 'selected' : '';
                            $out .= ">$installment</option>";
                        }
                        echo $out;
                        ?>
                    </select>
            </div>
        </div>

        <div class="form-group">
            <label class="col-md-4 control-label" for="">Müşteriye Bilgilendirme Mailli Gönder * : </label>
            <div class="col-md-4">
                <select name="sendEmail" class="form-control">
                    <option value="true" <?php echo (isset($_POST['sendEmail']) && $_POST['sendEmail'] == 'true') ? 'selected' : ''; ?>>Evet</option>
                    <option value="false" <?php echo (isset($_POST['sendEmail']) && $_POST['sendEmail'] == 'false') ? 'selected' : ''; ?>>Hayır</option>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-4 control-label" for="">Komisyon Kime Yansıtılacak : </label>
            <div class="col-md-4">
                <select name="commissionType" class="form-control">
                    <option value="0" <?php echo (isset($_POST['commissionType']) && $_POST['commissionType'] == '0') ? 'selected' : ''; ?>>Seçiniz</option>
                    <option value="1" <?php echo (isset($_POST['commissionType']) && $_POST['commissionType'] == '1') ? 'selected' : ''; ?>>Satıcı (Varsayılan)</option>
                    <option value="2" <?php echo (isset($_POST['commissionType']) && $_POST['commissionType'] == '2') ? 'selected' : ''; ?>>Müşteri</option>
                </select>
            </div>
        </div>

        <!-- Button -->
        <div class="form-group">
            <label class="col-md-4 control-label" for=""></label>
            <div class="col-md-4">
                <button type="submit" id="" name="" class="btn btn-success">Ödeme Linki Oluştur</button>
            </div>
        </div>

    </fieldset>
</form>



<?php
if (!empty($_POST)) {
    $settings = new Settings();

    $requestData = [
        "name" => $_POST['name'],
        "surname" => $_POST['surname'],
        "tcCertificate" => $_POST['tcCertificate'],
        "taxNumber" => $_POST['taxNumber'],
        "email" => $_POST['email'],
        "gsm" => $_POST['gsm'],
        "amount" => $_POST['amount'] * 100, // servis kuruş olarak alıyor
        "threeD" => $_POST['threeD'],
        "expireDate" => date ( "Y-m-d H:i:s", mktime(23, 59, 59, $_POST['month'], $_POST['day'], $_POST['year'])),
        "installmentList" => isset($_POST['installmentList']) ? $_POST['installmentList'] : null,
        "sendEmail" => $_POST['sendEmail'],
        "commissionType" => ($_POST['commissionType']) ? $_POST['commissionType'] : null
    ];

    $linkPaymentRequest = new LinkPaymentCreateRequest($requestData);
    $response = $linkPaymentRequest->execute($settings);
    $output = Helper::formattoJSONOutput($response); //Cüzdana kart eklemesi sonucu oluşan servis çıktı parametrelerini ekrana yazdırmaya olanak sağlayan kısımdır.

    print "<h3>Sonuç:</h3>";
    echo "<pre>";
    echo htmlspecialchars($output);
    echo "</pre>";
}

include('footer.php');
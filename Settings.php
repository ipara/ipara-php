<?php
 


/*
Tüm çağrılarda kullanılacak ayarların tutulduğu sınıftır. 
Bu sınıf üzerinde size özel parametreler fonksiyonlar arasında taşınabilir.
Bu sınıf üzerinde tüm sistemde kullanacağımız ayarları tutar ve bunlara göre işlem yaparız.
Bu sınıf örnek projemizde BaseController içerisinde kullanılmıştır. Ve tüm ayarların kullanılacağı yerde karşımıza çıkmaktadır.
*/   
class Settings
{      
 
    public $PublicKey;
    public $PrivateKey;
    public $BaseUrl;
    public $Mode;
    public $Version;
    public $HashString;
    public $transactionDate;


    public function __construct()
    {
        
        $this->PublicKey = "GQYRBCBNVAG93C5"; // "Public Magaza Anahtarı - size mağaza başvurunuz sonucunda gönderilen publik key (açık anahtar) bilgisini kullanınız.",
        $this->PrivateKey = "GQYRBCBNVAG93C54BO6T0JQAA"; // "Private Magaza Anahtarı  - size mağaza başvurunuz sonucunda gönderilen privaye key (gizli anahtar) bilgisini kullanınız.",
        $this->BaseUrl = "https://api.ipara.com/"; //iPara web servisleri API url'lerinin başlangıç bilgisidir. Restful web servis isteklerini takip eden kodlar halinde bulacaksınız.
                                                 // Örneğin "https://api.ipara.com/" + "/rest/payment/auth"  = "https://api.ipara.com/rest/payment/auth" 
        $this->Version="1.0";// Kullandığnız iPara API versiyonudur. 
        $this->Mode="T"; // Test -> T, entegrasyon testlerinin sırasında "T" modunu, canlı sisteme entegre olarak ödeme almaya başlamak için ise Prod -> "P" modunu kullanınız.            
        $this->HashString="";// Kullanacağınız hash bilgisini, bağlanmak istediğiniz web servis bilgisine göre doldurulmalıdır. Bu bilgileri Entegrasyon rehberinin ilgili web servise ait bölümde bulabilirsiniz.
    }     
}


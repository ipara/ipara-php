
<?php
include('menu.php');
?>


<?php 


ini_set('display_errors',1); 
error_reporting(E_ERROR );


print "<h1>3D Ödeme Başarısız!</h1>";
print "<h3>Sonuç:</h3>";

echo ("<pre>");
print_r($_POST);
echo ("</pre>");

?>

<?php include('footer.php');?>
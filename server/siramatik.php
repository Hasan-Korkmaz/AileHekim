<?php
setlocale(LC_ALL, 'tr_TR.UTF-8');
include("databasecon.php");
if (isset($_POST["FunctionName"])&& isset($_POST["Parameters"])) 
{
    $doctor=$_POST["Parameters"][0];
    $tarih=$_POST["Parameters"][1];
    $saat=$_POST["Parameters"][2];
    $hasta=$_POST["Parameters"][3];

    if ($_POST["FunctionName"] == "add") {
        $returnObj = new \stdClass();
        $returnObj->Status = false;
        $returnObj->Message = "";
        $returnObj->Data = "";
        $query = "INSERT INTO `siramatik`(`Id`, `DoktorTC`, `HastaTC`, `Tarih`, `Saat`) VALUES (null,'$doctor','$hasta','$tarih','$saat')";
        if ($connectdb->query($query) === TRUE) {
            $returnObj->Status = true;
            $returnObj->Message = "Başarılı bir şekilde kaydınız alınmıştır.";
        }
        else
        {
            $returnObj->Status = false;
            $returnObj->Message = "Kayıt Sırasında bir hata oluştu daha sonra tekrar deneyiniz";
            $returnObj->Data= $doctor . " " . $tarih . " " . $saat . " " . $hasta ;
        }
        echo json_encode($returnObj, JSON_UNESCAPED_UNICODE);
        }

}
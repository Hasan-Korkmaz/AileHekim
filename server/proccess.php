
<?php
setlocale(LC_ALL, 'tr_TR.UTF-8');
include("databasecon.php");

if (isset($_POST["FunctionName"])) {

    if ($_POST["FunctionName"] == "add") {
        $returnObj = new \stdClass();
        $returnObj->Status = false;
        $returnObj->Message = "";
        $returnObj->Data = "";
        if (isset($_POST["Parameters"])) {
            $hastatc = $_POST["Parameters"][0];
            $doktortc = $_POST["Parameters"][1];
            $islem = $_POST["Parameters"][2];
            $detay = $_POST["Parameters"][3];
            $query = "INSERT INTO `proccess`(`HastaTC`, `DoktorTC`, `YapilanIslem`, `Detay`) VALUES ('$hastatc','$doktortc','$islem','$detay')";
            $executeQuery = mysqli_query($connectdb, $query);
            
            if ($executeQuery==true) 
            {
                $returnObj->Status = true;
                $returnObj->Message = "Başarılı bir şekilde kaydınız alınmıştır.";
            } 
            else 
            {
                $returnObj->Status = false;
                $returnObj->Message = "Kayıt Sırasında bir hata oluştu daha sonra tekrar deneyiniz";
                $returnObj->Data = "";
            }
            echo json_encode($returnObj, JSON_UNESCAPED_UNICODE);
        }
    }
}

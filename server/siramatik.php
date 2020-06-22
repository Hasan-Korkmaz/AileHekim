<?php
setlocale(LC_ALL, 'tr_TR.UTF-8');
include("databasecon.php");
if (isset($_POST["FunctionName"]) && isset($_POST["Parameters"])) {
    $returnObj = new \stdClass();
    $returnObj->Status = false;
    $returnObj->Message = "";
    $returnObj->Data = "";

    if ($_POST["FunctionName"] == "add") {
        $doctor = $_POST["Parameters"][0];
        $tarih = $_POST["Parameters"][1];
        $saat = $_POST["Parameters"][2];
        $hasta = $_POST["Parameters"][3];

        $query = "INSERT INTO `siramatik`(`Id`, `DoktorTC`, `HastaTC`, `Tarih`, `Saat`) VALUES (null,'$doctor','$hasta','$tarih','$saat')";
        if ($connectdb->query($query) === TRUE) {
            $returnObj->Status = true;
            $returnObj->Message = "Başarılı bir şekilde kaydınız alınmıştır.";
        } else {
            $returnObj->Status = false;
            $returnObj->Message = "Kayıt Sırasında bir hata oluştu daha sonra tekrar deneyiniz";
            $returnObj->Data = $doctor . " " . $tarih . " " . $saat . " " . $hasta;
        }
        echo json_encode($returnObj, JSON_UNESCAPED_UNICODE);
    } else if ($_POST["FunctionName"] == "GetList") {
        $DoktorTC = $_POST["Parameters"][0];
        $Tarih = $_POST["Parameters"][1];
        $query = "select * from siramatik where Tarih='$Tarih' and DoktorTC='$DoktorTC'";
        $list = mysqli_query($connectdb, $query);
        if ($list == null) {
            $returnObj->Status = false;
            $returnObj->Message = "Veri Bulunamadı.";
            $returnObj->Data = "";
            echo json_encode($returnObj, JSON_UNESCAPED_UNICODE);
        } else {
            $returnObj->Status = true;
            $returnObj->Message = "Veri Listeleniyor.";
            $SiraList = [];
            while ($row = mysqli_fetch_array($list)) {
                $Sira = new \stdClass();
                $Sira->Hasta = $row['HastaTC'];
                $Sira->Saat = $row['Saat'];
                $Sira->Status = $row['Status'];
                $queryHasta = "select * from hasta where TC='" . $row['HastaTC'] . "'";
                $HastaData = mysqli_query($connectdb, $queryHasta);
                $hastaBilgisi = mysqli_fetch_array($HastaData);
                if ($hastaBilgisi != null) {
                    $Sira->NameSurname = $hastaBilgisi['Ad'] . " " . $hastaBilgisi['Soyad'];
                    $Sira->Yas = $hastaBilgisi['Yas'];
                };
                array_push($SiraList, $Sira);
            }
            $returnObj->Data = $SiraList;
            echo json_encode($returnObj, JSON_UNESCAPED_UNICODE);
        }
    } else if ($_POST["FunctionName"] == "Update") {
        $hastatc = $_POST["Parameters"][0];
        $tarih = $_POST["Parameters"][1];
        echo $hastatc . " " .$tarih;
        $query = " UPDATE `siramatik` SET Status=1 WHERE HastaTC='$hastatc' and Tarih='$tarih' and Status=0";
        $result = mysqli_query($connectdb, $query);
        if ($result == true) {
            $returnObj->Status = true;
            $returnObj->Message = "";
            $returnObj->Data = "";
        } else {
            $returnObj->Status = false;
            $returnObj->Message = "Hata oluştu.";
            $returnObj->Data = "";
        }
        echo json_encode($returnObj, JSON_UNESCAPED_UNICODE);

    }
}

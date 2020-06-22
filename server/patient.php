
<?php
setlocale(LC_ALL, 'tr_TR.UTF-8');
include("databasecon.php");

if (isset($_POST["FunctionName"])) {

    if ($_POST["FunctionName"] == "GetList") {
        $returnObj = new \stdClass();
        $returnObj->Status = false;
        $returnObj->Message = "";
        $returnObj->Data = "";

        $query = "select * from staff";
        $list = mysqli_query($connectdb, $query);
        $doctorList = [];

        if ($list == null) {
            $returnObj->Status = false;
            $returnObj->Message = "Veri Bulunamadı.";
            $returnObj->Data = "";
            echo json_encode($returnObj, JSON_UNESCAPED_UNICODE);
        } else {
            $returnObj->Status = true;
            $returnObj->Message = "Veri Listeleniyor.";
            while ($row = mysqli_fetch_array($list)) {
                $doctor = new \stdClass();
                $doctor->NameSurname = $row['Ad'] . " " . $row['Soyad'];
                $doctor->TC = $row['TC'];
                array_push($doctorList, $doctor);
            }
            $returnObj->Data = $doctorList;
            echo json_encode($returnObj, JSON_UNESCAPED_UNICODE);
        }
    } else if ($_POST["FunctionName"] == "Get") {
        $returnObj = new \stdClass();
        $returnObj->Status = false;
        $returnObj->Message = "";
        $returnObj->Data = "";


        if (isset($_POST["Parameters"])) {
            $hastaTc = $_POST["Parameters"][0];
            $query = "select * from hasta where TC='$hastaTc'";
            $hastaquery=mysqli_query($connectdb,$query);
            $row = mysqli_fetch_array($hastaquery);
            $returnObj->Status=true;
            $returnObj->Message="TC Numarasını veya şifrenizi kontrol Edin";
            $returnObj->Data=$row;
            echo json_encode($returnObj, JSON_UNESCAPED_UNICODE);

        }
    }
    else if($_POST["FunctionName"]=="GetPatientHistoryList")
    {
        $returnObj = new \stdClass();
        $returnObj->Status = false;
        $returnObj->Message = "";
        $returnObj->Data = "";

        $hastatc=$_POST["Parameters"][0];
        $historyList=[];
    
        $query = "select * from siramatik where HastaTC='$hastatc'";
        $queryForHastaNameSurname="select *  from hasta where TC='$hastatc'";
        $hastaName=mysqli_query($connectdb,$queryForHastaNameSurname);
        $hastaDetail=mysqli_fetch_array($hastaName);

       
        $list = mysqli_query($connectdb, $query);
        if ($list == null) {
            $returnObj->Status = false;
            $returnObj->Message = "Veri Bulunamadı.";
            $returnObj->Data = "";
            echo json_encode($returnObj, JSON_UNESCAPED_UNICODE);
        } else {
            $returnObj->Status = true;
            $returnObj->Message = "Veri Listeleniyor.";
            while ($row = mysqli_fetch_array($list)) {
                $siramatik = new \stdClass();
                $siramatik->Tarih=$row["Tarih"];
                $siramatik->Saat=$row["Saat"];
                $siramatik->Status=$row["Status"];
                $siramatik->NameSurname=$hastaDetail["Ad"]. " " . $hastaDetail["Soyad"];
                $doctorQuery="select * from staff where TC='".$row['DoktorTC']."'";
                $user=mysqli_query($connectdb,$doctorQuery);
                $rowDoctor=mysqli_fetch_array($user);
                $siramatik->Doctor=$rowDoctor["Ad"]. " " .$rowDoctor["Soyad"];
                $proccessQuery="select * from proccess where HastaTC='$hastatc'";
                $queryData=mysqli_query($connectdb,$proccessQuery);
                $queryDataRow=mysqli_fetch_array($queryData);
                $siramatik->Islem=$queryDataRow["YapilanIslem"];
                $siramatik->Detail=$queryDataRow["Detay"];
                array_push($historyList, $siramatik);
            }
            $returnObj->Data = $historyList;
            echo json_encode($returnObj, JSON_UNESCAPED_UNICODE);
        }

    }
}

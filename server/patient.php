
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

        if ($list == null) 
        {
            $returnObj->Status = false;
            $returnObj->Message = "Veri Bulunamadı.";
            $returnObj->Data = "";
            echo json_encode($returnObj, JSON_UNESCAPED_UNICODE);
        } 
        else 
        {   $returnObj->Status = true;
            $returnObj->Message = "Veri Listeleniyor.";
            while ($row = mysqli_fetch_array($list)) 
            {
                $doctor = new \stdClass();
                $doctor->NameSurname = $row['Ad'] . " " . $row['Soyad'];
                $doctor->TC = $row['TC'];
                array_push($doctorList, $doctor);
            }
            $returnObj->Data = $doctorList;
            echo json_encode($returnObj, JSON_UNESCAPED_UNICODE);
        }
    }
}

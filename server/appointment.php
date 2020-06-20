
<?php
setlocale(LC_ALL, 'tr_TR.UTF-8');
include("databasecon.php");
if (isset($_POST["FunctionName"])&& isset($_POST["Parameters"])) 
{
    $function=$_POST["FunctionName"];
    $parameters=$_POST["Parameters"];

    $returnObj = new \stdClass();
    $returnObj->Status = false;
    $returnObj->Message = "";
    $returnObj->Data = "";

    $TimeList=[];
    if($function=="GetTimes")
    {
        $DoktorTC=$parameters[0];
        $Tarih=$parameters[1];
        $query ="select * from siramatik where DoktorTC='$DoktorTC' and Tarih='$Tarih'";
        $list = mysqli_query($connectdb, $query);
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
                $Saat = new \stdClass();
                $Saat->Saat = $row['Saat'];
                array_push($TimeList, $Saat);
            }
            $returnObj->Data = $TimeList;
            echo json_encode($returnObj, JSON_UNESCAPED_UNICODE);
        }
    }
}
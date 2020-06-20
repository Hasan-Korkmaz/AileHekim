<?php 

setlocale(LC_ALL, 'tr_TR.UTF-8');
    include("databasecon.php");
  //Hasta Girişi
if (isset($_POST['PatientTC'])) {

    $hastaTc = $_POST['PatientTC'];

    $returnObj=new \stdClass();
    $returnObj->Status=false;
    $returnObj->Message="";
    $returnObj->Data="";

    $query ="select * from Hasta where TC='$hastaTc'";
    $hasta=mysqli_query($connectdb,$query);
    $row=mysqli_fetch_array($hasta);
    if($row==null)
    {
        $returnObj->Status=false;
        $returnObj->Message="TC Numarasınız yanlış";
        $returnObj->Data="";
        echo json_encode($returnObj, JSON_UNESCAPED_UNICODE);

    }
    else
    {
        $returnObj->Status=true;
        $returnObj->Message="Giriş İşlemi Yapıldı.\nBaşarılı bir şekilde yönlendiriliyorsunuz.";
        $returnObj->Data=$row;
        echo json_encode($returnObj, JSON_UNESCAPED_UNICODE);


    }
  
}

//Personel Girişi
if (isset($_POST['PersonelTC'])&& isset($_POST['Sifre']))   {
    $returnObj=new \stdClass();
    $returnObj->Status=false;
    $returnObj->Message="";
    $returnObj->Data="";
    
    $personeltc = $_POST['PersonelTC'];
    $sifre = $_POST['Sifre'];
    $query ="select * from staff where TC='$personeltc' and Sifre='$sifre'";
    $user=mysqli_query($connectdb,$query);
    $row=mysqli_fetch_array($user);
    if($row==null)
    {
        $returnObj->Status=false;
        $returnObj->Message="TC Numarasını veya şifrenizi kontrol Edin";
        $returnObj->Data="";
        echo json_encode($returnObj, JSON_UNESCAPED_UNICODE);

    }
    else
    {
        $returnObj->Status=true;
        $returnObj->Message="Giriş İşlemi Yapıldı.\nBaşarılı bir şekilde yönlendiriliyorsunuz.";
        $returnObj->Data=$row;
        echo json_encode($returnObj, JSON_UNESCAPED_UNICODE);


    }
}

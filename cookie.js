function deleteCookies() { 
    console.log("test");
    document.cookie = "AHSTC= ; expires = Thu, 01 Jan 1970 00:00:00 GMT";
    document.cookie = "AHSnameSurname= ; expires = Thu, 01 Jan 1970 00:00:00 GMT";
    document.cookie = "AHSUserType= ; expires = Thu, 01 Jan 1970 00:00:00 GMT";
};
function readSession(page)
{
    var patientPages = ["patient.html"];
    var staffPages = ["personel.html","proccess.html"];
    var generalPages=["index.html"]
    //AHSUserType 0 ise Personel
    //AHSUserType 1 ise Hasta
    console.log(getCookie("AHSUserType"));
    if(getCookie("AHSUserType")=="1")
    {
        
        if(patientPages.indexOf(page)==-1)
        {
            //Sayfaya Yetkisi Yok
            window.location.href = "404.html";
            return false;
        }
        else
        {
            return true;
        }
    }
    else if(getCookie("AHSUserType")=="0")
    {
        if(staffPages.indexOf(page)==-1)
        {
            //Sayfaya Yetkisi Yok
            window.location.href = "404.html";
            return false;
        }
        else
        {
            return true;
        }
    }
    else
    {            window.location.href = "404.html";
        return false;
    }
    

}
function getCookie(name) {
    // Split cookie string and get all individual name=value pairs in an array
    var cookieArr = document.cookie.split(";");
    
    // Loop through the array elements
    for(var i = 0; i < cookieArr.length; i++) {
        var cookiePair = cookieArr[i].split("=");
        
        /* Removing whitespace at the beginning of the cookie name
        and compare it with the given string */
        if(name == cookiePair[0].trim()) {
            // Decode the cookie value and return
            return decodeURIComponent(cookiePair[1]);
        }
    }
    
    // Return null if not found
    return null;
}

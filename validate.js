function validate_login () {
    var username=document.getElementById('username');
    var password=document.getElementById('password');
    if(username.value!=password.value){
        document.getElementById("error").innerHTML="Not Mutch.";
        document.getElementById("error").style.color="blue";
        return false;
    }
    else {
        return true;
    }
    
}

function validate_signup() {

    var password= document.getElementById('password_reg');
    var confirm_password= document.getElementById('confirm_password_reg');
    if(password.value!=confirm_password.value){

        return false;
}
else{
    return true;
}
}
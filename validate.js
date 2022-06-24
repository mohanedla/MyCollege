    var id=document.getElementById('id');
    var password=document.getElementById('password');
function validate () {
    if(id.value!=password.value){
        return false;
    }
    else {
        return true;
    }
}
function ShowPassword() {
    if (password.type === "password") {
      password.type = "text";
    } else {
      password.type = "password";
    }
  }
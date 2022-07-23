
function validateFirstname(field)
{
return (field == "") ? "No Firstname was entered.\n" : ""
}

function validateLastname(field)
{
return (field == "") ? "No Lastname was entered.\n" : ""
}

function validateEmail(field)
{
if (field == "") return "No Email was entered.\n"
else if (!((field.indexOf(".") > 0) && (field.indexOf("@") > 0)) || /[^a-zA-Z0-9.@_-]/.test(field))
return "The Email address is invalid.\n"
return ""
}

function validateAreaCode(field)
{
return (field == "") ? "No Area Code was entered.\n" : ""
}

function validatePhone(field)
{
if (field == "") return "No Phone Number was entered.\n"
else if (field.length < 6)
    return "Phone Number must be at least 7 characters.\n"
return ""
}

var priceArray = [15,5,5,4];
var list= [];
var total=0;
var checkbox = document.getElementsByName('check');
var quantity = document.getElementsByClassName('number');

var fname = document.getElementById('txt-fname');     
var lname = document.getElementById('txt-lname');
var email = document.getElementById('txt-email');
var areaCode = document.getElementById('txt-areacode');
var phone = document.getElementById('txt-phone');

var lb_cake = document.getElementById('lb-cake').innerHTML = "Cake";
var lb_banana = document.getElementById('lb-banana').innerHTML = "Banana"; 
var lb_apple = document.getElementById('lb-apple').innerHTML = "Apple";
var lb_tuna = document.getElementById('lb-tuna').innerHTML = "Tuna";

function mycheck() {

for( var i =0 ; i<checkbox.length ; i++ ){
if(checkbox[i].checked==true){
    list[i]=priceArray[i]*quantity[i].value;
    console.log(list[i]);
    }
}
}

function dataAlert() {
var tot=create ();
if(list.length==0){
    alert(tot);
    return false;
    }
else {
_print="Your Data is :-\n";
_print += fname.value + "  " + lname.value + '\n';
_print += email.value + '\n' + areaCode.value + "-" + phone.value + '\n';
if(checkbox[0].checked==true){
var selFlavor = document.getElementById('s-flavor');
var optionFlavor = selFlavor.options[selFlavor.selectedIndex].value;

var selIcing = document.getElementById('s-icing');
var optionIcing = selIcing.options[selIcing.selectedIndex].text;

    _print += "You Select "  + lb_cake + " amount "+ quantity[0].value + " with flavor " + optionFlavor + " and Icing with " + optionIcing + " Total= " + list[0] + " LYD" + '\n';
}
if(checkbox[1].checked==true){
    _print += "You Select " + lb_banana + " amount  " + quantity[1].value + " Total= " + list[1] + " LYD"+ '\n';
}
if(checkbox[2].checked==true){
    _print += "You Select " + lb_apple + " amount  " + quantity[2].value + " Total= " + list[2] + " LYD" + '\n';
}
if(checkbox[3].checked==true){
    _print += "You Select " + lb_tuna + " amount  " + quantity[3].value + " Total= " + list[3] + " LYD" + '\n';
}
_print += "Total= "+ tot + "LYD";
alert( _print );
return true;
    }
}

function cleare () {
    document.getElementById('txt-fname').value='';
    document.getElementById('txt-lname').value='';
    document.getElementById('txt-email').value='';
    document.getElementById('txt-areacode').value='';
    document.getElementById('txt-phone').value='';
    for (var i=0 ; i<quantity.length; i++) {
        quantity[i].value='';
    }
    for( var i =0 ; i<checkbox.length ; i++ ){
        checkbox[i].checked=false;
    }
    list= [];
    total=0;

}

function create () {    

if(list.length > 0){
    for( var i =0 ; i<list.length ; i++ ){
        if(list[i]==null){
            continue;
        }
        else{
        total+= list[i] ;
        }
        console.log(total);
    }
    return total;
}
else if(list.length == 0){
    return ( "You Don't Choose Anything.\n" );
}
}


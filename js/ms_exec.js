//Document execution of the Mining Simulator
$(document).ready(function() {

    var mobileString = "";
    if (screen.width <= 480) mobileString = "-mobile";

    console.log("#login-session" + mobileString + " new js");

    $("#login-session" + mobileString).click(function(){
        //document.getElementById("login-register-tab" + mobileString).style.display = "none";
        //document.getElementById("login-tab" + mobileString).style.display = "block";
        $("#login-register-tab" + mobileString).hide();
        $("#login-tab" + mobileString).show();
    });

    $("#register-session" + mobileString).click(function(){
        //document.getElementById("login-register-tab" + mobileString).style.display = "none";
        //document.getElementById("register-tab" + mobileString).style.display = "block";
        $("#login-register-tab" + mobileString).hide();
        $("#register-tab" + mobileString).show();
    });

    $(".go-back-btn" + mobileString).click(function(){
        //document.getElementById("login-tab" + mobileString).style.display = "none";
        //document.getElementById("register-tab" + mobileString).style.display = "none";
        //document.getElementById("login-register-tab" + mobileString).style.display = "block";

        $("#register-tab" + mobileString).hide();
        $("#login-tab" + mobileString).hide();
        $("#login-register-tab" + mobileString).show();
    });
});

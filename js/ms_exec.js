/**
 * View handling for non-mobile and mobile devices.
 */
$(document).ready(function() {

    var mobileString = "";
    if (screen.width <= 480) mobileString = "-mobile";

    $("#login-session" + mobileString).click(function(){
        $("#login-register-tab" + mobileString).hide();
        $("#login-tab" + mobileString).show();
    });

    $("#register-session" + mobileString).click(function(){
        $("#login-register-tab" + mobileString).hide();
        $("#register-tab" + mobileString).show();
    });

    $(".go-back-btn" + mobileString).click(function(){
        $("#register-tab" + mobileString).hide();
        $("#login-tab" + mobileString).hide();
        $("#login-register-tab" + mobileString).show();
    });
});

//Document execution of the Mining Simulator
$(document).ready(function() {
    $("#login-session").click(function(){
        $("#login-register-tab").hide();
        $("#login-tab").show();
    });

    $("#register-session").click(function(){
        $("#login-register-tab").hide();
        $("#register-tab").show();
    });

    $(".go-back-btn").click(function(){
        $("#register-tab").hide();
        $("#login-tab").hide();
        $("#login-register-tab").show();
    });
});

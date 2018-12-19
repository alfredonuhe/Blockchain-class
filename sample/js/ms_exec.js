/**
 * Document execution. Some previous jobs need to be done before
 * starting the SSE handler: An initial post to the server, hide
 * all the right side panel, insert initial data into left side
 * panel and start the modal view.
 *
 * Buttons functionalities are also defined.
 */

$(document).ready(function() {
    initialPost();
    hidePannel();
    initialData();
    sseHandler();
    showModal();
    console.log(input_data);

    $("#hash_button_new").click(function(){
        if(!button_disabled){
            miningTimer = window.setInterval(calcBlockHash, 50);
            disableButton();
        }
    });
    $("#random_hash_new").click(function(){
      $("#merkle_root_new").val(randomHash());
    });
    $("#dinamic_board_text_btn").click(function(){
      hideTextArea(true);
    });
    $(".dinamic_board_btn").click(function(){
      var index = $(this).parent().parent().index(".dinamic_board");
      console.log(index);
      showData(index);
      hideTextArea(false);
    });
    $("#logout-button").click(function(){
        logout();
    });
    $(".next-modal").click(function(){
        nextModalContent();
    });
    $(".previous-modal").click(function(){
        previousModalContent();
    });
    $(".close-modal").click(function(){
        hideModal();
    });
    $("#homeBtn").click(function(){
        window.location = "../index.php";
    });
    $(document).ready(function(){
        $('[data-toggle="popover"]').popover();
    });

    var onloadCallback = function() {
        grecaptcha.render('recaptcha', {
            'sitekey' : 'your_site_key'
        });
    };
});
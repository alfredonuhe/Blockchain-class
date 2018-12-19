/**
 * Variable initializations.
 */
var input_data = [new infoInput("#version_new", 4, null, "Version", null), new infoInput("#prev_block_new", 64, null, "Previous block", null), new infoInput("#dificulty_new", 1, null, "Dificulty", null),
    new infoInput("#timestamp_new", 10, null, "Timestamp", null), new infoInput("#merkle_root_new", 64, null, "Merkle root", null),
    new infoInput("#nonce_new", 10, null, "Nonce", null)];

//TODO: Look for unused variables
var index_vector = [7, 1, 5, 2, 6, 3, 4];
var hash_message = '';
var button_disabled = false;
var text_area_on = false;
var miningTimer = null;

var info_array = [];
var new_queue = new Queue();
var recent_queue = new Queue();

/**
 * Check usage
 */
function infoBlock(hash, hash_message) {
    this.hash = hash;
    this.hash_message = hash_message;
}

/**
 * Constructor of oject infoInput, it stores the form data.
 * @param id ID of the html input.
 * @param allowed_length Allowed length of input.
 * @param real_length Actual length of current content inside input.
 * @param name Name of the input.
 * @param value Value stored inside input.
 */
function infoInput(id, allowed_length, real_length, name, value) {
    this.id = id;
    this.allowed_length = allowed_length;
    this.real_length = real_length;
    this.name = name;
    this.value = value;
}

/**
 * Check usage
 */
function isNumber(n) {
    return !isNaN(parseFloat(n)) && isFinite(n);
}

/**
 * Plays a sound for newly generated blocks.
 */
function playSound() {
    var audio = new Audio('media/notification_sound.mp3');
    audio.play();
}

/**
 * Increments the nonce value in the form.
 */
function newNonce() {
    var nonce = parseInt($("#nonce_new").val()) + 1;
    $("#nonce_new").val(nonce);
}

/**
 * Calculates a random hash using the SHA256 algorithm.
 * @returns {*} Hash value.
 */
function randomHash() {
    return Crypto.SHA256(String(Math.random()));
}

/**
 * Calculates current Epoch timestamp.
 * @returns {number} Value of timestamp.
 */
function calcTimestamp() {
    return Math.floor((new Date).getTime() / 1000);
}

/**
 * Adds frontal padding, ceros, to form values reaching
 * it's required length.
 * @param num Original form value.
 * @param size Total length of value
 * @returns {string} Final string with frontal padding.
 */
function frontalPadding(num, size) {
    var s = num + "";
    while (s.length < size) s = "0" + s;
    return s;
}

/**
 * Sets initial form data at page load.
 */
function initialData() {
    $("#timestamp_new").val(calcTimestamp());
    $("#dificulty_new").val(3);
    $("#merkle_root_new").val(randomHash());
    $("#nonce_new").val(1);
    $("#prev_hash_input").val(frontalPadding("", 64));
}

/**
 * Generates an initial post at page load.
 */
function initialPost() {
    $.ajax({
        url: "php/new_user.php",
        type: "POST",
        data: "",
    });
}

/**
 * Sets correct or incorrect hash style for the
 * generated hash with the form data.
 * @param correct True if hash is correct and
 *                  false if it isn't.
 */
function correctHashStyle(correct) {
    if (correct) {
        $("#block_hash_new")
            .css("border", "3px solid #337ab7")
            .css("background-color", "#f0f5ff");
        return;
    }
    $("#block_hash_new")
        .css("border", "1px solid #ccc")
        .css("background-color", "#eee");
}

/**
 * Posts form data to the server.
 */
function postForm() {
    var form = $("#form_ms");
    $.ajax({
        type: form.attr('method'),
        url: form.attr('action'),
        data: form.serialize(),
        success: function (data) {
            console.log("Ajax_success");
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.log("Ajax_error");
        }
    });
}

/**
 * Sets correct and incorrect style for right side
 * panel blocks.
 * @param correct True for correct blocks.
 * @param i Index if block needing CSS style.
 */
function blockStyle(correct, i) {
    if (correct) {
        $(".dinamic_board input:eq(" + i + ")")
            .css("border", "3px solid #34ab30")
            .css("background-color", "#eaffef");
        return;
    }
    $(".dinamic_board input:eq(" + i + ")")
        .css("border", "3px solid #ff5050")
        .css("background-color", "#f5e1e1");
}

/**
 * Sets style for newly generated blocks in
 * right side panel.
 * @param correct True for a new block.
 */
function newBlockStyle(correct) {
    if (correct) {
        $(".dinamic_board input:eq(0)")
            .css("border", "3px solid #337ab7")
            .css("background-color", "#f0f5ff");
    } else {
        $(".dinamic_board input:eq(0)")
            .css("border", "1px solid #ccc")
            .css("background-color", "#eee");
    }
    var dinamic_board = document.getElementsByClassName("dinamic_board");
    for (var i = 1; i < dinamic_board.length; i++) {
        $(".dinamic_board input:eq(" + i + ")")
            .css("border", "1px solid #ccc")
            .css("background-color", "#eee");
    }
}

/**
 * Method to decide correct or incorrect style
 * for right side panel blocks.
 */
function setBlockStyles() {
    if (new_queue.size() == 0) return;
    for (var i = 0; i < new_queue.size(); i++) {
        if (new_queue._storage[i].valid_block == true) {
            blockStyle(true, i);
        } else {
            blockStyle(false, i);
        }
    }
}

/**
 * Hides right side panel at page load.
 */
function hidePannel() {
    var dinamic_board = document.getElementsByClassName("dinamic_board");
    var dinamic_board_text = document.getElementsByClassName("dinamic_board_text");
    for (var i = 0; i < dinamic_board.length; i++) {
        dinamic_board[i].style.display = "none";
    }
    for (var i = 0; i < dinamic_board_text.length; i++) {
        dinamic_board_text[i].style.display = "none";
    }
}

/**
 * Hides extended block information dialog.
 * @param hide True to hide the dialog,
 *              false to show the dialog.
 */
function hideTextArea(hide) {
    var dinamic_board = document.getElementsByClassName("dinamic_board");
    var dinamic_board_text = document.getElementsByClassName("dinamic_board_text");
    if (hide) {
        text_area_on = false;
        for (var i = 0; i < dinamic_board_text.length; i++) {
            dinamic_board_text[i].style.display = "none";
        }
        refreshPannelQ(new_queue);
    } else {
        text_area_on = true;
        for (var i = 0; i < dinamic_board.length; i++) {
            dinamic_board[i].style.display = "none";
        }
        for (var i = 0; i < dinamic_board_text.length; i++) {
            dinamic_board_text[i].style.display = "";
        }
    }
}

/**
 * Emptys queue's content.
 * @param new_queue Queue to be emptied.
 */
function emptyQueue(new_queue) {
    while (new_queue.size() != 0) {
        new_queue.dequeue();
    }
}

/**
 * Updated queue's content with another queue.
 * @param server_queue queue used to update "new_queue".
 */
function updateQueue(server_queue) {
    emptyQueue(new_queue);
    for (var i = server_queue.newestIndex - 1; i >= 0; i--) {
        new_queue.enqueue(server_queue.storage[i]);
    }
    new_queue._validPreviousHash = server_queue.valid_prev_hash;
}

/**
 * Enables hash calculating button.
 */
function enableButton() {
    console.log("enabled");
    $("#hash_button_new")
        .css("background-color", "#337ab7")
        .css("border-color", "#2e6da4");
    button_disabled = false;
    correctHashStyle(false);
}

/**
 * Disables hash calculating button.
 */
function disableButton() {
    button_disabled = true;
    console.log("disabled");
    $("#hash_button_new")
        .css("background-color", "#c5c5c5")
        .css("border-color", "#eaeaea");
}

/**
 * Calculates block in raw format.
 * @param object_values
 * @returns {string}
 */
function calcBlockMessage(object_values) {
    var message = "";
    for (var i = 0; i < input_data.length; i++) {
        message = message + frontalPadding(object_values[i + 1], input_data[i].allowed_length);
    }
    // delete line
    console.log(input_data);
    return message;
}

/**
 * Shows block data in expanded text dialog.
 * @param index Index of the block to show.
 */
function showData(index) {
    var text_area = $("#dinamic_board_text_area");
    var data = new_queue._storage;
    var new_data;
    var object_values = Object.values(data[index]);
    text_area.val(frontalPadding(object_values[7], 64) + "\n\n" + "BLOCK RAW HEADER: " + calcBlockMessage(object_values) + "\n\n");
    console.log(object_values);
    for (var i = 0; i < input_data.length; i++) {
        //revisar
        new_data = input_data[i].name.toUpperCase() + ": " + frontalPadding(object_values[i + 1], input_data[i].allowed_length) + "\n";
        text_area.val(text_area.val() + new_data);
    }
    if (object_values[input_data.length]) {
        text_area.val(text_area.val() + "\n\n" + object_values[object_values.length-1]);
    }
}

/**
 * Deletes session from server and database.
 */
function logout() {
    var sessionName = window.location.pathname.split('/')[3].substring(8);
    $.ajax({
        url: "../php/logout.php",
        type: "POST",
        data: {
            name: sessionName
        },
        success: function () {
            console.log("Ajax_success");
            window.location = "../index.php"
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.log("Ajax_error");
        }
    });
}

/**
 * Shows simulator modal at page load.
 */
function showModal() {
    document.getElementById("myModal").style.display = "block";
    document.getElementsByClassName("modal-content").item(0).style.display = "block";
}

/**
 * Hides modal when closed.
 */
function hideModal() {
    var modalContents = document.getElementsByClassName("modal-content");
    for (var i = 0; i < modalContents.length; i++) {
        modalContents[i].style.display = "none";
    }
    document.getElementById("myModal").style.display = "none";
}

/**
 * Shows next modal content.
 */
function nextModalContent() {
    var modalContents = document.getElementsByClassName("modal-content");
    for (var i = 0; i < modalContents.length; i++) {
        var display = modalContents[i].style.display.toString();
        if (display.localeCompare("block") == 0 && i < modalContents.length - 1) {
            modalContents[i].style.display = "none";
            modalContents[i + 1].style.display = "block";
            i++;
        }
    }
}

/**
 * Shows previous modal content.
 */
function previousModalContent() {
    var modalContents = document.getElementsByClassName("modal-content");
    for (var i = modalContents.length - 1; i >= 0; i--) {
        var display = modalContents[i].style.display.toString();
        if (display.localeCompare("block") == 0 && i > 0) {
            modalContents[i].style.display = "none";
            modalContents[i - 1].style.display = "block";
            i--;
        }
    }
}
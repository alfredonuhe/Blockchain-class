//Defining global variables
var input_data = [new infoInput("#version_new", 4,null,"Version",null),new infoInput("#prev_block_new", 64,null,"Previous block",null),new infoInput("#dificulty_new", 1,null,"Dificulty",null),
    new infoInput("#timestamp_new", 10,null,"Timestamp",null), new infoInput("#merkle_root_new", 64,null,"Merkle root",null),
    new infoInput("#nonce_new", 10,null,"Nonce",null)];
//revisar
var index_vector = [7,1,5,2,6,3,4];
var hash_message= '';
var button_disabled = false;
var text_area_on = false;
//revisar
var info_array = [];
var new_queue= new Queue();
var recent_queue= new Queue();

// Hash info object
function infoBlock(hash, hash_message) {
  this.hash= hash;
  this.hash_message= hash_message;
}

// Hash info input
function infoInput(id, allowed_length, real_length, name, value) {
  this.id= id;
  this.allowed_length= allowed_length;
  this.real_length= real_length;
  this.name= name;
  this.value= value;
}

//Checks if value is a number
function isNumber(n) {
  return !isNaN(parseFloat(n)) && isFinite(n);
}

//Plays notification sound when changes are made
function playSound(){
  var audio = new Audio('media/notification_sound.mp3');
  audio.play();
}

//sets new nonce for new search
function newNonce(){
  var nonce = parseInt($("#nonce_new").val()) +1;
  $("#nonce_new").val(nonce);
}

//Creates random hash
function randomHash(){
  return Crypto.SHA256(String(Math.random()));
}

//Calculates form timestamp
function calcTimestamp() {
     return Math.floor((new Date).getTime()/1000);
}

//add frotal padding to data
function frontalPadding(num, size) {
    var s = num+"";
    while (s.length < size) s = "0" + s;
    return s;
}

//Initial form data
function initialData() {
  $("#timestamp_new").val(calcTimestamp());
  $("#dificulty_new").val(3);
  $("#merkle_root_new").val(randomHash());
  $("#nonce_new").val(1);
}

//Initial post when accessing inedx file
function initialPost(){
  $.ajax({
          url: "php/new_user.php",
          type: "POST",
          data: "",
      });
}
//Sets style for correct hash
function correctHashStyle(correct){
  if (correct) {
    $("#block_hash_new")
    .css("border","3px solid #337ab7")
    .css("background-color","#f0f5ff");
    return;
  }
  $("#block_hash_new")
  .css("border","1px solid #ccc")
  .css("background-color","#eee");
}

//Posts form with ajax
function postForm(){
  var form = $("#form_ms");
  $.ajax({
    type: form.attr('method'),
    url: form.attr('action'),
    data: form.serialize(),
    success: function(data){
      console.log("Ajax_success");
    },
    error: function(jqXHR, textStatus, errorThrown) {
      console.log("Ajax_error");
    }
  });
}

//Incorrect or correct block style
function blockStyle(correct, i){
  if (correct) {
    $(".dinamic_board input:eq(" + i + ")")
    .css("border","3px solid #34ab30")
    .css("background-color","#eaffef");
    return;
  }
  $(".dinamic_board input:eq(" + i + ")")
  .css("border","3px solid #ff5050")
  .css("background-color","#f5e1e1");
}

//Latest block hash style
function newBlockStyle(correct){
  if (correct) {
    $(".dinamic_board input:eq(0)")
    .css("border","3px solid #337ab7")
    .css("background-color","#f0f5ff");
  }else{
    $(".dinamic_board input:eq(0)")
    .css("border","1px solid #ccc")
    .css("background-color","#eee");
  }
  var dinamic_board = document.getElementsByClassName("dinamic_board");
  for (var i = 1; i < dinamic_board.length; i++) {
    $(".dinamic_board input:eq(" + i + ")")
    .css("border","1px solid #ccc")
    .css("background-color","#eee");
  }
}

//Finds incorrect blocks in the blockchain
function setBlockStyles(){
  if(new_queue.size()==0)return;
  for (var i = 0; i < new_queue.size(); i++) {
    if (new_queue._storage[i].valid_block == true) {
      blockStyle(true, i);
    }else {
      blockStyle(false, i);
    }
  }
}

//Hide pannel at beguinning
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

//Hide block text areas
function hideTextArea(hide) {
  var dinamic_board = document.getElementsByClassName("dinamic_board");
  var dinamic_board_text = document.getElementsByClassName("dinamic_board_text");
  if (hide) {
      text_area_on = false;
      for (var i = 0; i < dinamic_board_text.length; i++) {
        dinamic_board_text[i].style.display = "none";
      }
      refreshPannelQ(new_queue);
  }else{
      text_area_on = true;
      for (var i = 0; i < dinamic_board.length; i++) {
        dinamic_board[i].style.display = "none";
      }
      for (var i = 0; i < dinamic_board_text.length; i++) {
        dinamic_board_text[i].style.display = "";
      }
  }
}

//Empty the panel queue
function emptyQueue(new_queue) {
    while (new_queue.size() != 0) {
      new_queue.dequeue();
    }
}

//Update the panel queue
function updateQueue(server_queue) {
  emptyQueue(new_queue);
  for (var i = server_queue.newestIndex-1; i >=0 ; i--) {
    new_queue.enqueue(server_queue.storage[i]);
  }
}

// Disables 'Try' button after finding a correct hash
function disableButton(){
  button_disabled = true;
  console.log("disabled");
  $("#hash_button_new")
      .css("background-color","#c5c5c5")
      .css("border-color","#eaeaea");
  window.setTimeout(function(){
      console.log("enabled");
      $("#hash_button_new")
        .css("background-color","#337ab7")
        .css("border-color","#2e6da4");
      button_disabled = false;
      correctHashStyle(false);}
  ,5000);
}

//calculates block message
function calcBlockMessage(object_values){
  var message = "";
  for (var i = 0; i < input_data.length; i++) {
    message = message + frontalPadding(object_values[i+1], input_data[i].allowed_length);
  }
  return message;
}

//Show block data from selected hash in pannel
function showData(index){
  var text_area = $("#dinamic_board_text_area");
  var data = new_queue._storage;
  var new_data;
  var object_values = Object.values(data[index]);
  text_area.val(frontalPadding(object_values[7], 64) + "\n\n" + "BLOCK HEADER: " + calcBlockMessage(object_values) + "\n\n");
  console.log("lala\n\n" + object_values);
  for (var i = 0; i < input_data.length; i++) {
    //revisar
    new_data = input_data[i].name.toUpperCase() + ": " + frontalPadding(object_values[i+1], input_data[i].allowed_length)  + "\n";
    text_area.val(text_area.val() + new_data);
  }
}

//Logout by deleting the session files and its presence from the database
//TODO: redirect user to home site
function logout(){
    $.ajax({
        url: "php/logout.php",
        type: "POST",
        data: "",
        success: function(result){
            //window.location = "https://www.example.com"
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.log("Ajax_error");
        }
    });
}

//Defining global variables
var input_data = [new infoInput("#version_new", 4,null,"Version",null), new infoInput("#block_number_new", 4,null,"Block #",null),
    new infoInput("#prev_block_new", 64,null,"Previous block",null),new infoInput("#dificulty_new", 1,null,"Dificulty",null),
    new infoInput("#timestamp_new", 10,null,"Timestamp",null), new infoInput("#merkle_root_new", 64,null,"Merkle root",null),
    new infoInput("#nonce_new", 10,null,"Nonce",null)];
var hash_message= '';
var button_disabled = false;
var info_array = [];
var new_queue= new Queue();

//Checks if value is a number
function isNumber(n) {
  return !isNaN(parseFloat(n)) && isFinite(n);
}

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
      button_disabled = false;}
  ,5000);
}

//Checks if result of hash is a corerct hash
function correctHash(hash, dificulty) {
    correctHashStyle(false);
    $("#block_hash_new").val(hash);
    newNonce();
    for (var i = 0; i < dificulty; i++) {
      if (hash.charAt(i) != "0") {
          return;
      }
    }
    correctHashStyle(true);
    disableButton();
    refreshPannel(hash, hash_message);
    return;
}

//Sets style for correct hash
function correctHashStyle(correct){
    if (correct) {
      $("#block_hash_new")
      .css("border","3px solid #34ab30")
      .css("background-color","#eaffef");
      return;
    }
    $("#block_hash_new")
    .css("border","1px solid #ccc")
    .css("background-color","#eee");
}

//sets new nonce for new search
function newNonce(){
    var nonce = parseInt($("#nonce_new").val()) +1;
    $("#nonce_new").val(nonce);
}

/*Concatenates all of the values of the form
only if all data is providad in the form*/
function concatById(input_data) {
  $("#timestamp_new").val(calcTimestamp());
  hash_message='';
  for (i = 0; i < input_data.length; i++) {
      input_data[i].real_length = $(input_data[i].id).val().length;
      if(input_data[i].real_length > input_data[i].allowed_length){
        alert("Maximum number of digits in field " + input_data[i].name + " is of " + input_data[i].allowed_length + " digits.");
        return false;
      }
      input_data[i].value = frontalPadding($(input_data[i].id).val(), input_data[i].allowed_length);
      hash_message = hash_message.concat(input_data[i].value);
  }
  return true;
}

//post funtion to sumbit form data to server
function post_Hash(hash, hash_message){
  $.post("php/session_guest.php",
        {
          'myhash': hash,
          'myhash_message': hash_message
        });
}

//Creates random hash
function randomHash(){
  return Crypto.SHA256(String(Math.random()));
}

//test hiding and showing hash text areas
function refreshPannel(hash, hash_message){
  //eliminar
  var infoBlock_aux = new infoBlock(hash, hash_message);
  $("#dinamic_board_alfredo").val("BLOCK #: " + input_data[1].value + "\n\n" +
      "BLOCK HASH: " + hash + "\n\n" + "BLOCK HEADER: " + hash_message + "\n\n");
  var new_data;
  for (var i = 0; i < input_data.length; i++) {
    new_data = input_data[i].name.toUpperCase() + ": " + input_data[i].value + "\n";
    $('#dinamic_board_alfredo').val($('#dinamic_board_alfredo').val() + new_data);
  }
}

//add frotal padding to data
function frontalPadding(num, size) {
    var s = num+"";
    while (s.length < size) s = "0" + s;
    return s;
}

//Calculates form timestamp
function calcTimestamp() {
     return Math.floor((new Date).getTime()/1000);
}

//Initial form data
function initialData() {
    $("#timestamp_new").val(calcTimestamp());
    $("#dificulty_new").val(1);
    $("#merkle_root_new").val(randomHash());
    $("#nonce_new").val(1);
}

$(document).ready(function() {
    initialData();
    console.log(input_data);
    $("#hash_button_new").click(function(){
        console.log(button_disabled);
        if(!concatById(input_data) || button_disabled) return;
        var hash = Crypto.SHA256(String(hash_message));
        correctHash(hash,$("#dificulty_new").val());
    });
    $("#random_hash_new").click(function(){
      $("#merkle_root_new").val(randomHash());
    });
});

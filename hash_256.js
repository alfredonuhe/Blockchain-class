/*Use the 3-5-1 combination in order to check mechanism of
the simulation */

//Defining global variables
var imput_ids = ["#Block_number_new","#merkle_root_new","#dificulty_new","#nonce_new"];
var hash_message= '';
var button_disabled = false;
//var timer = true;
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

// Disables 'Try' button after finding a correct hash
function disableButton(){
  button_disabled = true;
  console.log("disabled");
  window.setTimeout(function(){
    console.log("enabled");
    button_disabled = false;}
  ,5000);
}

//Checks if result of hash is a corerct hash
function correctHash(hash, dificulty) {
    correctHashStyle(false);
    $("#block_hash_new").val(hash);
    for (var i = 0; i < dificulty; i++) {
      if (hash.charAt(i) != "0") {
          return;
      }
    }
    correctHashStyle(true);
    disableButton();
    resfreshPannel(hash, hash_message);
    console.log(hash);
    console.log(hash_message);
    post_Hash(hash, hash_message);
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
    var lastNonce = parseInt($("#nonce_new").val()) +1;
    $("#nonce_new").val(lastNonce);
}

//Concatenates all of the values of the form
//only if all data is providad in the form
function concatById(imput_ids) {
  hash_message='';
  for (i = 0; i < imput_ids.length; i++) {
      if(!isNumber($(imput_ids[i]).val())){
        alert("Enter correct values " + i);
        return false;
      }
      hash_message = hash_message.concat($(imput_ids[i]).val());
  }
  //console.log(hash_message);
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

//shift left array
function shiftLeft(array){
  for (var i = 0; i < array.length-1; i++) {
    array[i+1]=array[i]
  }
  array[0]= undefined;
}

//check if array is full
function isFull(array){
  for (var i = 0; i < array.length; i++) {
    if (array[i]==undefined) {
      return false;
    }
  }
  return true;
}

//fill in empty spot
function fillFirst(array, value){
  for (var i = 0; i < array.length; i++) {
    if (array[i] == 'undefined') {
      array[i]= value;
      return true;
    }
  }
  return false;
}

//test hiding and showing hash text areas
function resfreshPannel(hash, hash_message){
  var infoBlock_aux = new infoBlock(hash, hash_message);
  var dinamic_board = document.getElementsByClassName("dinamic_board");
  if (new_queue.size() == 5) {
    new_queue.dequeue();
    new_queue.enqueue(infoBlock_aux);
  }else {
    new_queue.enqueue(infoBlock_aux);
  }
  for (var i = 0; i < dinamic_board.length; i++) {
    if (i<new_queue.size()) {
      dinamic_board[i].style.display = "";
      dinamic_board[i].value = new_queue._storage[i].hash
    }else {
      dinamic_board[i].style.display = "none";
    }

  }

/*
  console.log("here");
  console.log("here: " + dinamic_board[0].style.display);
  var dinamic_board = document.getElementsByClassName("dinamic_board");
  var time= 1000;
    for (var i = 0; i < 1; i++) {
      console.log(time);
      setInterval(function(){
          dinamic_board[0].style.display = "none";
      }, time);
      time= time +1000;
      console.log(time);
      setInterval(function(){
          dinamic_board[1].style.display = "none";
      }, time);
      time= time +1000;
      console.log(time);
      setInterval(function(){
          dinamic_board[2].style.display = "none";
      }, time);
      time= time +1000;
      console.log(time);
      setInterval(function(){
          dinamic_board[3].style.display = "none";
      }, time);
      time= time +1000;
      console.log(time);
      setInterval(function(){
          dinamic_board[4].style.display = "none";
      }, time);
      time= time +1000;
      console.log(time);
      setInterval(function(){
          dinamic_board[5].style.display = "none";
      }, time);
      time= time +1000;
      console.log(time);
      //oposite
      setInterval(function(){
          dinamic_board[0].style.display = "";
      }, time);
      time= time +1000;
      console.log(time);
      setInterval(function(){
          dinamic_board[1].style.display = "";
      }, time);
      time= time +1000;
      console.log(time);
      setInterval(function(){
          dinamic_board[2].style.display = "";
      }, time);
      time= time +1000;
      console.log(time);
      setInterval(function(){
          dinamic_board[3].style.display = "";
      }, time);
      time= time +1000;
      console.log(time);
      setInterval(function(){
          dinamic_board[4].style.display = "";
      }, time);
      time= time +1000;
      console.log(time);
      setInterval(function(){
          dinamic_board[5].style.display = "";
      }, time);
      time= time +1000;
      console.log(time);
    }*/
}

$(document).ready(function() {

    $("#hash_button_new").click(function(){
        console.log(button_disabled);
        if(!concatById(imput_ids) || button_disabled) return;
        var hash = Crypto.SHA256(String(hash_message));
        newNonce();
        correctHash(hash,$(imput_ids[2]).val());
    });
});

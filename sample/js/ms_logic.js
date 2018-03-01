//Checks if result of hash is a corerct hash
function correctHash(hash, dificulty) {
  $("#block_hash_new").val(hash);
  for (var i = 0; i < dificulty; i++) {
    if (hash.charAt(i) != "0") {
      newNonce();
      return;
    }
  }
  correctHashStyle(true);
  disableButton();
  postForm();
  newNonce();
  return;
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
  console.log(hash_message);
  return true;
}
//revisar
//Updates queue of recent blocks
function updateStylesQueue(){
  if (new_queue._newestIndex == new_queue._oldestIndex) return;
  var new_data = new_queue._storage[0].block_hash_ms;
  if (recent_queue._storage[0] == new_data) {
    console.log("same hash");
    return;
  }
  if(recent_queue.size() < new_queue.size()){
    recent_queue.enqueue(new_queue._storage[0].block_hash_ms);
    window.setTimeout(function(){ recent_queue.dequeue();}, 5000);
  }else{
    recent_queue.dequeue();
    recent_queue.enqueue(new_queue._storage[0].block_hash_ms);
    window.setTimeout(function(){ recent_queue.dequeue();}, 5000);
  }
}
//revisar
//Sets styles for recent blocks
function findInPannel(dinamic_board){
  for (var i = 0; i < dinamic_board.length; i++) {
    for (var j = 0; j < recent_queue.size(); j++) {
      if (recent_queue._storage[j] == dinamic_board[i].getElementsByTagName('input')[0].value) {
        dinamic_board[i].getElementsByTagName('input')[0].setAttribute("style",
         "background-color: #eaffef; border: 3px solid #34ab30;");
         break;
      }
      dinamic_board[i].getElementsByTagName('input')[0].setAttribute("style",
       "background-color: #eee; border: 1px solid #ccc;");
    }
  }
}

//test hiding and showing hash text areas
function refreshPannelQ(new_queue){
  if (text_area_on) return;
  var dinamic_board = document.getElementsByClassName("dinamic_board");
    for (var i = 0; i < dinamic_board.length; i++) {
      if (i< new_queue.size()) {
        dinamic_board[i].style.display = "";
        dinamic_board[i].getElementsByTagName('input')[0].value = new_queue._storage[i].block_hash_ms;
      }else {
        dinamic_board[i].style.display = "none";
      }
    }
}

//Handles Server Sent Events
function sseHandler() {
  if(typeof(EventSource) !== "undefined") {
      var source = new EventSource("php/sse_test.php");
      source.onmessage = function(event) {
        var eventData = JSON.parse(event.data);
        /*revisar
        console.log(eventData);
        console.log(new_queue._storage[0]);
        console.log(eventData.storage[0]);*/
        if (JSON.stringify(new_queue._storage[0]) == JSON.stringify(eventData.storage[0])) return;
        // revisar console.log("beep");
        updateQueue(eventData);
        // revisar setBlockStyles();
        newBlockStyle(true);
        window.setTimeout(function(){setBlockStyles();}, 4000);
        refreshPannelQ(new_queue);
        playSound();
        console.log(new_queue);
      };
  } else {
      alert("Sorry, your browser does not support server-sent events...");
  }
}

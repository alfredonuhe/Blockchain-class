/*Use the 3-5-1 combination in order to check mechanism of
the simulation */

var imput_ids = ["#Block_number_new","#merkle_root_new","#dificulty_new","#nonce_new"];
var hash_message= '';

//Checks if value is a number
function isNumber(n) {
  return !isNaN(parseFloat(n)) && isFinite(n);
}

//Checks for mining result
function correctHash(hash, dificulty) {
    correctHashStyle(false);
    $("#block_hash_new").val(hash);
    for (var i = 0; i < dificulty; i++) {
      if (hash.charAt(i) != "0") {
          return;
      }
    }
    correctHashStyle(true);
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
    console.log(lastNonce);
    $("#nonce_new").val(lastNonce);
    console.log($("#nonce_new").val());
}

//Concatenates all of the values of the form
function concatById(imput_ids) {
  hash_message='';
  for (i = 0; i < imput_ids.length; i++) {
      if(!isNumber($(imput_ids[i]).val())){
        alert("Enter correct values " + i);
        return true;
      }
      hash_message = hash_message.concat($(imput_ids[i]).val());
  }
  //console.log(hash_message);
  return false;
}


$(document).ready(function() {
    $("#hash_button_new").click(function(){
        if(concatById(imput_ids)) return;
        console.log(hash_message);
        var hash = Crypto.SHA256(String(hash_message));
        console.log(hash);
        newNonce();
        correctHash(hash,$(imput_ids[2]).val());
    });
});

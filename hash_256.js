var imput_ids = ["#Block_number_new","#merkle_root_new","#dificulty_new","#nonce_new"];
var hash_message='';

//Checks if value is a number
function isNumber(n) {
  return !isNaN(parseFloat(n)) && isFinite(n);
}

//Checks for mining result
function correctHash(hash, dificulty) {
    for (var i = 0; i < dificulty; i++) {
      if (hash.charAt(i) != "0") {
          return false;
      }
    }
    return true;
}

//Concatenates all of the values of the form
function concatById(imput_ids, hash_message) {
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
        if(concatById(imput_ids,hash_message)) return;
        console.log(hash_message);
        var hash = Crypto.SHA256(String(hash_message));
        console.log(hash);
        $("#block_hash_new").attr("value", hash)
        if (correctHash(hash,$(imput_ids[2]).val())) {
          $("#block_hash_new").css("border","3px solid #34ab30")
        }
    });
});

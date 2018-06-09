<?php
class Queue{
  public $oldestIndex;
  public $newestIndex;
  public $storage;
  public $valid_prev_hash;
  public $valid_dificulty;
  public $valid_merkle;
  function __construct(){
    $this->oldestIndex = 0;
    $this->newestIndex = 0;
    $this->storage = array();
    $this->valid_prev_hash = null;
    $this->valid_dificulty = null;
    $this->valid_merkle = null;
  }
  function size(){
    return $this->newestIndex - $this->oldestIndex;
  }
  function enqueue($data){
    if ($this->oldestIndex !== $this->newestIndex) {
      $arrlength= count($this->storage);
      for ($i = $arrlength-1; $i >= 0 ; $i--) {
        $this->storage[$i+1]= $this->storage[$i];
      }
      $this->storage[0]= $data;
      $this->newestIndex++;
    }else{
      $this->storage[$this->oldestIndex]= $data;
      $this->newestIndex++;
    }
  }
  function dequeue(){
    if ($this->oldestIndex !== $this->newestIndex) {
          array_splice($this->storage, $this->newestIndex-1, 1);
        $this->newestIndex--;
    }
  }
  function printQueue(){
    $arrlength=$this->size();
    echo "queue size: ".$arrlength."<br>";
    echo "elements: ";
    for($x=0;$x<$arrlength;$x++){
      if ($x == $arrlength -1) {
        echo $this->storage[$x];
      }else{
        echo $this->storage[$x].", ";
      }
    }
    echo "<br>";
    echo var_dump($this->storage);
  }
}

?>

function Queue() {
    this._oldestIndex = 0;
    this._newestIndex = 0;
    this._storage = {};
}

Queue.prototype.size = function() {
    return this._newestIndex - this._oldestIndex;
};

Queue.prototype.enqueue = function(data) {
    if (this._oldestIndex !== this._newestIndex) {
      for (var i = this.size()-1; i >= 0 ; i--) {
        this._storage[i+1]= this._storage[i];
      }
      this._storage[0]= data;
      this._newestIndex++;
    }else{
      this._storage[this._oldestIndex]= data;
      this._newestIndex++;
    }
};

Queue.prototype.dequeue = function() {
    if (this._oldestIndex !== this._newestIndex) {
        delete this._storage[this._newestIndex-1];
        this._newestIndex--;
    }
};

Queue.prototype.print = function() {
    if (this._oldestIndex !== this._newestIndex) {
        for (var i = 0; i < this.size; i++) {
           console.log(this._storage[i]);
    }
    }else{
      console.log("empty");
    }
};

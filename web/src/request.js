var REQUEST = {
  isLoading:false,
  serverAddress:'http://localhost/remindme/server/'
};

REQUEST.send = function(path ,method, callback, data){
  //manual flag for debugging.
  var serverDebug = false;
  var _this = this;

  _this.isLoading = true;
  $.ajax({
    url:_this.serverAddress + path + (serverDebug?'?debug=true':''),
    type:method,
    data:data || {},
    statusCode:{
      200:function(data){
        _this.isLoading = false;
        callback(data);
      },
      503:function(data){
        _this.isLoading = false;
        console.log(data.responseText);
        callback(data.responseText);
      }
    }
  });
};
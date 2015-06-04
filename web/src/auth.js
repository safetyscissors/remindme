
$('#authGet').on('click', function(){
  console.log('get');
  var data = {
    userid:1
  }
  REQUEST.send('auth','get',logBack, data);
});

$('#authPost').on('click', function(){
  console.log('post');
  var data = {
    userid:1,
    password:'asdf'
  };

  REQUEST.send('auth','post', logBack, data);
});

$('#authPut').on('click', function(){
  console.log('put');
  var data = {
    userid:1,
    password:'newpass'
  };
  REQUEST.send('auth','put', logBack, data);
});

$('#authDelete').on('click', function(){
  console.log('delete');
  REQUEST.send('auth','delete', logBack);
});




function logBack(data){
  var serverData = (data)? JSON.parse(data):'';
  console.log(serverData, 'done');
}
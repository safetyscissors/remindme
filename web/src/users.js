
$('#userGet').on('click', function(){
  console.log('get');
  var data = {
    userid:1
  }
  REQUEST.send('user','get',logBack, data);
});

$('#userPost').on('click', function(){
  console.log('post');
  var data = {
    name:'andrew',
    email:'asfd@asdf.com',
    password:'asdf'
  };

  REQUEST.send('user','post', logBack, data);
});

$('#userPut').on('click', function(){
  console.log('put');
  var data = {
    userid:1,
    name:'notandrew',
    email:'asfd@asdf.com',
    password:'asdf'
  };
  REQUEST.send('user','put', logBack, data);
});

$('#userDelete').on('click', function(){
  console.log('delete');
  var data = {
    userid:2
  };
  REQUEST.send('user','delete', logBack, data);
});




function logBack(data){
  var serverData = (data)? JSON.parse(data):'';
  console.log(serverData, 'done');
}
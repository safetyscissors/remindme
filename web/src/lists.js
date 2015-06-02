
$('#listGet').on('click', function(){
  console.log('get');
  REQUEST.send('list','get',logBack);
});

$('#listPost').on('click', function(){
  console.log('post');
  var data = {
    name:'andrew',
    type:'list'
  };

  REQUEST.send('list','post', logBack, data);
});

$('#listPut').on('click', function(){
  console.log('put');
  var data = {
    listid:5,
    name:'andrew',
    type:'list'
  };
  REQUEST.send('list','put', logBack, data);
});

$('#listDelete').on('click', function(){
  console.log('delete');
  var data = {
    listid:6
  };
  REQUEST.send('list','delete', logBack, data);
});

function logBack(data){
  var serverData = (data)? JSON.parse(data):'';
  console.log(serverData, 'done');
}

$('#listItemGet').on('click', function(){
  console.log('get');
  var data={
    listid:1
  };
  REQUEST.send('listItem','get',logBack,data);
});

$('#listItemPost').on('click', function(){
  console.log('post');
  var data = {
    name:'item1',
    type:'checkbox'
  };
  REQUEST.send('listItem','post', logBack, data);
});

$('#listItemPut').on('click', function(){
  console.log('put');
  var data = {
    listid:1,
    name:'newItem',
    type:'checkbox'
  };
  REQUEST.send('listItem','put', logBack, data);
});

$('#listItemDelete').on('click', function(){
  console.log('delete');
  var data = {
    listid:2
  };
  REQUEST.send('listItem','delete', logBack, data);
});

function logBack(data){
  var serverData = (data)? JSON.parse(data):'';
  console.log(serverData, 'done');
}
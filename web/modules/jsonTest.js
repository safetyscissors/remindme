var serverAddress = 'http://localhost/remindme';

var jsonApp = angular.module('jsonApp', ['ui.router'])
  .config(['$httpProvider', function ($httpProvider) {
    $httpProvider.defaults.useXDomain = true;
    delete $httpProvider.defaults.headers.common['X-Requested-With'];
  }])


  .controller('Auth', function ($scope, $http){
    $scope.loginState=null;

    //on init, get login status
    $http.get(serverAddress + '/server/auth')

      //logged in
      .success(function(data){
        $scope.loginState = true;
      })

      //not logged in
      .error(function(data, status, headers, config){
        if(status == 401){
          return $scope.loginState = false;
        }
        $scope.errorMessage = "sorry. cant login. Server says:" + data.errors;

      });

    //on login submit, call auth
    $scope.auth = function(){
      var data = {
        email:'asdf@asdf.com',
        password:'newpass'
      };
      var url = serverAddress + '/server/auth';
      $http({
        method: 'POST',
        url: url,
        data: toParam(data),
        headers: {'Content-Type': 'application/x-www-form-urlencoded'}
      }).success(function(data){
        $scope.loginState = true;
      }).error(function(data, status, headers, config){
        $scope.errorMessage = "sorry. couldnt add this list. Server says:" + data.errors;
      });
    };

    $scope.logout = function(){
      var url = serverAddress + '/server/auth';
      $http({
        method: 'DELETE',
        url: url
      }).success(function(){
        $scope.loginState = false;
      }).error(function(data, status, headers, config){
        $scope.errorMessage = "sorry. couldnt logout. Server says:" + data.errors;
      });
    }
  })


  .controller('Lists', function($scope, $http){
    $scope.selectedList = null;
    $scope.listOfLists = [];
    $scope.loginState = false;

    checkLogin($http, function(status){
      console.log(status);
    });





  })


  .controller('oldLists', function ($scope, $http) {
    $scope.selectedList = null;
    $scope.listOfLists = [];
    $scope.listItems = [];

    $http.get(serverAddress + '/server/list')
      .success(function(data){
        $scope.listOfLists = data;
        if($scope.listOfLists.length>0){
          $scope.selectedList = $scope.listOfLists[0]['Id'];
          $scope.loadList(1);
        }
      })
      .error(function(data, status, headers, config){
        $scope.errorMessage = "sorry. cant find this list. Server says:" + data.errors;
      });

    $scope.loadList = function(listId){
      $http.get(serverAddress + '/server/listItem' + '?listid=' + listId)
        .success(function(data){
          $scope.listItems = data;
          console.log(data);
          $scope.selectedList = listId;
        })
        .error(function(data, status, headers, config){
          $scope.errorMessage = "sorry. cant find list items. Server says:" + data.errors;
        })
    };

    $scope.addList = function(){
      var data = {
        name:$scope.listName,
        type:'list'
      };
      var url = serverAddress + '/server/list';

      $http({
        method: 'POST',
        url: url,
        data: toParam(data),
        headers: {'Content-Type': 'application/x-www-form-urlencoded'}
      }).success(function(data){
        console.log('success:',data);
      }).error(function(data, status, headers, config){
        $scope.errorMessage = "sorry. couldnt add this list. Server says:" + data.errors;
      });
    };

    $scope.addItem = function(){
      var data = {
        listid:$scope.selectedList,
        name:$scope.itemName,
        type:'checkbox'
      };
      var url = serverAddress + '/server/listItem';
      $http({
        method: 'POST',
        url: url,
        data: toParam(data),
        headers: {'Content-Type': 'application/x-www-form-urlencoded'}
      }).success(function(data){
        console.log('success:',data);
      }).error(function(data, status, headers, config){
        $scope.errorMessage = "sorry. couldnt add this item. Server says:" + data.errors;
      });
    };


  });


function toParam(obj) {
  var p = [];
  for (var key in obj) {
    p.push(key + '=' + encodeURIComponent(obj[key]));
  }
  return p.join('&');
}

function checkLogin(httpModule, callback){
  httpModule.get(serverAddress + '/server/auth')
    .success(function(){
      callback(200);
    })
    .error(function(data, status){
      callback(status);
    });
}

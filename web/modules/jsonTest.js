var serverAddress = 'http://localhost/remindme';

angular.module('jsonApp', [])
  .config(['$httpProvider', function ($httpProvider) {
    $httpProvider.defaults.useXDomain = true;
    delete $httpProvider.defaults.headers.common['X-Requested-With'];
  }])
  .controller('Lists', function ($scope, $http) {
    $scope.selectedList = null;
    $scope.listOfLists = null;
    $scope.listItems = null;

    $http.get(serverAddress + '/server/list')
      .success(function(data){
        $scope.listOfLists = data;
        if($scope.listOfLists.length>0){
          $scope.selectedList = $scope.listOfLists[0]['Id'];
          $scope.loadList()
        }
      })
      .error(function(data, status, headers, config){
        $scope.errorMessage = "sorry. cant find this list. Server says:" + data.errors;
      });

    $scope.loadList = function(){
      $http.get(serverAddress + '/server/listItem' + '?listid=' + $scope.selectedList)
        .success(function(data){
          $scope.listItems = data;
          console.log(data);
        })
        .error(function(data, status, headers, config){
          $scope.errorMessage = "sorry. cant find list items. Server says:" + data.errors;
        })
    };

  });


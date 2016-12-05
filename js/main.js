var app = angular.module('SomeApp', ['ngCookies', 'ngRoute', 'ngResource', 'mm.foundation']);

app.directive('routeLoader', function() {
  return {
    restrict: 'EA',
    link: function(scope, element) {
      // Store original display mode of element
      var shownType = element.css('display');
      function hideElement() {
        element.css('display', 'none');
      }

      scope.$on('$routeChangeStart', function() {
        element.css('display', shownType);
      });
      scope.$on('$routeChangeSuccess',hideElement);
      scope.$on('$routeChangeError', hideElement);
      // Initially element is hidden
      hideElement();
    }
  }
});

app.controller('TeamsController', function($scope, $routeParams, $http) {
  $scope.name = "TeamsController";
  $scope.params = $routeParams;

  $scope.teamData = {
    td: null,

    getData: function(){
      $http({
        method: 'POST',
        url: '/php/post.teams.selected.php',
        data: {teamid: $scope.params.teamid}
      }).then(function successCallback(response) {
          $scope.td = response.data;
        }, function errorCallback(response) {
          console.log("Failed to retrieve data Team Information.")
        });
    }

  };

  $scope.deleteTeam = function(check){
    console.log(check);
    if(check == true){
      $http({
        method: 'POST',
        url: '/php/post.teams.delete.php',
        data: {teamid: $scope.params.teamid}
      }).then(function successCallback(response) {
          $location.path('/main');
        }, function errorCallback(response) {
          return ["Failed to delete team."];
        });
    }
  };

  $scope.userData = {

    lookUp: function(val){
      return $http({
        method: 'POST',
        url: '/php/post.user.lookup.php',
        data: {username: val}
      }).then(function (response) {
        return response.data;
      });
    },

    addUserTeam: function(val){
      $http({
        method: 'POST',
        url: '/php/post.teams.user.php',
        data: {username: val, teamid: $scope.params.teamid}
      }).then(function successCallback(response) {
        $scope.teamData.getData();
      });
    },

    removeUserTeam: function(val){
      $http({
        method: 'POST',
        url: '/php/post.teams.remove.user.php',
        data: {userid: val}
      }).then(function successCallback(response) {
        $scope.teamData.getData();
      });
    }
  };
});

app.controller('UsersController', function($scope, $routeParams, $http){
  $scope.name = 'UsersController';
  $scope.params = $routeParams;

  $scope.userData = {
    ud: null,

    getData: function(){
      $http({
        method: 'POST',
        url: '/php/post.user.selected.php',
        data: {userid: $scope.params.userid}
      }).then(function successCallback(response){
        console.log(response.data);
        $scope.ud = response.data;
      }, function errorCallback(response){
        console.log("no user info 4 u")
      });
    }
  };


});

app.controller('MainController', function($scope, $route, $routeParams, $location, $cookies, $cookieStore) {
     $scope.$route = $route;
     $scope.$location = $location;
     $scope.$routeParams = $routeParams;
});

app.config(function($routeProvider, $locationProvider){
  $locationProvider.html5Mode(true).hashPrefix('!');

  $routeProvider
    .when('/main', {
      templateUrl: '/js/templates/templateHome.html',
    })
    .when('/teams/:teamid', {
      templateUrl: '/js/templates/templateTeams.html',
      controller: 'TeamsController'
    })
    .when('/users/:userid', {
      templateUrl: '/js/templates/templateUsers.html',
      controller: 'UsersController'
    })
    .otherwise({
      redirectTo: '/main'
    })
});

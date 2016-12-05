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
  $scope.update_imglink = null;
  $scope.update_desc = null;
  

  $scope.teamData = {
    td: null,

    getData: function(){
      $http({
        method: 'POST',
        url: '/php/post.teams.selected.php',
        data: {teamid: $scope.params.teamid}
      }).then(function successCallback(response) {
          $scope.td = response.data;
          $scope.update_imglink = response.data.Team.ImgLink;
          $scope.update_desc = response.data.Team.Descr
        }, function errorCallback(response) {
          console.log("Failed to retrieve data Team Information.")
        });
    }

  };

  $scope.deleteTeam = function(check){
    if($scope.validateMe() == $scope.td.Team.Owner){
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
      $scope.warnMe("success");
    }else{
      $scope.warnMe("warning");
    }
  };

  $scope.updateTeam = function(val1, val2){
    if($scope.validateMe() == $scope.td.Team.Owner){
      $http({
          method: 'POST',
          url: '/php/post.teams.update.php',
          data: {teamid: $scope.params.teamid, imglink: val1, desc: val2}
        }).then(function successCallback(response) {
            $scope.teamData.getData();
          }, function errorCallback(response) {
            return ["Failed to delete team."];
          });
        $scope.warnMe("success");
    }else{
      $scope.warnMe("warning");
    }
  };

  $scope.compData = {
    cd: null,

    getData: function(){
      $http({
        method: 'POST',
        url: '/php/post.teams.comp.php',
        data: {teamid: $scope.params.teamid}
      }).then(function successCallback(response) {
          $scope.cd = response.data;
        }, function errorCallback(response) {
          console.log("Failed to retrieve data Team Information.")
        });
    },

    removeTeamComp: function(val){
      if($scope.validateMe() == $scope.td.Team.Owner){
        $http({
          method: 'POST',
          url: '/php/post.teams.remove.user.php',
          data: {teamid: $scope.params.teamid}
        }).then(function successCallback(response) {
          $scope.compData.getData();
        });
        $scope.warnMe("success");
      }else{
        $scope.warnMe("warning");
      } 
      
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
      if($scope.validateMe() == $scope.td.Team.Owner){
           $http({
            method: 'POST',
            url: '/php/post.teams.user.php',
            data: {username: val, teamid: $scope.params.teamid}
          }).then(function successCallback(response) {
            $scope.teamData.getData();
          });
          $scope.warnMe("success");
      }else{
        $scope.warnMe("warning");
      } 
    },

    removeUserTeam: function(val){
      if($scope.validateMe() == $scope.td.Team.Owner){
        $http({
          method: 'POST',
          url: '/php/post.teams.remove.user.php',
          data: {userid: val}
        }).then(function successCallback(response) {
          $scope.teamData.getData();
        });
        $scope.warnMe("success");
      }else{
        $scope.warnMe("warning");
      } 
      
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
        $scope.ud = response.data;
      }, function errorCallback(response){
        console.log("no user info 4 u")
      });
    }
  };


});

app.controller('MainController', function($modal, $timeout, $scope, $route, $routeParams, $location, $cookies, $cookieStore) {
    $scope.$route = $route;
    $scope.$location = $location;
    $scope.$routeParams = $routeParams;
    $scope.currentUser = $cookies.getObject('currentUser');
    $scope.currentAlert = null;
    $scope.validateAlert = {
      warning: {type: 'warning', msg: "Unauthorized User!"},
      success: {type: 'success', msg: "The action was successful!"},
      loginFailed: {type: 'warning', msg: "The login has failed, try again."},
      loginSuccess: {type: 'success', msg: "You have been logged in."}
    };
     $scope.items = ['item1', 'item2', 'item3'];

    $scope.validateMe = function(){
        return currentUser.id;
    }

    $scope.warnMe = function(alert) {
        $scope.currentAlert = $scope.validateAlert[alert];
        $scope.alertDisplayed = true;
      $timeout(function() {
        $scope.alertDisplayed = false;
      }, 2000)
    };

    $scope.logout = function() {
      $cookies.remove('currentUser');
      $scope.currentUser = null;
    };
});

app.controller('LoginController', function($location, $scope, $routeParams, $http, $cookies, $cookieStore){
  $scope.name = 'LoginController';
  $scope.params = $routeParams;

  $scope.login = function(username, password){
    $http({
          method: 'POST',
          url: '/php/cookie.user.login.php',
          data: {username: username, password: password}
        }).then(function successCallback(response) {
          if(typeof response.data === 'object'){
            $cookies.putObject('currentUser', response.data);
            $location.path('/main');
            $route.reload();
            $scope.warnMe("loginSuccess");
          }else{
            $scope.warnMe("loginFailed");
          }    
    });
  };

  $scope.forgot = function(username){
    
  };


});

app.controller('RegisterController', function($scope, $routeParams, $http){
  $scope.name = 'RegisterController';
  $scope.params = $routeParams;

  $scope.register = function(username, password){

  };

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
    .when('/login', {
      templateUrl: '/js/templates/templateLogin.html',
      controller: 'LoginController'
    })
    .when('/register', {
      templateUrl: '/js/templates/templateRegister.html',
      controller: 'RegisterController'
    })
    .otherwise({
      redirectTo: '/main'
    })
});

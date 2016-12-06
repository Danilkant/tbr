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
    if($scope.currentUser.id == $scope.td.Team.Owner){
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
    if($scope.currentUser.id == $scope.td.Team.Owner){
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
      if($scope.currentUser.id == $scope.td.Team.Owner){
        console.log(val);
        $http({
          method: 'POST',
          url: '/php/post.comp.remove.team.php',
          data: {teamid: $scope.params.teamid, compid: val}
        }).then(function successCallback(response) {
          $scope.warnMe("success");
          $scope.compData.getData();
        });

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
      if($scope.currentUser.id == $scope.td.Team.Owner){
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
      if($scope.currentUser.id == $scope.td.Team.Owner){
        console.log(true);
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


  $scope.userData = {
    ud: null,

    inputEmail: null,
    inputUsername: null,
    inputPassword: null,
    inputTeamName: null,
    inputTeamTag: null,
    inputTeamDesc: null,

    getData: function(){
      $http({
        method: 'POST',
        data: {userid: $scope.params.userid}
      }).then(function successCallback(response){
        $scope.ud = response.data;
        console.log("accordion is love, accordion is life");
      }, function errorCallback(response){
        console.log("no user info 4 u")
      });
    },//getdata end

    removeUserTeam: function(val, val2) {
      $http({
        method: 'POST',
        url: '/php/post.teams.remove.user.php',
        data: {userid: val, teamid: val2}
      }).then(function successCallback(response){
        $scope.userData.getData();
        console.log(response);
      });
    },//removeuserteam func end

    updateUserPassword: function(val, val2){
      $http({
        method: 'POST',
        url: '/php/post.user.password.update.php',
        data: {userid: val, password: val2}
      }).then(function successCallback(response){
        $scope.userData.getData();
        console.log(response);
      });
    },//update userpasswrod end

     updateUserEmail: function(val, val2){
      console.log(val, val2);
      $http({
        method: 'POST',
        url: '/php/post.user.update.php',
        data: {userid: $scope.params.userid, email: val, username: val2}
      }).then(function successCallback(response){
        $scope.userData.getData();
        console.log(response);
      });
    },//function end

    userCreateNewTeam: function(val, val2, val3, val4){
      console.log(val, val2, val3, val4);
      $http({
        method: 'POST',
        url: '/php/post.teams.new.php',
        data: {teamname: val, teamtag: val2, desc: val3, userid: val4}
      }).then(function successCallback(response){
        $scope.userData.getData();
    console.log(response);
      });
    }//function end
  };//scope end


});

app.controller('CompController', function($scope, $http) {
    $scope.name = 'CompController';

    $scope.compData = {
      cd: null,

      getData: function(){
        $http({
          method: 'POST',
          url: '/php/post.comp.all.php'
        }).then(function successCallback(response){
          $scope.cd = response.data;
        });
      }
    }

    $scope.teamData = {
      td: null,

      getData: function(){
        $http({
          method: 'POST',
          url: '/php/post.teams.user.selected.php',
          data: {userid: $scope.currentUser.id}
        }).then(function successCallback(response){
          $scope.td = response.data;
        });
      }
    }

    $scope.gameData = {
      gd: null,

      getData: function(){
        $http({
          method: 'POST',
          url: '/php/post.game.all.php'
        }).then(function successCallback(response){
          $scope.gd = response.data;
        });
      }
    }

    $scope.registerTeam = function(compid, teamid){
      $scope.teamData.getData()
        $http({
            method: 'POST',
            url: '/php/post.comp.team.php',
            data: {compid: compid, teamid: teamid}
          }).then(function successCallback(response){
            $scope.warnMe("success");
        });
    }
});

app.controller('AdminController', function($scope, $http) {
    $scope.name = 'AdminController';

    $scope.gameData = {
      gd: null,

      getData: function(){
        $http({
          method: 'POST',
          url: '/php/post.game.all.php'
        }).then(function successCallback(response){
          $scope.gd = response.data;
        });
      }
    }

    $scope.createComp = function(id, date, desc, prize){
      $http({
          method: 'POST',
          url: '/php/post.comp.create.php',
          data: {gameid: id, date: date, desc: desc, prize: prize}
        }).then(function successCallback(response){
          window.location = "/main";
          $scope.warnMe("success");
        });
    }
});

app.controller('MainController', function($modal, $http, $timeout, $scope, $route, $routeParams, $location, $cookies, $cookieStore) {
    $scope.$route = $route;
    $scope.$location = $location;
    $scope.$routeParams = $routeParams;
    $scope.currentUser = $cookies.getObject('currentUser');
    $scope.currentAlert = null;
    $scope.validateAlert = {
      warning: {type: 'warning', msg: "Unauthorized User!"},
      success: {type: 'success', msg: "The action was successful!"},
      failed: {type: 'warning', msg: "The action was unsuccessful."},
      loginFailed: {type: 'warning', msg: "The login has failed, try again."},
      loginSuccess: {type: 'success', msg: "You have been logged in."}
    };
     $scope.items = ['item1', 'item2', 'item3'];

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

    $scope.isAdmin = function(){
      var temp = $scope.currentUser.id;
      if(temp != null){
        $http({
          method: 'POST',
          url: '/php/post.isAdmin.php',
          data: {userid: temp}
        }).then(function successCallback(response){
          $scope.currentUser["admin"] = response.data;
        });
      }else{
        return false;
      }
    };
});

app.controller('LoginController', function($scope, $routeParams, $http, $cookies, $cookieStore){
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
            window.location = "/main";
            $scope.warnMe("loginSuccess");
          }else{
            $scope.warnMe("loginFailed");
          }    
    });
  };
});

app.controller('RegisterController', function($scope, $routeParams, $http){
  $scope.name = 'RegisterController';

  $scope.register = function(username, name, email){
    $http({
          method: 'POST',
          url: '/php/post.user.new.php',
          data: {username: username, name: name, email: email}
        }).then(function successCallback(response) {
            window.location = "/login";
            $scope.warnMe("success");
    });
  };

});


app.config(function($routeProvider, $locationProvider){
  $locationProvider.html5Mode(true).hashPrefix('!');

  $routeProvider
    .when('/main', {
      templateUrl: '/js/templates/templateHome.html'
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
    .when('/admin', {
      templateUrl: '/js/templates/templateAdminPage.html',
      controller: 'AdminController'
    })
    .otherwise({
      redirectTo: '/main'
    })
});
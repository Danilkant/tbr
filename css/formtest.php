<!DOCTYPE html>
<html>
    <head>
        <base href="/"></base>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Foundation | Welcome</title>
        <link rel="stylesheet" href="css/foundation.css" />
        <link rel="stylesheet" href="css/main.css" />
        <link rel="stylesheet" href="css/form.css" />

        <script src="/js/vendor/modernizr.js"></script>
        <script src="//ajax.googleapis.com/ajax/libs/angularjs/1.5.0-beta.1/angular.js"></script>
        <script src="//ajax.googleapis.com/ajax/libs/angularjs/1.5.0-beta.1/angular-route.js"></script>
        <script src="//ajax.googleapis.com/ajax/libs/angularjs/1.5.0-beta.1/angular-resource.js"></script>
        <script src="/js/mm-foundation-tpls-0.8.0.min.js"></script>
        <script type="text/javascript" src="/js/main.js"></script>
    </head>

    <body ng-app="SomeApp">
    <div>
    <div class="row">
  <div class="medium-6 medium-centered large-4 large-centered columns">

    <form>
      <div class="row column log-in-form">
        <h4 class="text-center">Log in with you email account</h4>
        <label>Email
          <input type="text" placeholder="somebody@example.com">
        </label>
        <label>Password
          <input type="text" placeholder="Password">
        </label>
        <input id="show-password" type="checkbox"><label for="show-password">Show password</label>
        <p><a type="submit" class="button expanded">Log In</a></p>
        <p class="text-center"><a href="#">Forgot your password?</a></p>   
      </div>
    </form>

  </div>
</div>
    </div>   
    <div ng-controller="MainController">
        <div ng-view></div>
    </div>
    </body>
</html>
<!DOCTYPE html>
<html>
    <head>
        <base href="/"></base>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Foundation | Welcome</title>
        <link rel="stylesheet" href="css/foundation.css" />
        <link rel="stylesheet" href="css/main.css" />

        <script src="/js/vendor/modernizr.js"></script>
        <script src="//ajax.googleapis.com/ajax/libs/angularjs/1.5.0-beta.1/angular.js"></script>
        <script src="//ajax.googleapis.com/ajax/libs/angularjs/1.5.0-beta.1/angular-route.js"></script>
        <script src="//ajax.googleapis.com/ajax/libs/angularjs/1.5.0-beta.1/angular-resource.js"></script>
        <script src="/js/mm-foundation-tpls-0.8.0.min.js"></script>
        <script type="text/javascript" src="/js/main.js"></script>

    <style>
    #test {
        background-color:red;
    }
    #test2 {
        background-color:blue;
    }
    </style> 
    </head>

<?php

echo "<table style='border: solid 1px black;'>";
echo "<tr><th>Id</th><th>Firstname</th><th>Lastname</th></tr>";

class TableRows extends RecursiveIteratorIterator { 
     function __construct($it) { 
         parent::__construct($it, self::LEAVES_ONLY); 
     }

     function current() {
         return "<td style='width: 150px; border: 1px solid black;'>" . parent::current(). "</td>";
     }

     function beginChildren() { 
         echo "<tr>"; 
     } 

     function endChildren() { 
         echo "</tr>" . "\n";
     } 
} 

try {
    require_once 'connection.php';
    require_once 'klasar\users.php';
    /*
     $dbUser = new User($connection);
     $dbUser->getUserData($id);   
    */

     // set the resulting array to associative
    $result = $stmt->setFetchMode(PDO::FETCH_ASSOC); 
    $stmt = $conn->prepare("SELECT id, firstname, lastname FROM user"); 
     $stmt->execute();
     foreach(new TableRows(new RecursiveArrayIterator($stmt->fetchAll())) as $k=>$v) { 
         echo $v;
     }
}
catch(PDOException $e) {
     echo "Error: " . $e->getMessage();
}
$conn = null;
echo "</table>";

?>

    <body ng-app="userApp">
    <div route-loader>
    <h1> This is the user page </h1>     
    </div>    
    <div ng-controller="MainController">
    <div id="test1" class="large-6 columns">
    <form>
    <fieldset>
    <legend>Fieldset Legend</legend>

    <label>Input Label
      <input type="text" placeholder="Inputs and other form elements go inside...">
    </label>
    </fieldset>
    </form>
    </div>
    <div id="test2" class="large-6 columns">
    <h1> Test </h1>
    </div>
        <div ng-view></div>
    </div>
    </body>
</html>
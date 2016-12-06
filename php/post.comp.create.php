<?php
    require('init.database.php');

    $data = json_decode(file_get_contents('php://input'));

    $gameid = $data->gameid;

    $date = strtotime($data->date);

	$datesql = date('Y-m-d H:i:s', $date);

    $desc = $data->desc;

    $prize = $data->prize;

    $sth = $dbh->prepare('INSERT IGNORE INTO comp(games_id, compDate, description, prize)
                    VALUES (:gameid, :compdate, :description, :prize)');
    $sth->bindParam(':gameid', $gameid);
    $sth->bindParam(':compdate', $datesql);
    $sth->bindParam(':description', $desc);
    $sth->bindParam(':prize', $prize);
              
    $sth->execute();
?>

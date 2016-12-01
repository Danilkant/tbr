<?php

class User
{

	private $dbh;

	public function __construct($connection_name)
		{
			
			if(!empty($connection_name)){

				$this->dbh = $connection_name;
			}
			else{
				throw new Exception("cant connect to database");
			}
		}
//TEMPLATES - WORK IN PROGRESS
	//Create New User
	public function newUser($username, $email)
		{
					//Undirbúið sql fyrir insert skipun
					$sth = $this->dbh->prepare("INSERT INTO user(username, email)
						VALUES (:username, :email)");
					//Placeholderar og breytur bundnar saman
					$sth->bindParam(':username', $username);
					$sth->bindParam(':email', $email);	
				try{
					$sth->execute();
					return true;
				}
				catch(PDOException $e)
				{
					echo "Error: " . $e->getMessage();
					return false;
				}      
			
		}
    //Create new team
    public function newTeam($teamname, $teamtag, $description)
    {
                $sth = $this->dbh->prepare('INSERT INTO teams(teamname, teamtag, description)
                    VALUES (:teamname, :teamtag, :description)');
                $sth->bindParam(':teamname', $teamname);
                $sth->bindParam(':teamtag', $teamtag);
                $sth->bindParam(':description', $description);

        	try {                              
                $sth->execute();

                return true;                
            }
            catch (Exception $e) {
                echo "Error: " . $e->getMessage();
                return false;
            }       
    }    

	//Fetching team data
	public function fetchTeamData()
    {    
    $data = json_decode(file_get_contents('php://input'));
    $ID = $data->teamid;
    $toReturn = [];
    $temparr1 = [];
    $temparr2 = [];
    $keyword1 = "Team";
    $keyword2 = "User";
    $sth = $this->dbh->prepare('SELECT 
      id as ID,
      teamname as Name, 
      teamtag as Tag, 
      description as Descr, 
      imgLink as ImgLink
      from team
      where id = :ID
      ');
    $sth->bindParam(':ID', $ID, PDO::PARAM_INT);
    $sth->execute();
    $sth->setFetchMode(PDO::FETCH_ASSOC);
    $temparr1 = $sth->fetch();
    $sth = $this->dbh->prepare('SELECT 
      u.id as ID, 
      u.username as Name
      from team_user tu
      inner join user u on tu.user_id = u.id
      where tu.team_id = :ID
      ');
    $sth->bindParam(':ID', $ID, PDO::PARAM_INT);
    $sth->execute();
    $sth->setFetchMode(PDO::FETCH_ASSOC);
    $temparr2 = $sth->fetchAll();
    $toReturn[$keyword1] = $temparr1;
    $toReturn[$keyword2] = $temparr2;
    echo(json_encode($toReturn, JSON_UNESCAPED_SLASHES));
    }

    public function fetchUserData($username)
    {        
        $data = json_decode(file_get_contents('php://input'));
        $username = "o";
        $toReturn = [];
        $sth = $this->dbh->prepare('SELECT 
            id as ID, 
            username as Name
            from user
            where INSTR(username, :username) > 0
            ');
        $sth->bindParam(':username', $username, PDO::PARAM_STR);
        $sth->execute();
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $toReturn = $sth->fetchAll();
        echo(json_encode($toReturn));
    }

    public function fetchCompetitionData($)
    {
    	$data = json_decode(file_get_contents('php://input'));
    	$competitionName = "";
    	$toReturn[];
    	$sth = $this->dbh->prepare('');
    }

    public function deleteUserData($id)
    {        
        //$data = json_decode(file_get_contents('php://input'));
        $id = "";        
        $toReturn = [];
        $sth = $this->dbh->prepare('DELETE * FROM user 
            WHERE INSTR(id, :id) 
            ');
        $sth->bindParam(':id',$id, PDO::PARAM_STR);
        $sth->execute();        
    }

    public function deleteTeamData($id)
    {        
        //$data = json_decode(file_get_contents('php://input'));
        $id = "";        
        $toReturn = [];
        $sth = $this->dbh->prepare('DELETE * FROM teams 
            WHERE INSTR(id, :id) 
            ');
        $sth->bindParam(':id',$id, PDO::PARAM_STR);
        $sth->execute();        
    }

    public function updateUserData($username, $email, $password, $existinguser)
    {     	                           
            $sth = $this->dbh->prepare("UPDATE user
                SET
                username = :username,
                email = :email,
                password = :password
                WHERE username = :existinguser");
            $sth->bindParam(':username', $username);
            $sth->bindParam(':email', $email);
            $sth->bindParam(':password', $password);
            $sth->bindParam(':existinguser', $existinguser);

            try {            
            $sth->execute();   
            return true;
          	}                        
         catch (Exception $e)
         {
               echo "Error: " . $e->getMessage();      	
               return false;
         }   
    }
}
?>
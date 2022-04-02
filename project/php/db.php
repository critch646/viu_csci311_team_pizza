<?php
require_once("utilities.php");


/**
 * For reference:
 * 
 * IN DATABASE csci311a_project 
 * TABLE Users
 * +---------------+---------------------+------+-----+---------+----------------+
 * | Field         | Type                | Null | Key | Default | Extra          |
 * +---------------+---------------------+------+-----+---------+----------------+
 * | user_id       | bigint(20) unsigned | NO   | PRI | NULL    | auto_increment |
 * | username      | varchar(40)         | NO   |     | NULL    |                |
 * | user_password | varchar(64)         | NO   |     | NULL    |                |
 * | xp            | int(11)             | YES  |     | 0       |                |
 * | user_level    | int(11)             | YES  |     | 1       |                |
 * +---------------+---------------------+------+-----+---------+----------------+
 * 
 * 
 * 
 */
class db {

    private $dbh = null;
    private $sth = null;
    private $salt = '$1$teampizza';
    public $result;

    public function __construct($h, $dbname, $u, $p){
        try {
            $this->dbh = new PDO("mysql:host=$h;dbname=$dbname", $u, $p);
        } catch(PDOException $e) {
            debug_to_console("ERROR:" . $e->getMessage());
        }
    }


    public function __destruct(){
        $this->dbh = null;
    }

    /**
     * Returns true if connection is open; otherwise, returns false
     * 
     * @return bool
     */
    private function dbhOpen(){

        if ($this->dbh == null){
            return false;
        } else {
            return true;
        }
    }

    /**
     * Takes passed input and sanitizes it for SQL queries.
     */
    private function sanitize($input) : string {

        // Check if input string is empty
        if (empty($input)){
            return "";
        }

        // Sanitize the input
        $sani_input = filter_var($input, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW);
        $sani_input = filter_var($sani_input, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);

        return $sani_input;

    }

    /**
     * Hashes password using SHA512 with salt
     */
    private function hashPassword($p) : string {

        $hashedP = crypt($p, $this->salt);
        $hashedP = substr($hashedP, strlen($this->salt));

        return $hashedP;
    }

    /**
     * Checks in input destined for SQL query is safe to use. True if good; otherwise
     * returns false.
     */
    private function checkInput($input) : bool {

        $saniInput = $this->sanitize($input);

        if ($saniInput == $input){
            return true;
        }

        return false;
    }

    /**
     * Checks if pased user exists in database.
     */
    public function userExists($u) : bool {

        // Check if connection is not open
        if (!$this->dbhOpen()){
            debug_to_console("ERROR: dbh connection not open.");
            return false;
        }

        // Sanitize input
        $u = $this->sanitize($u);

        if ($u == ""){
            return false;
        }

        $this->sth = $this->dbh->query("SELECT username FROM Users WHERE username = '$u';");

        if ($this->sth == false){
            return false;
        }

        foreach($this->sth as $row){
            if ($row['username'] == $u){
                return true;
            }
        }
        return false;

    }

    /**
     * Creates a new user with the passed credentials.
     */
    public function createUser($u, $p){

        $passed = true;

        // Check if username is safe
        if (!$this->checkInput($u)){
             $passed = false;
             debug_to_console("createUser(): username invalid");
        }

        // Check if password is safe
        if (!$this->checkInput($p)){
            $passed = false;
            debug_to_console("createUser(): password invalid");
        }

        // If failed, gtfo
        if (!$passed){
            debug_to_console("createUser(): does not pass tests");
            return false;
        }

        // Check if user already exists
        if ($this->userExists($u)){
            debug_to_console("createUser(): user already exists");
            return false;
        }

        // Hash and salt password
        $hashedP = $this->hashPassword($p);

        // Check if connection is not open
        if (!$this->dbhOpen()){
            debug_to_console("ERROR: dbh connection not open.");
            return false;
        }

        // Insert new user into database table
        try {
            $sql = "INSERT INTO Users (username, user_password, xp, user_level) VALUES ('$u', '$hashedP', 0, 1);";
            $this->dbh->query($sql);
        } catch(PDOException $e) {
            debug_to_console("ERROR:" . $e->getMessage());
            return false;
        }

        return true;

    }


    /**
     * Method validates passed user credentials and returns true if valid
     */
    public function loginUser($u, $p){

        $passed = true;

        // Check if username is safe
        if (!$this->checkInput($u)){
             $passed = false;
             debug_to_console("createUser(): username invalid");
        }

        // Check if password is safe
        if (!$this->checkInput($p)){
            $passed = false;
            debug_to_console("createUser(): password invalid");
        }

        // If failed, gtfo
        if (!$passed){
            debug_to_console("createUser(): does not pass tests");
            return false;
        }

        // Hash and salt password
        $hashedP = $this->hashPassword($p);

        // Check if connection is not open
        if (!$this->dbhOpen()){
            debug_to_console("ERROR: dbh connection not open.");
            return false;
        }

        // Check for user in database
        try {
            $sql = "SELECT * FROM Users WHERE username = '$u';";
            $this->sth = $this->dbh->query($sql);
            foreach($this->sth as $row){
                if ($row['user_password'] == $hashedP){
                    return true;
                }
            }
 
        } catch(PDOException $e) {
            debug_to_console("ERROR:" . $e->getMessage());
            return false;
        }

        return false;

    }

    # grabs the user_level value from the database from the row the corresponds to the passed in username parameter
    public function getUserLevel($u){

        $passed = true;

        // Check if username is safe
        if (!$this->checkInput($u)){
             $passed = false;
        }

        // If failed, gtfo
        if (!$passed){

            return false;
        }

	    # if the username is applicable, then grab the user's level from database
	    if($this->userExists($u)){
	    	$this->sth = $this->dbh->query("SELECT user_level FROM Users WHERE username='$u';");	
	    	
		        foreach($this->sth as $row){
                        	if ($row['user_level']){
                        		return $row['user_level'];
                        	}
                    	}
	    }
    }

    # sets passed user's level to passed level value
    private function setUserLevel($u, $lvl){

        $passed = true;

        // Check if username is safe
        if (!$this->checkInput($u)){
             $passed = false;
        }

        // Check if xp is safe
        if (!$this->checkInput($lvl)){
            $passed = false;
        }

        // If failed, gtfo
        if (!$passed){

            return false;
        }

    }

    # grabs the xp value from the database from the row the corresponds to the passed in username parameter
    public function getUserXP($u){

        // $passed = true;

        // // Check if username is safe
        // if (!$this->checkInput($u)){
        //      $passed = false;
        // }

        // // If failed, gtfo
        // if (!$passed){

        //     return "";
        // }

	    # if the username if applicable, then grab the user's experience points from database
	    if ($this->userExists($u)){
		    $this->sth = $this->dbh->query("SELECT xp FROM Users WHERE username='$u';");

		    foreach($this->sth as $row){
            		if ($row['xp']){
                        $uXP = intval($row['xp']);
                	    return $uXP;
            		}
		    }
	    }
    }

    /**
     * Updates existing user's xp total in the database. Calculates if
     * a level up is awarded from xp gain.
     */
    public function updateUserXP($u, $xp){

        $passed = true;

        // Check if username is safe
        if (!$this->checkInput($u)){
             $passed = false;
        }

        // Check if xp is safe
        if (!$this->checkInput($xp)){
            $passed = false;
        }

        // If failed, gtfo
        if (!$passed){

            return false;
        }

        $currentXP = $this->getUserXP($u);
        $newXP = $currentXP + $xp;
        $newLvl = calc_level($newXP);

        $this->sth = $this->dbh->query("UPDATE Users SET xp = $newXP, user_level = $newLvl WHERE username='$u';");
        return true;


    }

    public function getUserRank($u){
	    include("dbinfo.inc");
	
   # Query the database, and grab all users, ordering all User's xp in Descending order
   # take the specified number of records, and build an HTML table using each record as an input
   try{

      $dbh = new PDO("mysql:host=$host;dbname=$database", $user, $password);
      $myQuery = "select username, xp from Users order by xp desc";
      $resultSet = $dbh->query($myQuery);
      $rank=0; # is the rank of the user...

      foreach($resultSet as $row){
	      $rank++;
	      if($row['username'] == $u){
	      	return $rank;
	      }
      }
   }catch(PDOException $e){
      echo "Connection failed: " . $e->getMessage();
   }

}

    # grabs user information from the database, and returns an array
    # 	Use:
    # 		$userInfo = getUserInfo($username); 	# function call, assigned to userInfo
    # 		$userInfo['username'][0]; 		# gives the username
    # 		$userInfo['userXP'][0];			# gives the user's XP
    # 		$userInfo['userLVL'][0];		# gives the user's LVL
    #
    #
    public function getUserInfo($u) {

	    if($this->userExists($u)){
	    	# grab all user information EXCEPT password
	    	$userXP = $this->getUserXP($u);
		$userLVL = $this->getUserLevel($u);

		return array($u, $userXP, $userLVL);
	    }
	    else {
		# By all accounts, shouldn't even get this!
	    	return array('username'=>"NULL", 'userXP'=>"-1",'userLVL'=>"-1");
	    }

	exit;	    
    }
}
?>

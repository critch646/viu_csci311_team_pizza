<?php


/**
 * @name: utilities.php
 * 
 * Contains various utility functions for the project.
 * 
 */


/**
 * Takes passed experience total and returns corresponding level.
 * 
 * @param total - int value representing current experience.
 * 
 * @return int - level corresponding to passed experience total.
 */
function calc_level($total){

    $total = intval($total);

    if (0 <= $total and $total < 300) {
        return 1;
    } elseif (300 <= $total and $total < 900) {
        return 2;
    } elseif (900 <= $total and $total < 2700) {
        return 3;
    } elseif (2700 <= $total and $total < 6500) {
        return 4;
    } elseif (6500 <= $total and $total < 14000) {
        return 5;
    } elseif (14000 <= $total and $total < 23000) {
        return 6;
    } elseif (23000 <= $total and $total < 34000) {
        return 7;
    } elseif (34000 <= $total and $total < 48000) {
        return 8;
    } elseif (48000 <= $total and $total < 64000) {
        return 9;
    } elseif (64000 <= $total and $total < 85000) {
        return 10;
    } elseif (85000 <= $total and $total < 100000) {
        return 11;
    } elseif (100000 <= $total and $total < 120000) {
        return 12;
    } elseif (120000 <= $total and $total < 140000) {
        return 13;
    } elseif (140000 <= $total and $total < 165000) {
        return 14;
    } elseif (165000 <= $total and $total < 195000) {
        return 15;
    } elseif (195000 <= $total and $total < 225000) {
        return 16;
    } elseif (225000 <= $total and $total < 265000) {
        return 17;
    } elseif (265000 <= $total and $total < 305000) {
        return 18;
    } elseif (305000 <= $total and $total < 355000) {
        return 19;
    } else {
        return 20;
    }
}


/**
 * Takes passed level and returns puzzle completion reward.
 * 
 * @param level - Difficulty level of puzzle win
 * 
 * @return int - The experience reward for the corresponding difficulty
 */
function calc_reward($level){

    $level = intval($level);

    switch ($level){
        case 2:
            return 75;
            break;
        case 3:
            return 225;
            break;
        case 4:
            return 675;
            break;
        case 5:
            return 1625;
            break;
        case 6:
            return 3500;
            break;
        case 7:
            return 5750;
            break;
        case 8:
            return 8500;
            break;
        case 9:
            return 12000;
            break;
        case 10:
            return 16000;
            break;
        default:
            return 0;
    }
}


/**
 * Takes passed object and outputs to browser console
 * 
 * @param data - object to print to console
 */
function debug_to_console($data) {
    $output = $data;
    if (is_array($output))
        $output = implode(',', $output);

    echo "<script>console.log('" . $output . "');</script>";
}

function fetch_leaderboard($number){
    require_once("php/dbinfo.inc");

   # Query the database, and grab all users, ordering all User's xp in Descending order
   # take the specified number of records, and build an HTML table using each record as an input
   try{
    
      $dbh = new PDO("mysql:host=$host;dbname=$database", $user, $password);
      $myQuery = "select username, xp, user_level from Users order by xp desc limit " .$number;
      $resultSet = $dbh->query($myQuery);
      $rank = 1;

      foreach($resultSet as $row){
         echo "<tr>";
         echo "<td>";
         echo $rank;
         echo "</td>";
         echo "<td>";
         echo $row['username'];
         echo "</td>";
         echo "<td>";
         echo $row['xp'];
         echo "</td>";
         echo "<td>";
         echo $row['user_level'];
         echo "</td>";
         echo "</tr>";
         $rank++;
      }
   }catch(PDOException $e){
      echo "Connection failed: " . $e->getMessage();
   }

}

?>

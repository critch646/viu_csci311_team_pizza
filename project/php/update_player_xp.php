<?php
    require_once("dbinfo.inc");
    include_once("db.php");
    include_once("utilities.php");

    $diffLevel = $_POST['diff_lvl'];
    $playerName = $_POST['playername'];

    $xpReward = calc_reward($diffLevel);

    $dB = new db($host, $database, $user, $password);

    $_ = $dB->updateUserXP($playerName, $xpReward);

?>
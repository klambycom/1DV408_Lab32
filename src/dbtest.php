<?php

require_once("common/model/UserDAL.php");
require_once("login/model/UserCredentials.php");
require_once("common/Filter.php");

//var_dump(PDO::getAvailableDrivers());

//phpinfo();

//\common\model\UserDAL::create(login\model\UserCredentials::create("Test", "Testigt"));

var_dump(\common\model\UserDAL::find(new login\model\UserName("Test")));

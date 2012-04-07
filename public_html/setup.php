<?php
require_once(realpath(dirname(__FILE__) . "/../resources/config.php"));

$m = new Otpw();
$m->setValue("otpw", "aas");
$m->setUsed();
echo ($m->persist() == false);
echo implode(" ",$m->getAttribute("used")->getErrors());
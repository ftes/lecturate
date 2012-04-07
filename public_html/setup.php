<?php
require_once(realpath(dirname(__FILE__) . "/../resources/config.php"));

$m = new Rating();
echo $m->getSql();
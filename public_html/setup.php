<?php
require_once(realpath(dirname(__FILE__) . "/../resources/config.php"));

$m = new DocentLecture();
echo $m->getSql();
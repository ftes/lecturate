<?php
require_once(realpath(dirname(__FILE__) . "/../resources/config.php"));

$m = new Classs();
echo $m->getSql();
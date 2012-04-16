<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN"
   "http://www.w3.org/TR/html4/strict.dtd">

<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>Lecturate</title>
	<link rel="stylesheet" href="css/main.css" type="text/css">
	<link rel="stylesheet" href="css/buttons.css" type="text/css">
</head>

<body>
<?php 
$flashText = "";
$flashClass = "";
if (isset($_SESSION["flash"])) {
	$flashText = $_SESSION["flash"][1];
	$flashClass = $_SESSION["flash"][0];
	unset($_SESSION["flash"]);
}?>

<div id="container">
	<?php require_once(TEMPLATES_PATH . "/header.php"); ?>
	<div id=main>
		<div id="flash" class="<?=$flashClass; ?>">
			<?=$flashText; ?>
		</div>
		<div id="content">
			<?php
			if (file_exists($contentFileFullPath)) {
				require_once($contentFileFullPath);
			} else {
				require_once(TEMPLATES_PATH . "/error.php");
			}
			?>
		</div>
		<div id="column_right">
			<?php
			if (file_exists($navFileFullPath)) {
				require_once($navFileFullPath);
			} else {
				require_once(TEMPLATES_PATH . "/error.php");
			}
			?>
		</div>
		<div id="spacer"></div>
	</div>
	<?php require_once(TEMPLATES_PATH . "/footer.php"); ?>
</div>
</body>
</html>
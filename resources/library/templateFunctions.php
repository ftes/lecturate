<?php  
require_once(realpath(dirname(__FILE__) . "/../config.php"));

abstract class TemplateConst {
	const SUBMIT = "submit";
	const QUIT = "quit";
}

function render($contentFile, $navFile, $variables = array()) {
	$contentFileFullPath = VIEWS_PATH . "/" . $contentFile;
	$navFullPath = VIEWS_PATH . "/" . $navFile;

	if (count($variables) > 0) {
		foreach ($variables as $key => $value) {
			if (strlen($key) > 0) {
				${$key} = $value;
			}}}
	?>
	<div id="container">
		<?php require_once(TEMPLATES_PATH . "/header.php");?>
		<div id=main>
			<div id="flash">
				<?php if (isset($flash)) echo $flash;?>
			</div>
			<div id="content">;
				<?php if (file_exists($contentFileFullPath)) {
						require_once($contentFileFullPath);
					} else {
						require_once(TEMPLATES_PATH . "/error.php");
					}?>
			</div>
			<div id="column_right">";
				<?php if (file_exists($navFileFullPath)) {
						require_once($navFileFullPath);
					} else {
						require_once(TEMPLATES_PATH . "/error.php");
					}?>
			</div>
			<div id="spacer"></div>
		</div>";
		<?php require_once(TEMPLATES_PATH . "/footer.php"); ?>
	</div>
	<?php
}
?>
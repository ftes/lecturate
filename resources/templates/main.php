<div id="container">
	<?php require_once(TEMPLATES_PATH . "/header.php"); ?>
	<div id=main>
		<div id="flash" class="<?= isset($flash) ? $flash[0] : ""; ?>">
			<?php if (isset($flash)) echo $flash[1]; ?>
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

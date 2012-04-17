<?php T::setEditable(true); 
$formId = T::uid(); ?>

<h1>Einmal-PW generieren</h1>

<div class="group">
	<h2>Auswahl</h2>
	<form method="POST" id="<?=$formId;?>">
		<table>
			<tr>
				<th>Kurs</th>
				<td><?=T::select($classs->getAttribute("id"), $classses, false, 
						"c_id", array("onchange",
								"getElementById('$formId').submit();")); ?>
				</td>
				<td><?=T::error(); ?></td>
			</tr>
			<tr>
				<th>Anzahl</th>
				<td><?=T::input($classs->getAttribute("size")); ?></td>
				<td><?=T::error(); ?></td>
			</tr>
			<tr>
				<th>Kurs hört gehaltene Vorlesung</th>
				<td><?=T::select($classsDocentLecture->getAttribute("id"), 
						$classsDocentLectures, false, "cdl_id"); ?>
				</td>
				<td><?=T::error(); ?></td>
			</tr>
		</table>
		<button class="button submit"
			onclick="getElementById('<?=$formId?>').submit();">Generieren</button>
	</form>
</div>

<?php
if (count($otpws)) {
	echo "<div class=\"group\">";
	foreach($otpws as $otpw) {
		echo $otpw->getValue("otpw")."<br>";
	}
	echo "</div>";
}
?>
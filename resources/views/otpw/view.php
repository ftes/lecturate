<?php T::setEditable(false); ?>

<h1>Einmal-PW anzeigen</h1>

<form method="POST">
	<table>
		<tr>
			<th>ID</th>
			<td><?=T::input($model->getAttribute("id")); ?>
			</td>
		</tr>
		<tr>
			<th>Einmal-PW</th>
			<td><?=T::input($model->getAttribute("otpw")); ?></td>
		</tr>
		<tr>
			<th>Dozent hält Vorlesung</th>
			<td><?=T::select($model->getAttribute("dl_id"), array($docentLecture)); ?>
			</td>
		</tr>
		<tr>
			<th>Verwendet</th>
			<td><?=T::select($model->getAttribute("used"), $usedOptions, true); ?>
			</td>
		</tr>
		<tr>
			<th>Erzeugt (wann)</th>
			<td><?=$model->getAttribute("created")->getValue(); ?></td>
		</tr>
		<tr>
			<th>Verwendet (wann)</th>
			<td><?=$model->getAttribute("used_ts")->getValue(); ?></td>
		</tr>
	</table>
	<?=T::iconButton(T::DELETE, "Löschen", "otpw", "delete", array("id"=>$model->getValue("id"))); ?>
</form>

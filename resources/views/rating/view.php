<?php T::setEditable(false); ?>

<h1>Bewertung anzeigen</h1>

<form method="POST">
	<table>
		<tr>
			<th>ID</th>
			<td><?=T::input($model->getAttribute("id")); ?>
			</td>
		</tr>
		<tr>
			<th>Bewertung</th>
			<td><?=T::input($model->getAttribute("mark")); ?>
			</td>
		</tr>
		<tr>
			<th>Erzeugt (wann)</th>
			<td><?=$model->getAttribute("created")->getValue(); ?></td>
		</tr>
		<tr>
			<th>Einmal-PW</th>
			<td><?=T::select($model->getAttribute("o_id"), array($otpw)); ?></td>
		</tr>
		<tr>
			<th>Dozent hält Vorlesung</th>
			<td><?=T::select($model->getAttribute("dl_id"), array($docentLecture)); ?>
			</td>
		</tr>
		<tr>
			<th>Kommentar</th>
			<td><?=T::input($model->getAttribute("comment")); ?>
			</td>
		</tr>
	</table>
	<?=T::iconButton(T::DELETE, "Löschen", "otpw", "delete", array("id"=>$model->getValue("id"))); ?>
</form>

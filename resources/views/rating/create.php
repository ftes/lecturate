<?php T::setEditable(true); ?>

<h1>Bewertung hinzufügen</h1>

<form method="POST">
	<table>
		<tr>
			<th>Bewertung</th>
			<td><?=T::input($model->getAttribute("mark")); ?>
			</td>
			<td><?=T::error(); ?>
			</td>
		</tr>
		<tr>
			<th>Einmal-PW</th>
			<td><input type="text" name="model[otpw]" <?="value=\"$otpw\""; ?>"></td>
			<td></td>
		</tr>
		<tr>
			<th>Dozent hält Vorlesung</th>
			<td><?=T::select($model->getAttribute("dl_id"), $docentLectures); ?>
			</td>
			<td></td>
		</tr>
		<tr>
			<th>Kommentar</th>
			<td><?=T::input($model->getAttribute("comment")); ?></td>
			<td></td>
		</tr>
	</table>
	<?=T::button(T::CANCEL, "Abbrechen"); ?>
	<?=T::button(T::SUBMIT, "Speichern"); ?>
</form>

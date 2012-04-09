<?php T::setEditable(true); ?>

<h1>Einmal-PW hinzufügen</h1>

<form method="POST">
	<table>
		<tr>
			<th>Einmal-PW</th>
			<td><?=T::input($model->getAttribute("otpw")); ?></td>
			<td><?=T::error(); ?></td>
		</tr>
		<tr>
			<th>Dozent hält Vorlesung</th>
			<td><?=T::select($model->getAttribute("dl_id"), $docentLectures); ?>
			</td>
			<td><?=T::error(); ?></td>
		</tr>
	</table>
	<?=T::button(T::CANCEL, "Abbrechen"); ?>
	<?=T::button(T::SUBMIT, "Speichern"); ?>
</form>

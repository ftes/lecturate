<?php T::setEditable(true); ?>

<h1>Kurs hinzufügen</h1>

<form method="POST">
	<table>
		<tr>
			<th>Kürzel</th>
			<td><?=T::input($model->getAttribute("token")); ?>
			</td>
			<td><?=T::error(); ?>
			</td>
		</tr>
		<tr>
			<th>Größe</th>
			<td><?=T::input($model->getAttribute("size")); ?>
			</td>
			<td><?=T::error(); ?>
			</td>
		</tr>
		<tr>
			<th>Studiengangsleiter</th>
			<td><?=T::select($model->getAttribute("a_id"), $advisors); ?>
			</td>
			<td><?=T::error(); ?>
			</td>
		</tr>
	</table>
	<?=T::button(T::CANCEL, "Abbrechen"); ?>
	<?=T::button(T::SUBMIT, "Speichern"); ?>
</form>

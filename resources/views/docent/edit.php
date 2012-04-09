<?php T::setEditable(true); ?>

<h1>Dozent bearbeiten</h1>
	
<form method="POST">
<table>
		<tr>
			<th>ID</th>
			<td><?=T::input($model->getAttribute("id")); ?>
			</td>
			<td><?=T::error(); ?>
			</td>
		</tr>
		<tr>
			<th>Vorname</th>
			<td><?=T::input($model->getAttribute("firstname")); ?>
			</td>
			<td><?=T::error(); ?>
			</td>
		</tr>
		<tr>
			<th>Nachname</th>
			<td><?=T::input($model->getAttribute("lastname")); ?>
			</td>
			<td><?=T::error(); ?>
			</td>
		</tr>
</table>
	<?=T::button(T::CANCEL, "Abbrechen"); ?>
	<?=T::button(T::SUBMIT, "Speichern"); ?>
</form>
<?php T::setEditable(true); ?>

<h1>Vorlesung hinzufügen</h1>

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
			<th>Name</th>
			<td><?=T::input($model->getAttribute("name")); ?>
			</td>
			<td><?=T::error(); ?>
			</td>
		</tr>
	</table>
	<?=T::button(T::CANCEL, "Abbrechen"); ?>
	<?=T::button(T::SUBMIT, "Speichern"); ?>
</form>

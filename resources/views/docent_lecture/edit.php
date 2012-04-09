<?php T::setEditable(true); ?>

<h1>Dozent hält Vorlesung bearbeiten</h1>

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
			<th>Dozent</th>
			<td><?=T::select($model->getAttribute("d_id"), $docents); ?></td>
			<td></td>
		</tr>
		<tr>
			<th>Vorlesung</th>
			<td><?=T::select($model->getAttribute("l_id"), $lectures); ?></td>
			<td></td>
		</tr>
	</table>
	<?=T::button(T::CANCEL, "Abbrechen"); ?>
	<?=T::button(T::SUBMIT, "Speichern"); ?>
</form>

<?php T::setEditable(true); ?>

<h1>Kurs hört gehaltene Vorlesung bearbeiten</h1>

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
			<th>Kurs</th>
			<td><?=T::select($model->getAttribute("c_id"), $classses); ?></td>
			<td></td>
		</tr>
		<tr>
			<th>Dozent hält Vorlesung</th>
			<td><?=T::select($model->getAttribute("dl_id"), $docentLectures); ?>
			</td>
			<td></td>
		</tr>
	</table>
	<?=T::button(T::CANCEL, "Abbrechen"); ?>
	<?=T::button(T::SUBMIT, "Speichern"); ?>
</form>

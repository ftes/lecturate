<?php T::setEditable(true); ?>

<h1>Kurs hört gehaltene Vorlesung hinzufügen</h1>

<form method="POST">
	<table>
		<tr>
			<th>Kurs</th>
			<td><?=T::select($model->getAttribute("c_id"), $classses); ?></td>
		</tr>
		<tr>
			<th>Dozent hält Vorlesung</th>
			<td><?=T::select($model->getAttribute("dl_id"), $docentLectures); ?>
			</td>
		</tr>
	</table>
	<?=T::button(T::CANCEL, "Abbrechen"); ?>
	<?=T::button(T::SUBMIT, "Speichern"); ?>
</form>

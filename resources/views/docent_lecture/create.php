<?php T::setEditable(true); ?>

<h1>Dozent hält Vorlesung anlegen</h1>

<form method="POST">
<table>
		<tr>
			<th>Dozent</th>
			<td><?=T::select($model->getAttribute("d_id"), $docents); ?></td>
		</tr>		
		<tr>
			<th>Vorlesung</th>
			<td><?=T::select($model->getAttribute("l_id"), $lectures); ?></td>
		</tr>
</table>
	<?=T::button(T::CANCEL, "Abbrechen"); ?>
	<?=T::button(T::SUBMIT, "Speichern"); ?>
</form>
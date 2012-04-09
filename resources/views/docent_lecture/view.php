<?php T::setEditable(false); ?>

<h1>Dozent hält Vorlesung anzeigen</h1>

<form method="POST">
<table>
		<tr>
			<th>ID</th>
			<td><?=T::input($model->getAttribute("id")); ?>
			</td>
		</tr>
		<tr>
			<th>Dozent</th>
			<td><?=T::select($model->getAttribute("d_id"), array($docent)); ?></td>
		</tr>		
		<tr>
			<th>Vorlesung</th>
			<td><?=T::select($model->getAttribute("l_id"), array($lecture)); ?></td>
		</tr>
</table>
<?=T::iconButton(T::EDIT, "Bearbeiten", "docent_lecture", "edit", array("id"=>$model->getValue("id"))); ?>
<?=T::iconButton(T::DELETE, "Löschen", "docent_lecture", "delete", array("id"=>$model->getValue("id"))); ?>
</form>
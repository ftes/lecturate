<?php T::setEditable(false); ?>

<h1>Dozent anzeigen</h1>

<form method="POST">
<table>
		<tr>
			<th>ID</th>
			<td><?=T::input($model->getAttribute("id")); ?>
			</td>
		</tr>
		<tr>
			<th>Vorname</th>
			<td><?=T::input($model->getAttribute("firstname")); ?>
			</td>
		</tr>		
		<tr>
			<th>Nachname</th>
			<td><?=T::input($model->getAttribute("lastname")); ?>
			</td>
		</tr>
</table>
<?=T::iconButton(T::EDIT, "Bearbeiten", "docent", "edit", array("id"=>$model->getValue("id"))); ?>
<?=T::iconButton(T::DELETE, "Löschen", "docent", "delete", array("id"=>$model->getValue("id"))); ?>
</form>
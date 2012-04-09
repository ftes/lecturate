<?php T::setEditable(false); ?>

<h1>Studiengangsleiter anzeigen</h1>

<form method="POST">
<table>
		<tr>
			<th>ID</th>
			<td><?=T::input($model->getAttribute("id")); ?>
			</td>
		</tr>
		<tr>
			<th>Benutzername</th>
			<td><?=T::input($model->getAttribute("username")); ?>
			</td>
		</tr>
		<tr>
			<th>Passwort</th>
			<td><?=T::input($model->getAttribute("password")); ?>
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
<?=T::iconButton(T::EDIT, "Bearbeiten", "advisor", "edit", array("id"=>$model->getValue("id"))); ?>
<?=T::iconButton(T::DELETE, "Löschen", "advisor", "delete", array("id"=>$model->getValue("id"))); ?>
</form>

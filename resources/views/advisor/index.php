<h1>Studiengangsleiter</h1>

<table>
	<tr>
		<th>ID</th>
		<th>Benutzername</th>
		<th>Passwort</th>
		<th>Vorname</th>
		<th>Nachname</th>
		<th></th>
		<th></th>
		<th></th>
	</tr>
	<?php foreach($models as $model): ?>
	<tr>
		<td><?=$model->getValue("id"); ?></td>
		<td><?=$model->getValue("username"); ?></td>
		<td><?=$model->getValue("password"); ?></td>
		<td><?=$model->getValue("firstname"); ?></td>
		<td><?=$model->getValue("lastname"); ?></td>
		<td><?=T::iconButton(T::VIEW, false, "advisor", "view", array("id"=>$model->getValue("id")))?></td>
		<td><?=T::iconButton(T::EDIT, false, "advisor", "edit", array("id"=>$model->getValue("id")))?></td>
		<td><?=T::iconButton(T::DELETE, false, "advisor", "delete", array("id"=>$model->getValue("id")))?></td>
	</tr>
	<?php endforeach; ?>
</table>
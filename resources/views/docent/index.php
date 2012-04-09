<h1>Dozenten</h1>

<table>
	<tr>
		<th>ID</th>
		<th>Vorname</th>
		<th>Nachname</th>
		<th></th>
		<th></th>
		<th></th>
	</tr>
	<?php foreach($models as $model): ?>
	<tr>
		<td><?=$model->getValue("id"); ?></td>
		<td><?=$model->getValue("firstname"); ?></td>
		<td><?=$model->getValue("lastname"); ?></td>
		<td><?=T::iconButton(T::VIEW, false, "docent", "view", array("id"=>$model->getValue("id")))?></td>
		<td><?=T::iconButton(T::EDIT, false, "docent", "edit", array("id"=>$model->getValue("id")))?></td>
		<td><?=T::iconButton(T::DELETE, false, "docent", "delete", array("id"=>$model->getValue("id")))?></td>
	</tr>
	<?php endforeach; ?>
</table>
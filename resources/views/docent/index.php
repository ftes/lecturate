<h1>Docents</h2>

<table>
	<tr>
		<th>ID</th>
		<th>First name</th>
		<th>Last name</th>
		<th></th>
		<th></th>
		<th></th>
	</tr>
	<?php foreach($models as $model): ?>
	<tr>
		<td><?=$model->getValue("id"); ?></td>
		<td><?=$model->getValue("firstname"); ?></td>
		<td><?=$model->getValue("lastname"); ?></td>
		<td><a href="<?=T::href("docent", "view", array("id"=>$model->getValue("id"))); ?>">View</a></td>
		<td><a href="<?=T::href("docent", "edit", array("id"=>$model->getValue("id"))); ?>">Edit</a></td>
		<td><a href="<?=T::href("docent", "delete", array("id"=>$model->getValue("id"))); ?>">X</a></td>
	</tr>
	<?php endforeach; ?>
</table>
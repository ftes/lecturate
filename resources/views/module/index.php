<h1>Module List</h2>

<table border="0">
	<tr>
		<th>ID</th>
		<th>Token</th>
	</tr>
	<?php foreach($models as $key => $model): ?>
	<tr>
		<td><?=$model['id']; ?></td>
		<td><?=$model['token']; ?></td>
		<td><a href="<?=T::href("module", "view", array("id"=>$model['id'])); ?>">View</a></td>
		<td><a href="<?=T::href("module", "edit", array("id"=>$model['id'])); ?>">Edit</a></td>
		<td><a href="<?=T::href("module", "delete", array("id"=>$model['id'])); ?>">X</a></td>
	</tr>
	<?php endforeach; ?>
</table>
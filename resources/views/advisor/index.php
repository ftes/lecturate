<h1>Advisors</h1>

<table>
	<tr>
		<th>ID</th>
		<th>User name</th>
		<th>Password</th>
		<th>First name</th>
		<th>Last name</th>
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
		<td><a href="<?=T::href("advisor", "view", array("id"=>$model->getValue("id"))); ?>">View</a></td>
		<td><a href="<?=T::href("advisor", "edit", array("id"=>$model->getValue("id"))); ?>">Edit</a></td>
		<td><a href="<?=T::href("advisor", "delete", array("id"=>$model->getValue("id"))); ?>">X</a></td>
	</tr>
	<?php endforeach; ?>
</table>
<?php T::setEditable(false); ?>

<h1>View Module</h2>

<form method="POST">
<table>
		<tr>
			<th>ID</th>
			<td><?=T::input($model->getAttribute("id")); ?>
			</td>
		</tr>
		<tr>
			<th>Token</th>
			<td><?=T::input($model->getAttribute("token")); ?>
			</td>
		</tr>
		<tr>
			<th>Int</th>
			<td><?=T::input($model->getAttribute("inti")); ?>
			</td>
		</tr>
</table>
</form>

<a href="<?=T::href("module", "edit", array("id" => $model->getValue("id"))); ?>">Edit</a>
<a href="<?=T::href("module", "delete", array("id" => $model->getValue("id"))); ?>">Delete</a>
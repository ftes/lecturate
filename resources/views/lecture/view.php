<?php T::setEditable(false); ?>

<h1>View Lecture</h2>

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
			<th>Name</th>
			<td><?=T::input($model->getAttribute("name")); ?>
			</td>
		</tr>
</table>
</form>

<a href="<?=T::href("lecture", "edit", array("id" => $model->getValue("id"))); ?>">Edit</a>
<a href="<?=T::href("lecture", "delete", array("id" => $model->getValue("id"))); ?>">Delete</a>
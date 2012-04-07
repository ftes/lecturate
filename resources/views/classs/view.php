<?php T::setEditable(false); ?>

<h1>View Class</h1>

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
			<th>Advisor</th>
			<td><?=T::select($model->getAttribute("a_id"), array($advisor)); ?>
			</td>
		</tr>
</table>
</form>

<a href="<?=T::href("classs", "edit", array("id" => $model->getValue("id"))); ?>">Edit</a>
<a href="<?=T::href("classs", "delete", array("id" => $model->getValue("id"))); ?>">Delete</a>
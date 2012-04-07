<?php T::setEditable(false); ?>

<h1>View Docent</h2>

<form method="POST">
<table>
		<tr>
			<th>ID</th>
			<td><?=T::input($model->getAttribute("id")); ?>
			</td>
		</tr>
		<tr>
			<th>First name</th>
			<td><?=T::input($model->getAttribute("firstname")); ?>
			</td>
		</tr>		
		<tr>
			<th>Last name</th>
			<td><?=T::input($model->getAttribute("lastname")); ?>
			</td>
		</tr>
</table>
</form>

<a href="<?=T::href("docent", "edit", array("id" => $model->getValue("id"))); ?>">Edit</a>
<a href="<?=T::href("docent", "delete", array("id" => $model->getValue("id"))); ?>">Delete</a>
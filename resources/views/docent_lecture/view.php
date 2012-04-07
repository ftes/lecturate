<?php T::setEditable(false); ?>

<h1>View DocentLecture</h1>

<form method="POST">
<table>
		<tr>
			<th>ID</th>
			<td><?=T::input($model->getAttribute("id")); ?>
			</td>
		</tr>
		<tr>
			<th>Docent</th>
			<td><?=T::select($model->getAttribute("d_id"), array($docent)); ?></td>
		</tr>		
		<tr>
			<th>Lecture</th>
			<td><?=T::select($model->getAttribute("l_id"), array($lecture)); ?></td>
		</tr>
</table>
</form>

<a href="<?=T::href("docent_lecture", "edit", array("id" => $model->getValue("id"))); ?>">Edit</a>
<a href="<?=T::href("docent_lecture", "delete", array("id" => $model->getValue("id"))); ?>">Delete</a>
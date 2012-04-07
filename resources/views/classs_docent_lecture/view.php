<?php T::setEditable(false); ?>

<h1>View ClassDocentLecture</h1>

<form method="POST">
<table>
		<tr>
			<th>ID</th>
			<td><?=T::input($model->getAttribute("id")); ?>
			</td>
		</tr>
		<tr>
			<th>Class</th>
			<td><?=T::select($model->getAttribute("d_id"), array($class)); ?></td>
		</tr>		
		<tr>
			<th>DocentLecture</th>
			<td><?=T::select($model->getAttribute("l_id"), array($docentLecture)); ?></td>
		</tr>
</table>
</form>

<a href="<?=T::href("classs_docent_lecture", "edit", array("id" => $model->getValue("id"))); ?>">Edit</a>
<a href="<?=T::href("classs_docent_lecture", "delete", array("id" => $model->getValue("id"))); ?>">Delete</a>
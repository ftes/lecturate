<?php T::setEditable(true); ?>

<h1>Edit ClassDocentLecture</h1>
	
<form method="POST">
<table>
		<tr>
			<th>ID</th>
			<td><?=T::input($model->getAttribute("id")); ?>
			</td>
			<td><?=T::error(); ?>
			</td>
		</tr>
		<tr>
			<th>Class</th>
			<td><?=T::select($model->getAttribute("c_id"), $classses); ?></td>
			<td></td>
		</tr>		
		<tr>
			<th>DocentLecture</th>
			<td><?=T::select($model->getAttribute("dl_id"), $docentLectures); ?></td>
			<td></td>
		</tr>
		<tr>
			<th></th>
			<td><?=T::button(T::CANCEL) ?>
				<?=T::button(T::SAVE) ?>
			</td>
			<td></td>
		</tr>
</table>
</form>
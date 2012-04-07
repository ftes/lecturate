<?php T::setEditable(true); ?>

<h1>Edit DocentLecture</h1>
	
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
			<th>Docent</th>
			<td><?=T::select($model->getAttribute("d_id"), $docents); ?></td>
			<td></td>
		</tr>		
		<tr>
			<th>Lecture</th>
			<td><?=T::select($model->getAttribute("l_id"), $lectures); ?></td>
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
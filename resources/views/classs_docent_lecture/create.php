<?php T::setEditable(true); ?>

<h1>Create ClassDocentLecture</h1>

<form method="POST">
<table>
		<tr>
			<th>Class</th>
			<td><?=T::select($model->getAttribute("c_id"), $classses); ?></td>
		</tr>		
		<tr>
			<th>DocentLecture</th>
			<td><?=T::select($model->getAttribute("dl_id"), $docentLectures); ?></td>
		</tr>
		<tr>
			<th></th>
			<td><?=T::button(T::CANCEL) ?>
				<?=T::button(T::SAVE) ?>
			</td>
		</tr>
</table>
</form>
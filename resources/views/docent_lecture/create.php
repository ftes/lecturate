<?php T::setEditable(true); ?>

<h1>Create DocentLecture</h1>

<form method="POST">
<table>
		<tr>
			<th>Docent</th>
			<td><?=T::select($model->getAttribute("d_id"), $docents); ?></td>
		</tr>		
		<tr>
			<th>Lecture</th>
			<td><?=T::select($model->getAttribute("l_id"), $lectures); ?></td>
		</tr>
		<tr>
			<th></th>
			<td><?=T::button(T::CANCEL) ?>
				<?=T::button(T::SAVE) ?>
			</td>
		</tr>
</table>
</form>
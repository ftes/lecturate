<h1>Dozenten halten Vorlesungen</h1>

<table>
	<tr>
		<th>ID</th>
		<th>Dozent</th>
		<th>Vorlesung</th>
		<th></th>
		<th></th>
		<th></th>
		<th></th>
	</tr>
	<?php foreach($models as $model): ?>
	<tr>
		<td><?=$model->getValue("id"); ?></td>
		<td><?=$docents[$model->getValue("id")]; ?></td>
		<td><?=$lectures[$model->getValue("id")]; ?></td>
		<td><?=T::iconButton(T::VIEW, false, "docent_lecture", "view", array("id"=>$model->getValue("id")))?></td>
		<td><?=T::iconButton(T::EDIT, false, "docent_lecture", "edit", array("id"=>$model->getValue("id")))?></td>
		<td><?=T::iconButton(T::DELETE, false, "docent_lecture", "delete", array("id"=>$model->getValue("id")))?></td>
		<td><?=T::iconButton(T::RATE, false, "evaluation", "evaluateDocentLecture", array("id"=>$model->getValue("id")))?></td>
	</tr>
	<?php endforeach; ?>
</table>
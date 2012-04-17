<h1>Kurse hören gehaltene Vorlesungen</h1>

<table>
	<tr>
		<th>ID</th>
		<th>Kurs</th>
		<th>Dozent hält Vorlesung</th>
		<th></th>
		<th></th>
		<th></th>
	</tr>
	<?php foreach($models as $model): ?>
	<tr>
		<td><?=$model->getValue("id"); ?></td>
		<td><?=$classses[$model->getValue("id")]; ?></td>
		<td><?=$docentLectures[$model->getValue("id")]; ?></td>
		<td><?=T::iconButton(T::VIEW, false, "classs_docent_lecture", "view", 
				array("id"=>$model->getValue("id")))?>
		</td>
		<td><?=T::iconButton(T::EDIT, false, "classs_docent_lecture", "edit", 
				array("id"=>$model->getValue("id")))?>
		</td>
		<td><?=T::iconButton(T::DELETE, false, "classs_docent_lecture", "delete", 
				array("id"=>$model->getValue("id")))?>
		</td>
	</tr>
	<?php endforeach; ?>
</table>

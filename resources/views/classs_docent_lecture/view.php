<?php T::setEditable(false); ?>

<h1>Kurs hört gehaltene Vorlesung anzeigen</h1>

<form method="POST">
<table>
		<tr>
			<th>ID</th>
			<td><?=T::input($model->getAttribute("id")); ?>
			</td>
		</tr>
		<tr>
			<th>Kurs</th>
			<td><?=T::select($model->getAttribute("d_id"), array($class)); ?></td>
		</tr>		
		<tr>
			<th>Dozent hört Vorlesung</th>
			<td><?=T::select($model->getAttribute("l_id"), array($docentLecture)); ?></td>
		</tr>
</table>
<?=T::iconButton(T::EDIT, "Bearbeiten", "classs_docent_lecture", "edit", array("id"=>$model->getValue("id"))); ?>
<?=T::iconButton(T::DELETE, "Löschen", "classs_docent_lecture", "delete", array("id"=>$model->getValue("id"))); ?>
</form>
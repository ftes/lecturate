<?php T::setEditable(false); ?>

<h1>Kurs anzeigen</h1>

<form method="POST">
	<table>
		<tr>
			<th>ID</th>
			<td><?=T::input($model->getAttribute("id")); ?>
			</td>
		</tr>
		<tr>
			<th>Kürzel</th>
			<td><?=T::input($model->getAttribute("token")); ?>
			</td>
		</tr>
		<tr>
			<th>Größe</th>
			<td><?=T::input($model->getAttribute("size")); ?>
			</td>
		</tr>
		<tr>
			<th>Studiengangsleiter</th>
			<td><?=T::select($model->getAttribute("a_id"), array($advisor)); ?>
			</td>
		</tr>
	</table>
	<?=T::iconButton(T::EDIT, "Bearbeiten", "classs", "edit", 
			array("id"=>$model->getValue("id"))); ?>
	<?=T::iconButton(T::DELETE, "Löschen", "classs", "delete", 
			array("id"=>$model->getValue("id"))); ?>
</form>

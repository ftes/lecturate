<?php T::setEditable(true); 
$formId = T::uid(); ?>

<h1>Vorlesung bewerten</h1>

<form method="POST" id="<?=$formId; ?>">
<table>
		<tr>
			<th>Kurs</th>
			<td><?=T::select($classs->getAttribute("id"), $classses, false, "c_id", array("onchange", "getElementById('$formId').submit();")); ?></td>
		</tr>	
		<tr>
			<th>Kurs hört Gehaltene Vorlesung</th>
			<td><?=T::select($classsDocentLecture->getAttribute("id"), $classsDocentLectures, false, "cdl_id", array("onchange", "getElementById('$formId').submit();")); ?></td>
		</tr>
</table>
</form>
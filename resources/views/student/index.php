<?php T::setEditable(true); 
$formId = T::uid(); ?>

<h1>Vorlesung bewerten</h1>

<div class="group">
<h2>Vorlesungen nach Kurs</h2>
<form method="POST" id="<?=$formId; ?>">
<table>
		<tr>
			<th>Kurs</th>
			<td><?=T::select($classs->getAttribute("id"), $classses, false, "c_id", array("onchange", "getElementById('$formId').submit();")); ?></td>
		</tr>	
		<tr>
			<th>Vorlesung</th>
			<td><?=T::select($classsDocentLecture->getAttribute("id"), $classsDocentLectures, false, "cdl_id", array("onchange", "getElementById('$formId').submit();")); ?></td>
		</tr>
</table>
</form>
</div>
<?php
if(is_array($data)){$object = ArrayX::toObj($data);}

foreach($object as $index => $row){
	echo '<p>'.$row->Name.'</p>';
}

echo $spet->output('{SLICE}');

// oTraceX($spet);
?>
<?php
		function h_debug_array($pString,$array) {
			
				print_r($pString);
			
				//echo "DEBUG ". get_class($this) ." (" . $this->debugCount . ") : <b>" . $pString . "</b><br>";
				echo "<font color=red>";
				//print_r mit true leitet die Ausgabe in einen String um!
				echo nl2br(print_r($array,true));
				echo "</font><br>";
				//$this->debugCount++;
		}
?>

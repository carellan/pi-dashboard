<?php

if ($_GET['status'] != 0) {
	on_tor();
} 
else if($_GET['status'] == 0) {
	off_tor();
} else {
	header('Location: ../index.php');
}

function on_tor()
{
?>
<?php
	system('sudo /root/tor_leds_button/turn-on-tor.sh');
	sleep(3);
	header("Refresh:0, url=../index.php");
}

function off_tor()
{

?>
<?php

	system('sudo /root/tor_leds_button/turn-off-tor.sh');
	sleep(3);
	header("Refresh:0, url=../index.php");
}
?>

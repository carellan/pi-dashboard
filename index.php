<?php 
$password = "torpi2020";
if ($_POST['password'] != $password) { 
?>
<html>
<head>
	<meta charset="utf-8">
	<link rel="stylesheet" href="stylesheets/style.css">
</head>

<body>
	<div class="img"><img src="images/torpi-logo.png" width="200" height="200" alt=""/></div>
	<form name="form" method="post" action="">
  	<input type="password" name="password"><br>
	<input type="submit" value="Login"></form>
</body>
</html>

<?php 
}else{
?>
<?php
ob_start();

define(LANGUAGE, "spanish");


$temp = shell_exec('cat /sys/class/thermal/thermal_zone*/temp');
$temp = round($temp / 1000, 1);

$clock = shell_exec('cat /sys/devices/system/cpu/cpu0/cpufreq/scaling_cur_freq');
$clock = round($clock / 1000);

$voltage = shell_exec('/opt/vc/bin/vcgencmd measure_volts');
$voltage = explode("=", $voltage);
$voltage = $voltage[1];
$voltage = substr($voltage, 0, -2);

$cpuusage = 100 - shell_exec("vmstat | tail -1 | awk '{print $15}'");

$uptimedata = shell_exec('uptime');
$uptime = explode(' up ', $uptimedata);
$uptime = explode(',', $uptime[1]);
$uptime = $uptime[0] . ', ' . $uptime[1];

exec('pgrep tor', $output_tor, $return_tor);

include 'localization/' . LANGUAGE . '.lang.php';

?>

<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>TorPi - Panel de Control</title>
	<link rel="stylesheet" href="stylesheets/main.css">
	<link rel="stylesheet" href="stylesheets/button.css">
	<link rel="stylesheet" href="stylesheets/switch.css">
	<script src="javascript/raphael.2.1.0.min.js"></script>
	<script src="javascript/justgage.1.0.1.min.js"></script>

	<script>
		function checkAction(action) {
			if (confirm('<?php echo TXT_CONFIRM; ?> ' + action + '?')) {
				return true;
			} else {
				return false;
			}
		}

		window.onload = doLoad;

		function doLoad() {
			setTimeout("refresh()", 30 * 1000);
		}

		function refresh() {
			window.location.reload(false);
		}
	</script>
</head>

<body>
	<div id="container">
		<img id="logo" src="images/raspberry.png">
		<div id="title">Panel de Control</div>
		<?php if (isset($uptime)) { ?>
			<div id="uptime"><b><?php echo TXT_RUNTIME; ?></b>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $uptime; ?> <span STYLE="font-size: 8px;">(hh:mm)</span></div>
		<?php } ?>

		<?php if (isset($temp) && is_numeric($temp)) { ?>
			<div id="tempgauge"></div>
			<script>
				var t = new JustGage({
					id: "tempgauge",
					value: <?php echo $temp; ?>,
					min: 0,
					max: 100,
					title: "<?php echo TXT_TEMPERATURE; ?>",
					label: "°C"
				});
			</script>
		<?php } ?>

		<?php if (isset($cpuusage) && is_numeric($cpuusage)) { ?>
			<div id="cpugauge"></div>
			<script>
				var u = new JustGage({
					id: "cpugauge",
					value: <?php echo $cpuusage; ?>,
					min: 0,
					max: 100,
					title: "<?php echo TXT_USAGE; ?>",
					label: "%"
				});
			</script>
		<?php } ?>

                <?php if (isset($clock) && is_numeric($clock)) { ?>
                        <div id="clockgauge"></div>
                        <script>
                                var c = new JustGage({
                                        id: "clockgauge",
                                        value: <?php echo $clock; ?>,
                                        min: 0,
                                        max: 1000,
                                        title: "<?php echo TXT_CLOCK; ?>",
                                        label: "MHz"
                                });
                        </script>
                <?php } ?>


		<div id="controls">
			<br />
			<a class="button_orange" href="modules/shutdown.php?action=0" onclick="return checkAction('<?php echo TXT_RESTART_1; ?>');"><?php echo TXT_RESTART_2; ?></a><br />
			<a class="button_red" href="modules/shutdown.php?action=1" onclick="return checkAction('<?php echo TXT_SHUTDOWN_1; ?>');"><?php echo TXT_SHUTDOWN_2; ?></a>
			
		</div>


		<div id="controls">
			<h5 align="center">Estado de TOR</h5>	
			<div class="onoffswitch">
				<input type="checkbox" name="onoffswitch" class="onoffswitch-checkbox" id="myonoffswitch" onClick="location.href='modules/switch-tor.php?status=<?php echo $return_tor ?>'" value=True <?php echo ($return_tor==0 ? 'checked' : '');?>>
					<label class="onoffswitch-label" for="myonoffswitch">
						<span class="onoffswitch-inner"></span>
						<span class="onoffswitch-switch"></span>
					</label>
				</div>
			</div>
		</div>
	</div>
</body>

</html>
<?php 
} 
?>

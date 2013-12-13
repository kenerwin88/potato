<?php include 'header.php'; ?>


<form method="post">
	<input type="hidden" name="page" value="create" />
	<div id="pass" style="text-align:center">
		<h2>Create Release <img src="images/potato.png" alt="potato" /></h2>

		Release Name: <input type="text" name="name"><br/>
		Goal Launch Date: 

		<?php
		$lowestYear = 2013;
		$highestYear = 2020;
		?>

		<select name="month">
		<?php foreach(range(1,12) as $month): ?> 
		<option value="<?php echo $month;?>"><?php echo  date("F", mktime(0, 0, 0, $month, 10));?></option>
		<?php endforeach ?>
		</select>

		<select name="day">
		<?php foreach(range(1,31)as $day): ?>
		<option value="<?php echo $day;?>"><?php echo $day;?></option> 
		<?php endforeach ?>
		</select>

		<select name="year">
		<?php foreach (range($lowestYear,$highestYear) as $year):?>
		<option value="<?php echo $year;?>"><?php echo $year;?></option>
		<?php endforeach?>
		</select>

		<select name="hour">
		<?php foreach (range(0,23) as $hour):?>
		<option value="<?php echo $hour;?>"><?php echo $hour;?></option>
		<?php endforeach?>
		</select>
		:
		<select name="minute">
		<?php foreach (range(0,50) as $minute):?>
		<option value="<?php echo $minute;?>"><?php echo $minute;?></option>
		<?php endforeach?>
		</select>
		<br/>
		Release Manager Email: <input type="text" name="ReleaseManager"><br/>
		Build &amp; Release Email: <input type="text" name="BuildAndRelease"><br/>
		SiteOps Email: <input type="text" name="SiteOps"><br/>
		QA Email: <input type="text" name="QA"><br/>

		<input type="submit" name="submit" value="Create Release" />
	</div>
</form>

<?php include 'footer.php'; ?>
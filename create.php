<?php include 'header.php'; ?>
ADD THIS
http://jqueryui.com/datepicker/
THANK YOU!

<form method="post">
	<input type="hidden" name="page" value="create" />
	<div id="pass">
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
		Office: <input type="radio" name="stage" value="Office">Indy
				   <input type="radio" name="stage" value="Office">Palo<br/>
		Deploy To: <input type="radio" name="stage" value="Stage1">Stage1
				   <input type="radio" name="stage" value="Stage2">Stage2
				   <input type="radio" name="group1" value="Both">Both 
				   <br/><br/>
		Included Applications:<br/>
		<table>
			<tr>
				<td>
					<input type="checkbox" name="applications[]" value="ALRoot"> ALRoot <br/> 
					<input type="checkbox" name="applications[]" value="AngiesList"> AngiesList<br/>
					<input type="checkbox" name="applications[]" value="Join"> Join<br/>
					<input type="checkbox" name="applications[]" value="B2BInternalAPI"> B2BInternalAPI<br/>
					<input type="checkbox" name="applications[]" value="BusinessCenter"> BusinessCenter<br/>
					<input type="checkbox" name="applications[]" value="BusinessCenterAPI"> BusinessCenterAPI<br/>
					<input type="checkbox" name="applications[]" value="DB"> DB<br/>
					<input type="checkbox" name="applications[]" value="Databases"> Databases<br/>
					<input type="checkbox" name="applications[]" value="ALSchedulerExecutioner"> ALSchedulerExecutioner<br/>
					<input type="checkbox" name="applications[]" value="AppleAutoRenew"> AppleAutoRenew<br/>
					<input type="checkbox" name="applications[]" value="ContractInvoiceAutoRenewalProcessor"> ContractInvoiceAutoRenewalProcessor<br/>
					<input type="checkbox" name="applications[]" value="ChaseCreditCardUpdateRequester"> ChaseCreditCardUpdateRequester<br/>
					<input type="checkbox" name="applications[]" value="ChaseCreditCardUpdateResponseProcessor"> ChaseCreditCardUpdateResponseProcessor<br/>
					<input type="checkbox" name="applications[]" value="EmailRouter"> EmailRouter<br/>
					<input type="checkbox" name="applications[]" value="MediaTranscoder"> MediaTranscoder<br/>
					<input type="checkbox" name="applications[]" value="StorefrontBigDealPaymentEngine"> StorefrontBigDealPaymentEngine<br/>
					<input type="checkbox" name="applications[]" value="StorefrontEmailEngine"> StorefrontEmailEngine<br/>
					<input type="checkbox" name="applications[]" value="StorefrontContractProcessor"> StorefrontContractProcessor<br/>
					<input type="checkbox" name="applications[]" value="StorefrontNotification"> StorefrontNotification<br/>
					<input type="checkbox" name="applications[]" value="StorefrontWeeklyPaymentEngine"> StorefrontWeeklyPaymentEngine<br/>
				</td>
				<td>
					<input type="checkbox" name="applications[]" value="Tools"> Tools<br/>
					<input type="checkbox" name="applications[]" value="UberMail"> UberMail<br/>
					<input type="checkbox" name="applications[]" value="WebAPI"> WebAPI<br/>
					<input type="checkbox" name="applications[]" value="AnalyticsService"> AnalyticsService<br/>
					<input type="checkbox" name="applications[]" value="AuthenticationService"> AuthenticationService<br/>
					<input type="checkbox" name="applications[]" value="ConnectHubService"> ConnectHubService<br/>
					<input type="checkbox" name="applications[]" value="ContractService"> ContractService<br/>
					<input type="checkbox" name="applications[]" value="FinanceService"> FinanceService<br/>
					<input type="checkbox" name="applications[]" value="MembershipService"> MembershipService<br/>
					<input type="checkbox" name="applications[]" value="ReviewService"> ReviewService<br/>
					<input type="checkbox" name="applications[]" value="PaymentService"> PaymentService<br/>
					<input type="checkbox" name="applications[]" value="StorefrontService"> StorefrontService<br/>
					<input type="checkbox" name="applications[]" value="ServiceProviderService"> ServiceProviderService<br/>
					<input type="checkbox" name="applications[]" value="SchedulingService"> SchedulingService<br/>
					<input type="checkbox" name="applications[]" value="SearchService"> SearchService<br/>
					<input type="checkbox" name="applications[]" value="ConfigurationService"> ConfigurationService<br/>
					<input type="checkbox" name="applications[]" value="ServiceGateway"> ServiceGateway<br/>
					<input type="checkbox" name="applications[]" value="Member-reviews"> Member-reviews<br/>
					<input type="checkbox" name="applications[]" value="BusinessCenter-html5"> BusinessCenter-html5<br/>
					<input type="checkbox" name="applications[]" value="B2B_API"> B2B_API<br/>
				</td>
			</tr>
		</table>
		<br/> 
		Additional Notes: <br/><textarea name="notes" rows="4" cols="30"></textarea><br/>
		<input type="submit" name="submit" value="Create Release" />
	</div>
</form>

<?php include 'footer.php'; ?>
<?php include 'header.php'; ?>

    <form method="post">
        <input type="hidden" name="page" value="create"/>

        <div id="pass">
            <h2>Create Release <img src="images/potato.png" alt="potato"/></h2>

            Release Name: <input type="text" name="name"><br/>

            <p>Goal Launch Date: <input type="text" id="date" name="date"></p>
            Office: <input type="radio" name="office" value="Indy">Indy
            <input type="radio" name="office" value="Palo">Palo<br/>
            Deploy To: <input type="radio" name="targetEnvironment" value="Stage1">Stage1
            <input type="radio" name="targetEnvironment" value="Stage2">Stage2
            <input type="radio" name="targetEnvironment" value="Both">Both
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
                        <input type="checkbox" name="applications[]" value="ALSchedulerExecutioner">
                        ALSchedulerExecutioner<br/>
                        <input type="checkbox" name="applications[]" value="AppleAutoRenew"> AppleAutoRenew<br/>
                        <input type="checkbox" name="applications[]" value="ContractInvoiceAutoRenewalProcessor">
                        ContractInvoiceAutoRenewalProcessor<br/>
                        <input type="checkbox" name="applications[]" value="ChaseCreditCardUpdateRequester">
                        ChaseCreditCardUpdateRequester<br/>
                        <input type="checkbox" name="applications[]" value="ChaseCreditCardUpdateResponseProcessor">
                        ChaseCreditCardUpdateResponseProcessor<br/>
                        <input type="checkbox" name="applications[]" value="EmailRouter"> EmailRouter<br/>
                        <input type="checkbox" name="applications[]" value="MediaTranscoder"> MediaTranscoder<br/>
                        <input type="checkbox" name="applications[]" value="StorefrontBigDealPaymentEngine">
                        StorefrontBigDealPaymentEngine<br/>
                        <input type="checkbox" name="applications[]" value="StorefrontEmailEngine">
                        StorefrontEmailEngine<br/>
                        <input type="checkbox" name="applications[]" value="StorefrontContractProcessor">
                        StorefrontContractProcessor<br/>
                        <input type="checkbox" name="applications[]" value="StorefrontNotification">
                        StorefrontNotification<br/>
                        <input type="checkbox" name="applications[]" value="StorefrontWeeklyPaymentEngine">
                        StorefrontWeeklyPaymentEngine<br/>
                    </td>
                    <td>
                        <input type="checkbox" name="applications[]" value="Tools"> Tools<br/>
                        <input type="checkbox" name="applications[]" value="UberMail"> UberMail<br/>
                        <input type="checkbox" name="applications[]" value="WebAPI"> WebAPI<br/>
                        <input type="checkbox" name="applications[]" value="AnalyticsService"> AnalyticsService<br/>
                        <input type="checkbox" name="applications[]" value="AuthenticationService">
                        AuthenticationService<br/>
                        <input type="checkbox" name="applications[]" value="ConnectHubService"> ConnectHubService<br/>
                        <input type="checkbox" name="applications[]" value="ContractService"> ContractService<br/>
                        <input type="checkbox" name="applications[]" value="FinanceService"> FinanceService<br/>
                        <input type="checkbox" name="applications[]" value="MembershipService"> MembershipService<br/>
                        <input type="checkbox" name="applications[]" value="ReviewService"> ReviewService<br/>
                        <input type="checkbox" name="applications[]" value="PaymentService"> PaymentService<br/>
                        <input type="checkbox" name="applications[]" value="StorefrontService"> StorefrontService<br/>
                        <input type="checkbox" name="applications[]" value="ServiceProviderService">
                        ServiceProviderService<br/>
                        <input type="checkbox" name="applications[]" value="SchedulingService"> SchedulingService<br/>
                        <input type="checkbox" name="applications[]" value="SearchService"> SearchService<br/>
                        <input type="checkbox" name="applications[]" value="ConfigurationService">
                        ConfigurationService<br/>
                        <input type="checkbox" name="applications[]" value="ServiceGateway"> ServiceGateway<br/>
                        <input type="checkbox" name="applications[]" value="Member-reviews"> Member-reviews<br/>
                        <input type="checkbox" name="applications[]" value="BusinessCenter-html5">
                        BusinessCenter-html5<br/>
                        <input type="checkbox" name="applications[]" value="B2B_API"> B2B_API<br/>
                    </td>
                </tr>
            </table>
            <br/>
            Additional Notes: <br/><textarea name="notes" rows="4" cols="30"></textarea><br/>
            <input type="submit" name="submit" value="Create Release"/>
        </div>
    </form>

<?php include 'footer.php'; ?>
{if $fromapp }
    {include file="templates/default/chunks/header-head.tpl"}
    {include file="templates/default/chunks/app-css.tpl"}
{/if}


<div class="container"><div class="page-container">


    <div class="card card-simple-form">

        <div class="app-content-header">

            <div class="p-3  text-center current-balance">
                <h3 class="m-0">
                    {$userdetails.currency.prefix}
                    <span class="calculate balance"> {$userdetails.credit.credit|number_format:$commaseparator:".":","}</span>
                    {$userdetails.currency.suffix}
                </h3>
                <small class="text-muted"> {$lang.currentbalance} </small>
            </div>

            {if $directpaypal}
                <div class="text-lg-center mb-4  bottom-space transactionform">
                    {$lang.alreadypaidbypaypal}?
                    <a class="text-primary" href="javascript:void(0)" onclick="$('.transactionform').toggle();">
                        Add Paypal Transaction
                    </a>
                </div>

                <div class="text-lg-center mb-4  bottom-space transactionform" style="display: none">
                    <a class="text-primary" href="javascript:void(0)" onclick="$('.transactionform').toggle();">
                        Deposit Now
                    </a>
                </div>

            {/if}


        </div>
                {if $disable}
                {else}
                    <form method="post" action="" class="transactionform">

                            {$token}

                        <div class="col-lg-5 p-0 m-auto">
                            <div class="alert text-center alert1 alert-info">
                                * {$lang.addfundsdescription}
                            </div>
                        </div>






                        <div class="card-app col-lg-5 p-0 m-auto">
                                <div>


                                    {if $notification.error}
                                        <div class="alert1 alert alert-danger">
                                            {$notification.error}
                                            <a href="{$idverificationlink}">{$lang.verify} {$lang.account}</a>
                                        </div>
                                    {/if}




                                <div>


                                    <div class="form-group ">
                                        <label class="form-label"> {$lang.depositenow}   </label>
                                        <div class="input-group">
                                            <input class="calculate updateno text-right form-control " style="font-size: 28px;color:black" value="{$amount}"
                                                   type="text" name="amount" id="amount" onkeyup="addPlus()" size="8"/>
                                        </div>
                                        <div class="justify-content-between d-flex min-max">
                                            <small class="text-muted"> {$lang.addfundsminimum}
                                                : {$minimumamount} </small>
                                            <small class="text-muted"> {$lang.addfundsmaximum}
                                                : {$maximumamount}  </small>
                                        </div>
                                    </div>


                                    <div class="border p-4 rounded">

                                    <div class="form-group mb-0">

                                        {if $paypalexpressenabled }
                                            <div class="">
                                                <div class="custom-control custom-radio">
                                                    <input type="radio" name="paymentmethod" checked="checked" onchange="addPlus('paypalexpress');" value="paypalexpress"  id="payment-gateway-express" class="custom-control-input">
                                                    <label class="custom-control-label align-items-center " for="payment-gateway-express">
                                                        <img  width="100" src="templates/default/images/payment/paypalexpress.png" />
                                                        <br/>

                                                    </label>
                                                </div>
                                            </div>
                                        {/if}


                                        <div  class="d-flex align-items-center justify-content-between mt-2">
                                            <div class="custom-control custom-radio" style="margin-top: -20px">
                                                <input type="radio" id="custom-gateway" onchange="getSelectedPaymentgateway()" name="paymentmethod" class="custom-control-input">
                                                <label class="custom-control-label" id="label-payment-gateway" for="custom-gateway">
                                            </div>


                                            <select class="no-chosen form-control" style="margin-top: 15px" onchange="javascript:addPlus(this.value);$('#label-payment-gateway').click();"
                                                    name="method">
                                                <option value="">Other Payment Method</option>
                                                {foreach key=num item=gateway from=$gateways}
                                                    <option {assign var=foo value=$foo+1}
                                                            {if $foo eq 1 && !$paypalexpressenabled}
                                                                selected="selected"
                                                            {/if}
                                                            data-img-src="{if $gateway.image}{$gateway.image}{else}images/payment/{$gateway.sysname}.png{/if}"
                                                            value="{$gateway.sysname}">{$gateway.name}</option>
                                                {/foreach}
                                            </select>

                                        </div>


                                    </div>




                                    <div class="loadinfo"></div>


                                    </div>





                                    <div class="price-details w-100 deposit-total border-top-0 border-bottom pb-3">
                                        <table class="table no-wrap border-0 align-items-center">
                                            <tr>
                                                <td> Deposit</td>
                                                <td class="seperator-colon"></td>
                                                <td>
                                                    <div>{$userdetails.currency.prefix}
                                                        <span class="total-deposit"> {$amount} </span>
                                                        {$userdetails.currency.suffix}
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><span class="taxname"></span></td>
                                                <td class="seperator-colon"></td>
                                                <td><span class="calculate tax"></span></td>
                                            </tr>
                                            <tr>
                                                <td><span class="">Fixed Charge</span></td>
                                                <td class="seperator-colon"></td>
                                                <td><span class="calculate fixedcharge"></span></td>
                                            </tr>
                                            <tr>
                                                <td><span class="taxname2"></span></td>
                                                <td class="seperator-colon"></td>
                                                <td><span class="calculate tax2"></span></td>
                                            </tr>
                                            <tr>
                                                <td> Total</td>
                                                <td class="seperator-colon"></td>
                                                <td class="double-border">
                                                    <h5>{$userdetails.currency.prefix}
                                                        <span class="total-paynow"> {$amount} </span>
                                                        {$userdetails.currency.suffix}
                                                    </h5>
                                                </td>
                                            </tr>
                                        </table>





                                    </div>

                                    <div class="clearfix"></div>

                                     <div   class="d-actionbar-mobile   justify-content-between">

                                         <div>
                                             <div>
                                                 {$lang.balanceafterdeposit} : <strong> {$userdetails.currency.prefix}<span
                                                             class="calculate total">{$userdetails.credit.credit}</span> {$userdetails.currency.suffix}
                                                 </strong>
                                             </div>
                                         </div>

                                         <div>
                                            <button type="submit" class="btn btn-primary" value="{$lang.addfund}">
                                                {$lang.next}  &nbsp; <i class="fal fa-arrow-right"></i>
                                            </button>
                                         </div>

                                    </div>

                                </div>
                            </div>
                            </div>

                    </form>
                    <form method="post" id="frmdirect" style="display: none;" class="transactionform">




                        {if $directpaypal}
                            {$token}
                            <div class="card-app">
                                <div class="row">
                                <div class="col-lg-5 m-auto">

                                    <div class="alert alert2"></div>

                                    <div class="form-group ">
                                        <label class="form-label">
                                            {$lang.paidto}
                                        </label>
                                        <div class="w-100">
                                            <div class="">
                                                <select class="form-control no-chosen" name="directpaypal"
                                                        onchange="getDirectInfo('{$directfundlink}',this.value)">
                                                    <option value="">{$lang.select_}</option>
                                                    {foreach key=gateway item=payto from=$directpaypal}
                                                        <option value="{$gateway}">{$payto}</option>
                                                    {/foreach}
                                                </select>
                                                <div id="directinfo"></div>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="form-group ">
                                        <label class="form-label">
                                            {$lang.transactionid}
                                        </label>
                                        <div class="w-100">
                                            <div class="">
                                                <input class="form-control" type="text" name="txnid"/>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="form-group ">
                                        <label class="form-label">
                                            {$lang.notes} :
                                        </label>
                                        <div class="w-100">
                                            <div class="">
                                                <textarea class="form-control" rows="5" type="text"
                                                          name="notes"></textarea>
                                            </div>
                                        </div>

                                    </div>
                                    <div id="hide_otpbox" class="form-group otps" style="display: none;">
                                        <label class="form-label">
                                            {$lang.otp} :
                                        </label>
                                        <div class="w-100">
                                            <div class="">
                                                <input type="text" name="otp" value="" class="form-data"/>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="d-actionbar-mobile justify-content-end">

                                            <button type="button" name="addfund" class="btn btn-primary w-100"
                                                   value="{$lang.addfund}" id="btnads"
                                                    onclick="SubmitForm('#btnads','{$directfundsave}','#frmdirect','.alert2','true','#loader');"> {$lang.addfund} </button>
                                            <span class="otps" id="hide_btnr" style="display: none;">
												<input type="button" name="reset" class="btn btn-primary"
                                                       value="{$lang.resend} {$lang.otp}" id="btnreset"
                                                       onclick="SubmitForm('#btnreset','{$directfundresend}','#frmdirect','.alert2','true','#loader');"/>
											</span>

                                    </div>
                                </div>
                            </div>
                            </div>
                        {/if}
                    </form>
                {/if}


    </div>

    </div></div>

    <script>
        $(document).ready(function () {
            $('.gateways').click(function () {
                addPlus($(this).val());
            });

            {if $paypalexpressenabled}
                addPlus('paypalexpress');
            {else}
                addPlus($('select[name=method]').val());
            {/if}

        });

        function addPlus(gateway) {

            if(Boolean(gateway)) {
                $('[name=paymentmethod]').val(gateway);
            }
            else{
                gateway = $('[name=paymentmethod]').val()
            }

            var amount = $("#amount").val();

            $.post(urlprefix+'widget/getWithTax', {
                gateway: gateway,
                amount: amount,
                balance: $('.balance').text()
            }, function (data) {

                var arr = data.split("_");
              //  alert(arr[8]);
                $('.total').html(arr[0]);
                $('.tax').html(arr[1]);
                $('.taxname').html(arr[2]);
                $('.amount').html(amount);
                $('.tax2').html(arr[3]);
                $('.fixedcharge').html(arr[8]);
                if (arr[6]) {
                    $('.loadinfo').html(arr[6]);
                }
                else{
                    $('.loadinfo').html('');
                }
                if (parseFloat(arr[7]) > 0) {
                    $('.total').append("<br />You will earn " + arr[7] + " points");
                }
                $('.taxname2').html(arr[4]);

                $('.total-deposit').text(parseFloat(parseFloat($('#amount').val())));

                if (arr[5] == 'Inclusive') {
                    $('.total-paynow').text(parseFloat(parseFloat($('#amount').val())).toFixed(2));
                } else {
                    $('.total-paynow').text(parseFloat(parseFloat($('#amount').val()) + parseFloat($('.tax').text())+ parseFloat($('.fixedcharge').text()) + parseFloat($('.tax2').text())).toFixed(2));
                }
            });
            if ($('.updateno').val() == '') {
                $('.updateno').val('0');
            }
            if (amount == 0) {
                $('.xyz').slideUp();
            } else {
                $('.xyz').slideDown();
            }
        }

        function getSelectedPaymentgateway(){
            let gateway = $('select[name=method]').val();
            addPlus(gateway);
        }

    </script>



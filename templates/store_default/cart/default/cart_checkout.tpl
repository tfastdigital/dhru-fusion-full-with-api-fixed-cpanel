{function name=register}
    <div class="form-row">
        <div class="form-group  col-lg-6">
            <label class="form-label">
                {$lang.email}
            </label>
            <div>
                <input type="text" class="form-control " size="40" name="sh_email"/>
            </div>
        </div>
        <div class="form-group  col-lg-6">
            <label class="form-label">
                {$lang.contactno}
            </label>
            <div>
                <input type="text" class="form-control " name="sh_contact"/>
            </div>
        </div>
    </div>
    <div class="form-row">
        <div class="form-group  col-lg-6">
            <label class="form-label">
                {$lang.firstname}
            </label>
            <div>
                <input type="text" class="form-control " name="sh_firstname"/>

            </div>
        </div>
        <div class="form-group   col-lg-6">
            <label class="form-label">
                {$lang.lastname}
            </label>
            <div>
                <input type="text" class="form-control " name="sh_lastname"/>

            </div>
        </div>
    </div>
    <div class="form-group ">
        <label class="form-label">
            {$lang.address} 1
        </label>
        <div>
            <input type="text" class="form-control " name="sh_address1"/>
        </div>
    </div>
    <div class="form-group ">
        <label class="form-label">
            {$lang.address} 2
        </label>
        <div>
            <input type="text" class="form-control " name="sh_address2"/>
        </div>
    </div>
    <div class="form-row">
        <div class="form-group   col-lg-6">
            <label class="form-label">
                {$lang.city}
            </label>
            <div>
                <input type="text" class="form-control " name="sh_city"/>
            </div>
        </div>
        <div class="form-group  col-lg-6">
            <label class="form-label">
                {$lang.zip}
            </label>
            <div>
                <input type="text" class="form-control " name="sh_zip"/>
            </div>
        </div>
        <div class="form-group  col-lg-12">
            <label class="form-label">
                {$lang.state}
            </label>
            <div>
                <input type="text" class="form-control " name="sh_state"/>
            </div>
        </div>

    </div>
    <div class="form-group ">
        <label class="form-label">
            {$lang.country}
        </label>
        <div>
            {$country2}
        </div>
    </div>
{/function}


<div class="container"><div class="page-container">

    <script src="includes/js/ccvalidate.js" type="text/javascript"></script>


    {literal}
        <script type="text/javascript">

            var defaultaddress = {
                address1: "{/literal}{$userdetails.address1}{literal}",
                address2: "{/literal}{$userdetails.address2}{literal}",
                city: "{/literal}{$userdetails.city}{literal}",
                city_code: "{/literal}{$userdetails.city_code}{literal}",
                country: "{/literal}{$userdetails.country}{literal}",
                country_code: "{/literal}{$userdetails.country_code}{literal}",
                firstname: "{/literal}{$userdetails.firstname}{literal}",
                landmark: "{/literal}{$userdetails.landmark}{literal}",
                latitude: "{/literal}{$userdetails.latitude}{literal}",
                longitude: "{/literal}{$userdetails.longitude}{literal}",
                mobile: "{/literal}{$userdetails.phonenumber}{literal}",
                phone_code: "{/literal}{$userdetails.phone_code}{literal}",
                zip: "{/literal}{$userdetails.zip}{literal}",
                preference: "{/literal}{$userdetails.preference}{literal}",
                state: "{/literal}{$userdetails.state}{literal}",
                state_code: "{/literal}{$userdetails.state_code}{literal}"
            }



            checkoutreload('#cart_reload','','',defaultaddress,'');

            function checkp(val1, val2) {
                if (val1 == '') {
                    alert('Write Credit Card Number First');
                    $("#ccno").focus();
                    return false;
                }
                var vls = checkCreditCard(val1, val2);
                if (!vls) {
                    alert("Credit card number is invalid");
                    $("#ccno").focus();
                    return false;
                }
            }

            function showshipping(val) {
                if (!val) {
                    document.getElementById('frmship').style.display = '';
                } else {
                    document.getElementById('frmship').style.display = 'none';
                }
            }

        </script>
    {/literal}

    <div class="">


        <div class="row">


            <div class="col-lg-6 col-left">
                <div class="reload-cartitems">
                    <div class="card">
                        <div id="cart_reload"></div>
                    </div>
                </div>
            </div>


            <div class="col-lg-6 col-right">

                {if $notification}
                    <div class="alert1 alert alert-checkout {$class}">
                        {$msg}
                    </div>
                {else}
                    <div class="alert alert-checkout"></div>
                {/if}


                {if $notification}
                    <div id="notification" class="alert alert-checkout {$class}">
                        {$msg}
                    </div>
                {/if}

                {if $loggedin}

                    <div class="modal    hide p-0" id="modal-addresses"  tabindex='-1'>
                        <div class="modal-dialog modal-dialog-centered  modal-lg m-auto mw-600">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">{$lang.address}</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">  <span class="d-none d-md-block">&times;</span><span class="d-block d-md-none"><i class="fal fa-times"></i></span> </button>
                                </div>
                                <div class="modal-body">
                                    {include file="templates/default/client_addresses.tpl"}
                                </div>
                            </div>
                        </div>
                    </div>



                    <form method="post" name="checkout" id="checkout">

                        {*<input type="hidden" name="curriers" id="curriers"/>*}

                        <div id="shipping-address">
                            <input type="hidden" class="form-control"  value="{$userdetails.zip}"  name="sh_zip"/>
                            <input type="hidden" class="form-control"  value="{$userdetails.state}"  name="sh_state"/>
                            <input type="hidden" class="form-control"  value="{$userdetails.country}"  name="sh_country"/>
                            <input type="hidden" class="form-control"  value="{$userdetails.city}"  name="sh_city"/>
                            <input type="hidden" class="form-control"  value="{$userdetails.address1}"  name="sh_address1"/>
                            <input type="hidden" class="form-control"  value="{$userdetails.address2}"  name="sh_address2"/>
                            <input type="hidden" class="form-control"  value="{$userdetails.landmark}"  name="sh_landmark"/>
                            <input type="hidden" class="form-control" value="{$userdetails.firstname}" name="sh_firstname"/>
                            <input type="hidden" class="form-control" value="{$userdetails.email}"  name="sh_email"/>
                            <input type="hidden" class="form-control" value="{$userdetails.phonenumber}"  name="sh_phonenumber"/>
                            <input type="hidden" class="form-control" value="{$userdetails.preference}"  name="sh_preference"/>
                        </div>



                        <div>


                            <div  id="address-panel">

                                <div class="card card-address card-address-billing mb-4  bottom-space">

                                    <h5 class="card-title d-flex justify-content-between align-items-center">
                                        <span>{$lang.billingaddress}</span>
                                    </h5>

                                    <div>

                                        <div   class="row">
                                            <div class="col-lg-12">
                                                <div  class="rounded" >
                                                    <div class="d-flex">
                                                        <div class="mr-2">
                                                            <i class="fal fa-map-marker"></i>
                                                        </div>
                                                        <div>
                                                            {$userdetails.firstname} {$userdetails.lastname}
                                                            <address>
                                                                <div>  {$userdetails.address1} {$userdetails.address2} {$userdetails.landmark} </div>
                                                                <div> {$userdetails.city} - {$userdetails.zip} </div>
                                                                <div> {$userdetails.state}  </div>
                                                                <div> {$userdetails.country} </div>
                                                            </address>
                                                            <div>  {$userdetails.phonenumber} </div>
                                                        </div>
                                                    </div>


                                                </div>
                                            </div>


                                        </div>
                                    </div>

                                </div>


                                {if $physicalgoods}
                                    <div class="card card-address card-address-shipping mb-4  bottom-space">

                                        <h5 class="card-title d-flex justify-content-between align-items-center">
                                            <span>{$lang.shippingaddress}</span>
                                            <small  class="cursor-pointer text-sm text-primary"  onclick="setAddress(false,'')"   >  + {$lang.add} {$lang.address}</small>
                                        </h5>

                                        <div class="mt-2">



                                            <div id="addresses" class="row row-grid">
                                                <div class="col-lg-6 col-grid">
                                                    <div data-toggle="tooltip" data-title="{$lang.shiptothisaddress}" class="addresses  p-3 rounded default  cursor-pointer" id="addresses10000"
                                                         onclick="setShippingAddress('default','10000');">
                                                        <div class="d-flex">
                                                            <div class="mr-2">
                                                                <i class="fal fa-map-marker"></i>
                                                            </div>
                                                            <div>
                                                                {$userdetails.firstname} {$userdetails.lastname}
                                                                <address>
                                                                    <div>  {$userdetails.address1} {$userdetails.address2} {$userdetails.landmark} </div>
                                                                    <div> {$userdetails.city} - {$userdetails.zip}  </div>
                                                                    <div> {$userdetails.state} </div>
                                                                    <div> {$userdetails.country} </div>
                                                                </address>
                                                                <div>  {$userdetails.phonenumber} </div>
                                                            </div>
                                                        </div>


                                                    </div>
                                                </div>

                                                {foreach key=id item=address from=$extraaddress}
                                                    <div class="col-lg-6 col-grid">
                                                        <div data-toggle="tooltip" data-title="Ship to this address" class="addresses  p-3 rounded   cursor-pointer" id="addresses{$id}"
                                                             onclick="getJson('{$addresssavelink}/?addresskey={$id}',function(data) {
                                                                     setShippingAddress(data,{$id});
                                                                     })" >
                                                            <div class="d-flex">
                                                                <div class="mr-2">
                                                                    <i class="fal fa-map-marker"></i>
                                                                </div>
                                                                <div>
                                                                    {$address.firstname}
                                                                    <address>
                                                                        <div>  {$address.address1} </div>
                                                                        <div> {$address.address2} </div>
                                                                        <div> {$userdetails.landmark} </div>
                                                                        <div> {$address.city} - {$address.zip}  </div>
                                                                        <div> {$address.state} </div>
                                                                        <div> {$address.country} </div>
                                                                    </address>
                                                                    <div>  {$address.phonenumber} </div>
                                                                    <div> <small class="text-muted">{$address.preference}</small>  </div>
                                                                </div>
                                                            </div>

                                                            <div class="address-action">
                                                                <div class="d-flex justify-content-end">
                                                                <span onclick="getJson('{$addresssavelink}/?addresskey={$id}',function(data) {
                                                                        setAddress(data,{$id});
                                                                        })" class="p-2" data-toggle="tooltip" data-title="Edit Address"> <i class="fal fa-edit"></i> </span>
                                                                    <span onclick="deleteAddress('{$addresssavelink}/?deleteid={$id}')" class="p-2" data-toggle="tooltip" data-title="Remove Address"> <i class="fal fa-trash"></i> </span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                {/foreach}
                                            </div>
                                        </div>

                                    </div>
                                    <div class="card card-shipping-service mb-4  bottom-space">
                                        <h5  class="card-title mb-4 bottom-space"> <span>{$lang.shippingservices}</span> </h5>
                                        <div>
                                            <input type="hidden" name="servicetype" value="imei"/>

                                            <div class="form-group mb-0">
                                                <div>
                                                    <div id="shippingdropdown" class="custom-radio-center">
                                                        <span>Loading Shipping Gateway...</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                {else}
                                    <div class="card mb-4  bottom-space">
                                        <h5 class="card-title d-flex justify-content-between align-items-center">
                                            <span>{$lang.shippingaddresses}</span>
                                        </h5>
                                        <div class="d-block alert alert-info">{$lang.allitemdigital} </div>
                                    </div>
                                {/if}



                                <div class="card card-payment-method mb-4  bottom-space">

                                    <h5  class="card-title"> <span>{$lang.paymentmethod} </span></h5>

                                    <div class="pt-3">


                                            {if $paypalexpress}
                                                <input type="hidden" name="gateway" value="paypalexpress"/>
                                            {else}
                                                <div class="form-group mb-0">

                                                    <input type="hidden" name="gateway" id="selectedgateway">

                                                    {if $paypalexpressenabled }
                                                        <div class="">
                                                            <div class="custom-control custom-radio">
                                                                <input type="radio" name="paymentgateway" checked="checked" onchange="setGateway('paypalexpress',{$useridverified});" value="paypalexpress"  id="payment-gateway-express" class="custom-control-input">
                                                                <label class="custom-control-label align-items-center " for="payment-gateway-express">
                                                                     <img  width="100" src="templates/default/images/payment/paypalexpress.png" />
<br/>
                                                                   <!-- <small >  {$paypalexpressenabled} </small>-->
                                                                </label>
                                                            </div>
                                                        </div>
                                                    {/if}


                                                    {if $allowwallet}
                                                    <div class="mt-3">
                                                        <div class="custom-control custom-radio">
                                                            <input type="radio" name="paymentgateway" onchange="setGateway('applycredit');" value="applycredit" id="payment-gateway-creditbalance" class="custom-control-input">
                                                            <label class="custom-control-label align-items-center " for="payment-gateway-creditbalance">   {$creditbalance} </label>
                                                        </div>
                                                    </div>
                                                    {/if}

                                                    <div  class="d-flex align-items-center justify-content-between mt-2">
                                                        <div class="custom-control custom-radio">
                                                            <input type="radio" id="customRadioInline2" name="paymentgateway" class="custom-control-input">
                                                            <label class="custom-control-label" id="label-payment-gateway" for="customRadioInline2">
                                                        </div>


                                                        <select id="gatewaylist"  class="my-select   no-chosen form-control"
                                                                  onchange="javascript:getCCGateway(this.value);setGateway(this.value,{$useridverified});$('#label-payment-gateway').click();">
                                                            <option value=""> {$lang.otherpaymentmethod} </option>
                                                            {foreach key=id item=gat from=$gateway}
                                                                <option {$check}   value="{$id}">{$gat.name}</option>
                                                            {/foreach}
                                                        </select>


                                                        <div>
                                                        {foreach key=id item=gat from=$gateway}
                                                            {if $gat.kyc eq '1'}
                                                        <div class="cursor-pointer d-none" id="payment_{$id}" href="settings/idverification/?standalone=true" data-dismiss="modal" data-target="#modal-ajax"
                                                             data-size="modal-xl" data-toggle="modal"
                                                             data-whatever="ID Verificaiton">{$gat.name}</div>

                                                            {/if}

                                                        {/foreach}

                                                        </div>

                                                        <div id="payment-content">

                                                        </div>

                                                    </div>

                                                </div>
                                            {/if}


                                        {if $cardlastfour}
                                            <div id="creditcard" style="display:none;" class="cc-container">
                                                <div class="form-group ">
                                                    <label class="form-label">
                                                        {$lang.paybycard}
                                                    </label>
                                                    XXXXXXXXX{$cardlastfour}
                                                </div>
                                            </div>
                                        {else}
                                            <div id="creditcard" style="display:none;" class="jumbotron cc-container">
                                                <div class="form-group ">
                                                    <label class="form-label">
                                                        {$lang.card} {$lang.type}
                                                    </label>
                                                    <select name="cardtype" id="cardtype"
                                                            class="cc-ddl-type form-control no-chosen">
                                                        {foreach from=$ccarr item=cc key=id}
                                                            <option value="{$id}">{$cc}</option>
                                                        {/foreach}
                                                    </select>
                                                </div>

                                                <div class="row">
                                                    <div class="form-group  col-lg-6">
                                                        <label class="form-label">
                                                            {$lang.card}{$lang.holder} {$lang.name}
                                                        </label>
                                                        <input type="text" class="form-control " name="cardname"
                                                               value=""/>
                                                    </div>
                                                    <div class="form-group   col-lg-6">
                                                        <label class="form-label">
                                                            {$lang.card} {$lang.number}
                                                        </label>
                                                        <input type="text" class="form-control " id="ccno" name="cardno"
                                                               class="cc-card-number"/>
                                                    </div>
                                                </div>


                                                <div class="row">
                                                    <div class="form-group  col-lg-4">
                                                        <label class="form-label">
                                                            {$lang.expiry} {$lang.date}
                                                        </label>
                                                        <select class="form-control no-chosen"
                                                                onchange="javascript: checkp( $('#ccno').val(), $('#cardtype').val());"
                                                                name="endmonth" id="cc-month">
                                                            <option value="January">January</option>
                                                            <option value="February">February</option>
                                                            <option value="March">March</option>
                                                            <option value="April">April</option>
                                                            <option value="May">May</option>
                                                            <option value="June">June</option>
                                                            <option value="July">July</option>
                                                            <option value="August">August</option>
                                                            <option value="September">September</option>
                                                            <option value="October">October</option>
                                                            <option value="November">November</option>
                                                            <option value="December">December</option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group col-lg-4">
                                                        <label class="form-label"></label>
                                                        <select name="endyear" class="form-control no-chosen"
                                                                onchange="javascript: checkp( $('#ccno').val(), $('#cardtype').val());"
                                                                id="Select1">
                                                            {section name=foo start=$exps loop=$expe step=1}
                                                                <option value="{$smarty.section.foo.index}">{$smarty.section.foo.index}</option>
                                                            {/section}
                                                        </select>
                                                    </div>
                                                    <div class="form-group   col-lg-4">
                                                        <label class="form-label">
                                                            CCV
                                                        </label>
                                                        <input class="form-control"
                                                               onkeyup="javascript: checkp( $('#ccno').val(), $('#cardtype').val());"
                                                               type="text" name="ccv" size="5"/>
                                                    </div>

                                                </div>


                                            </div>
                                        {/if}
                                    </div>

                                </div>


                                <div class="card card-instruction mb-4  bottom-space">
                                    <div class="form-group m-0">
                                        <textarea name="seller_instruction"  placeholder="{$lang.specialinstruction}" class="form-control" cols="30" rows="2"></textarea>
                                    </div>

                                    {if $shipping}
                                        <div class="mt-3">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input"  id="check-gift" name="gift" value="1">
                                                <label class="custom-control-label" for="check-gift"> <i class="fal fa-gift"></i> {$lang.thisgift}</label>
                                            </div>
                                        </div>
                                    {/if}

                                </div>




                            </div>





                            <div id="id-varification-panel" style="display: none">
                                <div class="card mb-4  bottom-space">
                                    <div class="form-group m-0">
                                        <div   id="id-verification">

                                        </div>
                                    </div>
                                </div>
                            </div>



                                <div class="d-actionbar-mobile p-0">

                                    <div class="d-flex w-100">


                                    <button type="button" id="idverification-save"  style="display: none"  class="btn btn-primary ml-auto"
                                            onclick="validation()">
                                        {$lang.checkout}
                                    </button>



                                    <button type="submit" class="btn btn-primary" id="regi"
                                            onclick="SubmitForm('#regi','{$checkoutfinalink}','#checkout','.alert-checkout','true','#loader');"
                                            name="register" value="">
                                        {if !$paypalexpress} {$lang.checkout}  {else}  {$lang.processtopayment}  {/if}
                                    </button>


                                        <button type="button" id="idverification"  style="display: none"  class="btn btn-primary ml-auto"
                                                onclick="$('#address-panel,#idverification').hide();$('#id-varification-panel,#idverification-save').show(); getContect('#id-verification', 'settings/idverification?standalone=true', '#id-verification', true, '#loader', true);">
                                            {$lang.next}
                                        </button>

                                    </div>

                                </div>
                            </div>

                    </form>
                {else}
                    <div class="card">

                        {if $notification}
                            <div id="notification" class="alert alert-checkout {$class}">
                                {$msg}
                            </div>
                        {/if}

                        <h5 class="text-left">
                            <span> {$lang.alreadyhaveanaccount}  </span>
                            <a class="ml-3" href="#" style="text-decoration: underline" data-keyboard="true" data-toggle="modal" data-target="#login" >
                                <span>{$lang.login} {$lang.here}</span>
                            </a>
                        </h5>

                        <h3 class="h3  or m-0">
                            <span class="text-muted" style="opacity: 1">{$lang.or} </span>
                        </h3>

                        <div class="">
                            <h5 class="text-left"><span> {$lang.registeranaccount}    </span></h5>

                            <div class="page-checkout">
                                {include file="templates/default/client_registration.tpl"}
                            </div>
                        </div>

                    </div>
                {/if}

            </div>
        </div>
    </div>
    </div></div>

{literal}
    <style>
        .page-checkout .page-registration {
            flex: 0 0 100%;
            max-width: 100%;
            max-width: 100%;
            padding: 0 !important;
        }

        .page-checkout .page-registration .wizard-title {
            font-weight: normal;
            font-size: 13px;
            color: #888;
        }
        .addresses:hover{
            background: #eee;
        }
        .addresses{
            position: relative;
            border:transparent solid 1px;
        }
        .addresses.default{
            border:#ccc dashed 1px;
            background: #fafafa;
        }
        .addresses .address-action{
            display: none;
            position: absolute;
            left:0;
            bottom:0;
            right:0;
        }
        .addresses.default .address-action .shipped{
            display: none;
        }
        .addresses:hover .address-action{
            display: block;
        }
    </style>
    <script>
        $(document).ready(function () {
            cartreload("#cart_reload",this.value); setval(this.value);
        });
        function setGateway(value,useridverified){

            if(($('#payment_'+value).length || value === 'paypalexpress') && useridverified === 0){
                $('#idverification').show();
                $('#regi').hide();
            }
            else{
                $('#idverification').hide()
                $('#regi').show();
            }
            $('input#selectedgateway').val(value);
            let currier = $('input[name="curriers"]:checked').val();
            cartreload("#cart_reload",currier,value);
        }

        function verificationSuccess(){
            $('#regi').click();
            setTimeout(function (){
                $('#address-panel,#regi').show();
                $('#id-varification-panel,#idverification,#idverification-save').hide();
            },2000)
        }

    </script>
{/literal}


{*{foreach key=id item=gat from=$gateway}
    {if $id eq 'paypalexpress'}
        <script>
            $('#gatewaylist').val('{$id}');
            getCCGateway('{$id}');setGateway('{$id}',{$useridverified});$('#label-payment-gateway').click();
        </script>
    {/if}
{/foreach}*}


{if $paypalexpressenabled}
    <script>
        setGateway('paypalexpress',{$useridverified});
    </script>
{/if}

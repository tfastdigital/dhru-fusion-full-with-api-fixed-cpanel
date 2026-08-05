<div class="container"><div class="page-container">


    <div class="card card-registration card-simple-form">
        <div class="">
            <div class="m-auto page-registration mw-500">
                <div class="">
                    <div data-toggle="tooltip"       data-placement="top" title="{$lang.clicktoclose} "
                         class="alert {if $msg}alert1 alert-success{/if} alert-reg">
                        {$msg}
                    </div>
                    {if $msg}

                     {else}
                        {if $registrationmode eq 3}
                            <div class="text-muted">{$lang.registration} {$lang.disabled}</div>
                        {else}
                            <div class="registration-steps">

                        <div>
                            <h4 id="wizard-title" class="m-0 wizard-title">{$lang.accountinfo}</h4>
                        </div>


                        <form class="form" method="post" name="registration" id="registration">



                            <div class="steps">
                                <ul class="nav nav-tabs nav-wizard" id="registrationTab" role="tablist">
                                    <li class="nav-item checked">
                                        <a class="nav-link" id="tab1-tab" data-toggle="tab" href="#tab1" role="tab"
                                           aria-controls="home" aria-selected="true"></a>
                                    </li>
                                    <li class="nav-item ">
                                        <a class="nav-link" id="tab2-tab" data-toggle="tab" href="#tab2" role="tab"
                                           aria-controls="profile" aria-selected="false"></a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="tab3-tab" data-toggle="tab" href="#tab3" role="tab"
                                           aria-controls="messages" aria-selected="false"></a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="tab4-tab" data-toggle="tab" href="#tab4" role="tab"
                                           aria-controls="settings" aria-selected="false"></a>
                                    </li>

                                </ul>
                            </div>

                            <div class="tab-content mt-3">

                                <section class="tab-pane active" id="tab1">
                                    <div class="">

                                        <h5><span> {$lang.accountinfo} </span></h5>


                                        <div class="form-row ">
                                            <div class="form-group  col-12">
                                                <label class="form-label">
                                                    {$lang.email}
                                                </label>
                                                {$email}

                                                {if $registration_type neq 3}
                                                    <div class="mt-1">
                                                        {$newsletter}
                                                    </div>
                                                {/if}

                                            </div>

                                            {if $displayusername eq '1'}

                                            <div class="form-group  col-12">
                                                <label class="form-label">
                                                    {$lang.username} (optional)
                                                </label>
                                                {$username}
                                            </div>

                                            {/if}

                                        </div>
                                        <div class="form-row ">
                                            <div class="form-group  col-lg-6">

                                                <div>
                                                    <label class="form-label" for="passwordinput">
                                                        {$lang.password}
                                                    </label>
                                                    <div class="position-relative">
                                                        <input id="password" class="form-control input-md"
                                                               name="password" type="password"
                                                               data-placement="top"
                                                               placeholder="Enter your password" data-html="true"
                                                               data-toggle="popover"
                                                               data-trigger="focus"
                                                               title=""
                                                               autocomplete="off"
                                                               data-content='<div> <div id="popover-password">
                                        <p><span id="result"></span></p>
                                        <div class="progress">
                                            <div id="password-strength"
                                                 class="progress-bar"
                                                 role="progressbar"
                                                 aria-valuenow="40"
                                                 aria-valuemin="0"
                                                 aria-valuemax="100"
                                                 style="width:0%">
                                            </div>
                                        </div>
                                        <ul class="list-unstyled">
                                            <li class="">
                                    <span class="low-upper-case">
                                        <i class="fas fa-circle" aria-hidden="true"></i>
                                        &nbsp;Lowercase &amp; Uppercase
                                    </span>
                                            </li>
                                            <li class="">
                                    <span class="one-number">
                                        <i class="fas fa-circle" aria-hidden="true"></i>
                                        &nbsp;Number (0-9)
                                    </span>
                                            </li>
                                            <li class="">
                                    <span class="one-special-char">
                                        <i class="fas fa-circle" aria-hidden="true"></i>
                                        &nbsp;Special Character (!@#$%^&*)
                                    </span>
                                            </li>
                                            <li class="">
                                    <span class="eight-character">
                                        <i class="fas fa-circle" aria-hidden="true"></i>
                                        &nbsp;Atleast 8 Character
                                    </span>
                                            </li>
                                        </ul>
                                    </div> </div>'>

                                                        <span class="show-pass" onclick="toggle()">
                                                <i class="far fa-eye" onclick="myFunction(this)"></i>
                                            </span>

                                                    </div>
                                                </div>

                                               {* <label class="form-label">
                                                    {$lang.password}
                                                </label>
                                                {$password}*}
                                            </div>
                                            <div class="form-group  col-lg-6">
                                                <label class="form-label">
                                                    {$lang.confirmpass}
                                                </label>
                                                {$confirmation}
                                            </div>
                                        </div>












                                        {if $registration_type neq 3}
                                            {if !$minregistration}
                                                <div class="form-row">
                                                    <div class="form-group   col">
                                                        <label class="form-label">
                                                            {$lang.language}
                                                        </label>
                                                        {$language}
                                                    </div>
                                                    {if $resellerstore}
                                                        <div class="form-group    col">
                                                            <label class="form-label">
                                                                {$lang.currency}
                                                            </label>
                                                            {$currency}
                                                        </div>
                                                    {/if}
                                                </div>
                                            {/if}
                                        {/if}


                                    </div>

                                    <div class="d-actionbar-mobile">
                                        <div class="col">
                                            <button type="button" class="btn btn-primary forward"
                                                    onclick="checkStep(this,'?validateregistration=1&step=1')">{$lang.next} &nbsp; <i class="fal fa-arrow-right"></i>
                                            </button>
                                        </div>
                                    </div>

                                </section>

                                <section class="tab-pane " id="tab2">
                                    <div>
                                        <h5><span>{$lang.billinginfo}  </span></h5>
                                        {if $registration_type neq 3}
                                            <div class="form-row ">
                                                <div class="form-group   col-sm-6">
                                                    <label class="form-label">
                                                        {$lang.firstname}
                                                    </label>
                                                    {$first_name}
                                                </div>
                                                <div class="form-group   col-sm-6">
                                                    <label class="form-label">
                                                        {$lang.lastname}
                                                    </label>
                                                    {$last_name}
                                                </div>

                                            </div>
                                            {if !$minregistration}
                                                <div class="form-group ">
                                                    <label class="form-label">
                                                        {$lang.address} 1
                                                    </label>
                                                    {$address1}
                                                </div>
                                                <div class="form-group  stextarea">
                                                    <label class="form-label">
                                                        {$lang.address} 2
                                                    </label>
                                                    {$address2}
                                                </div>
                                            {/if}



                                            <div class="form-row ">

                                                <div class="form-group  col-lg-12">
                                                    <label class="form-label">
                                                        {$lang.country}
                                                    </label>
                                                    <input type="hidden"  class="form-control"   name="country"  value="">
                                                    <select class="form-control no-chosen" id="country_code" onchange="getState()" name="country_code"><option value="">Select</option><option value="AF">Afghanistan</option><option value="AX">Aland Islands</option><option value="AL">Albania</option><option value="DZ">Algeria</option><option value="AS">American Samoa</option><option value="AD">Andorra</option><option value="AO">Angola</option><option value="AI">Anguilla</option><option value="AQ">Antarctica</option><option value="AG">Antigua And Barbuda</option><option value="AR">Argentina</option><option value="AM">Armenia</option><option value="AW">Aruba</option><option value="AU">Australia</option><option value="AT">Austria</option><option value="AZ">Azerbaijan</option><option value="BS">Bahamas</option><option value="BH">Bahrain</option><option value="BD">Bangladesh</option><option value="BB">Barbados</option><option value="BY">Belarus</option><option value="BE">Belgium</option><option value="BZ">Belize</option><option value="BJ">Benin</option><option value="BM">Bermuda</option><option value="BT">Bhutan</option><option value="BO">Bolivia</option><option value="BA">Bosnia And Herzegovina</option><option value="BW">Botswana</option><option value="BV">Bouvet Island</option><option value="BR">Brazil</option><option value="IO">British Indian Ocean Territory</option><option value="BN">Brunei Darussalam</option><option value="BG">Bulgaria</option><option value="BF">Burkina Faso</option><option value="BI">Burundi</option><option value="KH">Cambodia</option><option value="CM">Cameroon</option><option value="CA">Canada</option><option value="CV">Cape Verde</option><option value="KY">Cayman Islands</option><option value="CF">Central African Republic</option><option value="TD">Chad</option><option value="CL">Chile</option><option value="CN">China</option><option value="CX">Christmas Island</option><option value="CC">Cocos (Keeling) Islands</option><option value="CO">Colombia</option><option value="KM">Comoros</option><option value="CG">Congo</option><option value="CD">Congo, Democratic Republic</option><option value="CK">Cook Islands</option><option value="CR">Costa Rica</option><option value="CI">Cote D'Ivoire</option><option value="HR">Croatia</option><option value="CU">Cuba</option><option value="CY">Cyprus</option><option value="CZ">Czech Republic</option><option value="DK">Denmark</option><option value="DJ">Djibouti</option><option value="DM">Dominica</option><option value="DO">Dominican Republic</option><option value="EC">Ecuador</option><option value="EG">Egypt</option><option value="SV">El Salvador</option><option value="GQ">Equatorial Guinea</option><option value="ER">Eritrea</option><option value="EE">Estonia</option><option value="ET">Ethiopia</option><option value="FK">Falkland Islands (Malvinas)</option><option value="FO">Faroe Islands</option><option value="FJ">Fiji</option><option value="FI">Finland</option><option value="FR">France</option><option value="GF">French Guiana</option><option value="PF">French Polynesia</option><option value="TF">French Southern Territories</option><option value="GA">Gabon</option><option value="GM">Gambia</option><option value="GE">Georgia</option><option value="DE">Germany</option><option value="GH">Ghana</option><option value="GI">Gibraltar</option><option value="GR">Greece</option><option value="GL">Greenland</option><option value="GD">Grenada</option><option value="GP">Guadeloupe</option><option value="GU">Guam</option><option value="GT">Guatemala</option><option value="GG">Guernsey</option><option value="GN">Guinea</option><option value="GW">Guinea-Bissau</option><option value="GY">Guyana</option><option value="HT">Haiti</option><option value="HM">Heard Island &amp; Mcdonald Islands</option><option value="VA">Holy See (Vatican City State)</option><option value="HN">Honduras</option><option value="HK">Hong Kong</option><option value="HU">Hungary</option><option value="IS">Iceland</option><option value="IN">India</option><option value="ID">Indonesia</option><option value="IR">Iran, Islamic Republic Of</option><option value="IQ">Iraq</option><option value="IE">Ireland</option><option value="IM">Isle Of Man</option><option value="IL">Israel</option><option value="IT">Italy</option><option value="JM">Jamaica</option><option value="JP">Japan</option><option value="JE">Jersey</option><option value="JO">Jordan</option><option value="KZ">Kazakhstan</option><option value="KE">Kenya</option><option value="KI">Kiribati</option><option value="KR">Korea</option><option value="XK">Kosovo</option><option value="KW">Kuwait</option><option value="KG">Kyrgyzstan</option><option value="LA">Lao People's Democratic Republic</option><option value="LV">Latvia</option><option value="LB">Lebanon</option><option value="LS">Lesotho</option><option value="LR">Liberia</option><option value="LY">Libyan Arab Jamahiriya</option><option value="LI">Liechtenstein</option><option value="LT">Lithuania</option><option value="LU">Luxembourg</option><option value="MO">Macao</option><option value="MK">Macedonia</option><option value="MG">Madagascar</option><option value="MW">Malawi</option><option value="MY">Malaysia</option><option value="MV">Maldives</option><option value="ML">Mali</option><option value="MT">Malta</option><option value="MH">Marshall Islands</option><option value="MQ">Martinique</option><option value="MR">Mauritania</option><option value="MU">Mauritius</option><option value="YT">Mayotte</option><option value="MX">Mexico</option><option value="FM">Micronesia, Federated States Of</option><option value="MD">Moldova</option><option value="MC">Monaco</option><option value="MN">Mongolia</option><option value="ME">Montenegro</option><option value="MS">Montserrat</option><option value="MA">Morocco</option><option value="MZ">Mozambique</option><option value="MM">Myanmar</option><option value="NA">Namibia</option><option value="NR">Nauru</option><option value="NP">Nepal</option><option value="NL">Netherlands</option><option value="AN">Netherlands Antilles</option><option value="NC">New Caledonia</option><option value="NZ">New Zealand</option><option value="NI">Nicaragua</option><option value="NE">Niger</option><option value="NG">Nigeria</option><option value="NU">Niue</option><option value="NF">Norfolk Island</option><option value="MP">Northern Mariana Islands</option><option value="NO">Norway</option><option value="OM">Oman</option><option value="PK">Pakistan</option><option value="PW">Palau</option><option value="PS">Palestinian Territory, Occupied</option><option value="PA">Panama</option><option value="PG">Papua New Guinea</option><option value="PY">Paraguay</option><option value="PE">Peru</option><option value="PH">Philippines</option><option value="PN">Pitcairn</option><option value="PL">Poland</option><option value="PT">Portugal</option><option value="PR">Puerto Rico</option><option value="QA">Qatar</option><option value="RE">Reunion</option><option value="RO">Romania</option><option value="RU">Russian Federation</option><option value="RW">Rwanda</option><option value="BL">Saint Barthelemy</option><option value="SH">Saint Helena</option><option value="KN">Saint Kitts And Nevis</option><option value="LC">Saint Lucia</option><option value="MF">Saint Martin</option><option value="PM">Saint Pierre And Miquelon</option><option value="VC">Saint Vincent And Grenadines</option><option value="WS">Samoa</option><option value="SM">San Marino</option><option value="ST">Sao Tome And Principe</option><option value="SA">Saudi Arabia</option><option value="SN">Senegal</option><option value="RS">Serbia</option><option value="SC">Seychelles</option><option value="SL">Sierra Leone</option><option value="SG">Singapore</option><option value="SK">Slovakia</option><option value="SI">Slovenia</option><option value="SB">Solomon Islands</option><option value="SO">Somalia</option><option value="ZA">South Africa</option><option value="GS">South Georgia And Sandwich Isl.</option><option value="ES">Spain</option><option value="LK">Sri Lanka</option><option value="SD">Sudan</option><option value="SR">Suriname</option><option value="SJ">Svalbard And Jan Mayen</option><option value="SZ">Swaziland</option><option value="SE">Sweden</option><option value="CH">Switzerland</option><option value="SY">Syrian Arab Republic</option><option value="TW">Taiwan</option><option value="TJ">Tajikistan</option><option value="TZ">Tanzania</option><option value="TH">Thailand</option><option value="TL">Timor-Leste</option><option value="TG">Togo</option><option value="TK">Tokelau</option><option value="TO">Tonga</option><option value="TT">Trinidad And Tobago</option><option value="TN">Tunisia</option><option value="TR">Turkey</option><option value="TM">Turkmenistan</option><option value="TC">Turks And Caicos Islands</option><option value="TV">Tuvalu</option><option value="UG">Uganda</option><option value="UA">Ukraine</option><option value="AE">United Arab Emirates</option><option value="GB">United Kingdom</option><option value="US">United States</option><option value="UM">United States Outlying Islands</option><option value="UY">Uruguay</option><option value="UZ">Uzbekistan</option><option value="VU">Vanuatu</option><option value="VE">Venezuela</option><option value="VN">Viet Nam</option><option value="VG">Virgin Islands, British</option><option value="VI">Virgin Islands, U.S.</option><option value="WF">Wallis And Futuna</option><option value="EH">Western Sahara</option><option value="YE">Yemen</option><option value="ZM">Zambia</option><option value="ZW">Zimbabwe</option></select>
                                                </div>

                                                {if !$minregistration}
                                                    <div class="form-group  col-lg-12">
                                                        <label class="form-label">
                                                            {$lang.state}
                                                        </label>
                                                        <input type="hidden"  class="form-control reset-country"   name="state"    placeholder="State">
                                                        <select class="form-control no-chosen" name="state_code" onchange="getCity(this.value)" id="state_code"><option value="">Select State</option></select>
                                                    </div>
                                                    <div class="form-group  col-lg-6">
                                                        <label class="form-label">
                                                            {$lang.city}
                                                        </label>
                                                        <input type="hidden"  class="form-control reset-state"   name="city"    placeholder="City">
                                                        <input type="hidden"  class="form-control reset-state"   name="latitude"   >
                                                        <input type="hidden"  class="form-control reset-state"   name="longitude"  >
                                                        <select class="form-control no-chosen"  name="city_code"  onchange="selectCity()" id="city_code"><option value="">Select City</option></select>
                                                    </div>
                                                    <div class="form-group  col-lg-6">
                                                        <label class="form-label">
                                                            {$lang.zip}
                                                        </label>
                                                        {$zip}
                                                    </div>
                                                {/if}


                                            </div>


                                        {/if}

                                        {if $registrationtype eq 'checkout'}
                                            <input type="hidden" name="curriers" id="curriers" />
                                            <input type="hidden" name="retail" value="true" />
                                            <input type="hidden" name="registrationtype" value="checkout" />


                                            {if $shipping}
                                                <input type="hidden" name="shipping" value="1" />
                                                {*<div class="form-group ">
                                                    <div class="custom-control custom-checkbox">
                                                        <input type="checkbox" class="custom-control-input" onclick="showshipping(this.checked)" id="check-shippinginfo" checked name="shipping" value="1">
                                                        <label class="custom-control-label" for="check-shippinginfo"> <i class="fal fa-truck"></i> {$lang.shippinginfo}</label>
                                                    </div>

                                                </div>
                                                <div id="frmship" class="bg-light rounded p-4 mb-4 bottom-space" style="display:none;">
                                                    {call name=register}
                                                </div>

                                                <div class="form-group ">
                                                    <div class="custom-control custom-checkbox">
                                                        <input type="checkbox" class="custom-control-input"  id="check-gift" name="gift" value="1">
                                                        <label class="custom-control-label" for="check-gift"> <i class="fal fa-gift"></i> {$lang.thisgift}</label>
                                                    </div>
                                                </div>*}
                                            {/if}

                                        {/if}


                                    </div>

                                    <div class="d-actionbar-mobile">
                                        <div class="col mr-1">
                                            <button type="button" class="btn btn-secondary backward"> <i class="fal fa-arrow-left"></i> &nbsp;   {$lang.previous}
                                            </button>
                                        </div>
                                        <div class="col ml-1">
                                            <button type="button" class="btn btn-primary forward"
                                                    onclick="checkStep(this,'?validateregistration=1&step=2')"> {$lang.next} &nbsp; <i class="fal fa-arrow-right"></i>
                                            </button>
                                        </div>
                                    </div>

                                </section>


                                <section class="tab-pane " id="tab3">
                                    <div class="">
                                        <h5><span>{$lang.contactinfo}  </span></h5>
                                        <div class="position-relative" style="min-height: 300px">
                                            <div class="d-flex">
                                                {if $autoverifycredits}
                                                    <div class="form-group mr-2">
                                                        <label class="form-label">
                                                            {$lang.country} Code
                                                        </label>
                                                        {$phonenumber1}
                                                    </div>
                                                {/if}
                                                <div class="form-group col p-0">
                                                    <label class="form-label">
                                                        {$lang.mobile}
                                                    </label>
                                                    {$phonenumber}
                                                </div>
                                            </div>

                                            <div id="mobileverified-msg" style="display:none;">
                                                <span class="text-success">Mobile number is verified</span>
                                            </div>



                                            {if $autoverifycredits}
                                                <div class="">
                                                    <div  id="mobile-not-verified">
                                                        <div>
                                                            <div class="form-group ">
                                                                <label class="form-label">
                                                                    Send OTP on
                                                                </label>

                                                                <div class="border rounded px-3 py-3">
                                                                    <div class="custom-control custom-radio custom-control-inline">
                                                                        <input type="radio" id="customRadioInline1" checked
                                                                               name="verifyby" value="whatsapp"
                                                                               class="custom-control-input">
                                                                        <label class="custom-control-label"
                                                                               for="customRadioInline1">Whatsapp</label>
                                                                    </div>
                                                                    <div class="custom-control custom-radio custom-control-inline">
                                                                        <input type="radio" id="customRadioInline2"
                                                                               name="verifyby" value="call"
                                                                               class="custom-control-input">
                                                                        <label class="custom-control-label"
                                                                               for="customRadioInline2">Call</label>
                                                                    </div>
                                                                    <div class="custom-control custom-radio custom-control-inline">
                                                                        <input type="radio" id="customRadioInline3"
                                                                               name="verifyby" value="sms"
                                                                               class="custom-control-input">
                                                                        <label class="custom-control-label"
                                                                               for="customRadioInline3">SMS</label>
                                                                    </div>
                                                                </div>

                                                            </div>
                                                            <div>



                                                                <div  class="text-center" id="otp-input"  style="display: none">

                                                                    <div>
                                                                        <input type="hidden" class="form-control mr-0" id="otp"
                                                                               placeholder="OTP" name="otp">
                                                                        <div class="single-input">
                                                                            <input type="text" class="form-control"
                                                                                   minlength="1"
                                                                                   onkeypress="$('#otp2').select().focus()"
                                                                                   id="otp1" name="otp1">
                                                                            <input type="text" class="form-control"
                                                                                   minlength="1"
                                                                                   onkeypress="$('#otp3').select().focus()"
                                                                                   id="otp2" name="otp2">
                                                                            <input type="text" class="form-control"
                                                                                   minlength="1"
                                                                                   onkeypress="$('#otp4').select().focus()"
                                                                                   id="otp3" name="otp3">
                                                                            <input type="text" class="form-control"
                                                                                   minlength="1"
                                                                                   onblur="$('#otp').val($('#otp1').val()+$('#otp2').val()+$('#otp3').val()+$('#otp4').val());"
                                                                                   id="otp4" name="otp4">
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="text-center mb-2">
                                                                    <small id="otpcounter"  class="after-otp text-muted" style="display: none"></small>
                                                                    <span   class="before-otp cursor-pointer" style="display: none">
                                                                         <span class="text-primary"  onclick="javascript: SubmitForm('#verifyphone',urlprefix+'widget/save/register?actions=verifyphone','#registration','.alert-reg','true','#loader','',1,function(status,data){
                                                                         resendOTP(status,data);
                                                                    });" >Resend OTP</span>
                                                                    </span>
                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="d-actionbar-mobile">
                                                        <div class="col mr-1">
                                                            <button type="button" class="btn btn-secondary backward">
                                                                <i class="fal fa-arrow-left"></i> &nbsp;  {$lang.previous}
                                                            </button>
                                                        </div>
                                                        <div class="col ml-1"  id="before-valid-mobile">
                                                            <button type="button" class="btn btn-primary w-100"
                                                                    name="verifyphone" id="verifyphone"
                                                                    onclick="javascript: SubmitForm('#verifyphone',urlprefix+'widget/save/register?actions=verifyphone','#registration','.alert-reg','true','#loader','',1,function(status,data){
                                                                         resendOTP(status,data);
                                                                    });"
                                                                    value="Verify By">   Send OTP
                                                            </button>
                                                            <button style="display: none" class="btn btn-primary forward" type="button"
                                                                    name="verifyphone" id="verifynow"
                                                                    onclick="checkStep(this,'?actions=verifymyphone&step=3','verified')"
                                                                    value="Verify By">Verify Phone
                                                            </button>
                                                        </div>

                                                        <div  class="col  ml-1"  id="after-valid-mobile" style="display: none">
                                                            <button type="button" class="btn btn-primary forward"
                                                                    onclick="checkStep(this,'?validateregistration=1&step=3')">
                                                                {$lang.next}  &nbsp; <i class="fal fa-arrow-right"></i>
                                                            </button>
                                                        </div>

                                                    </div>
                                                </div>
                                            {else}

                                                <div class="d-actionbar-mobile">
                                                    <div class="col mr-1">
                                                        <button type="button" class="btn btn-secondary backward">
                                                            <i class="fal fa-arrow-left"></i> &nbsp;  {$lang.previous}
                                                        </button>
                                                    </div>

                                                    <div  class="col ml-1">
                                                        <button type="button" class="btn btn-primary forward"
                                                                onclick="checkStep(this,'?validateregistration=1&step=3')">
                                                            {$lang.next} &nbsp; <i class="fal fa-arrow-right"></i>
                                                        </button>
                                                    </div>

                                                </div>

                                            {/if}

                                        </div>




                                    </div>
                                </section>



                                <section class="tab-pane" id="tab4">
                                    <h5><span>{$lang.verificationcode}  </span></h5>

                                    <div class="form-row ">
                                        {if $customfields}
                                            {foreach from=$customfields key=names item=fields}
                                                <div class="form-group   col-md-12">
                                                    <label class="form-label">
                                                        {$names}
                                                    </label>
                                                    {$fields.input} {$fields.description}
                                                </div>
                                            {/foreach}
                                        {/if}
                                    </div>


                                    <div>



                                        {if $registration_type neq 3}



                                            <div>
                                                {if $terms}

                                                    <div class="custom-control custom-checkbox">
                                                        <input type="checkbox" class="custom-control-input" id="check-terms" name="terms" value="1">
                                                        <label class="custom-control-label" for="check-terms"> {$lang.ihaveread}   </label>
                                                        <a   href="{$toclink}?standalone=true" data-dismiss="modal" data-target="#modal-ajax"
                                                             data-size="modal-lg" data-toggle="modal"
                                                             data-whatever="Terms of Service"> {$lang.toc} </a>
                                                    </div>

                                                {/if}
                                            </div>


                                            {if $captcha}
                                                <div class="form-group mt-3 input-captcha">
                                                    {$captcha}
                                                </div>
                                            {/if}

                                        {/if}
                                    </div>

                                    <div class="d-actionbar-mobile">
                                        <div class="col mr-1">
                                            <button type="button" class="btn btn-secondary backward"> <i class="fal fa-arrow-left"></i> &nbsp;  {$lang.previous}
                                            </button>
                                        </div>
                                        <div class="col ml-1">
                                            <button type="button" class="btn btn-primary finished" id="btn-signup"
                                                    onClick="SubmitForm('#btn-signup','{$action_link}','#registration','.alert-reg','true','#loader','','',function(data) {
                                                            registrationCallback(data);
                                                            });" name="register" value="{$lang.signup}">
                                                {$lang.signup}
                                            </button>
                                        </div>
                                    </div>


                                </section>

                            </div>

                        </form>

                        <div>


                            {if ($allow_google   && $googleclientid) ||  $allow_yahoo || $allow_mygsm || $allow_facebook}
                                <div class="text-center">

                                    <h3 class="h3 or">
                                        <span class="text-muted">{$lang.or}</span>
                                    </h3>


                                    <div class="d-flex justify-content-center">
                                        {if $allow_google  && $googleclientid}
                                            <a href="/loginoption?action=googlep"
                                               class="text-white rounded   px-3 py-1 ml-3 d-flex align-items-center justify-content-between"
                                               style="background: #DB5041;">
                                                {$lang.signup} {$lang.with} &nbsp; &nbsp; &nbsp; <i
                                                        class="fab fa-google"></i>
                                            </a>
                                        {/if}
                                        {if $allow_yahoo}
                                            <a href="/loginoption?action=yahoo"
                                               class="text-white rounded  px-3 py-1 ml-3 d-flex align-items-center justify-content-between"
                                               style="background: #5009AB;">
                                                {$lang.signup} {$lang.with} &nbsp; &nbsp; &nbsp; <i
                                                        class="fab fa-yahoo"></i>
                                            </a>
                                        {/if}
                                        {if $allow_mygsm}
                                            <a href="/loginoption?action=mygsmid"
                                               class="text-white bg-dark rounded   px-3 py-1 ml-3 d-flex align-items-center justify-content-between">
                                                {$lang.signup} {$lang.with} My GSM
                                            </a>
                                        {/if}

                                        {if $allow_facebook}
                                            <a href="/loginoption?action=facebook"
                                               class="text-white rounded   px-3 py-1 ml-3 d-flex align-items-center justify-content-between"
                                               style="background: #3F5791;">
                                                {$lang.signup} {$lang.with} &nbsp; &nbsp; &nbsp; <i
                                                        class="fab fa-facebook"></i>
                                            </a>
                                        {/if}

                                    </div>
                                </div>
                            {/if}
                        </div>

                    </div>
                        {/if}
                    {/if}
                </div>
            </div>
        </div>
    </div>


    <script src="templates/default/js/address.js"></script>

    {literal}
    <script>

        var mobileverified = false;
        var timer;

        var state,password,passwordStrength,lowUpperCase,number,specialChar,eightChar;


        function resendOTP(status,data) {



            if(status === 'showdiv') {
                $(".before-otp,#verifyphone").hide();
                $(".after-otp,#verifynow,#otp-input").show();
                $("input[name='phonenumber']").attr('readonly', true);
                var count = 60;
                timer = setInterval(function () {
                    $("#otpcounter").html("Resend OTP after : " + (count--));
                    if (count == 1) {
                        clearInterval(timer);
                    }
                }, 1000);

                setTimeout(function () {
                    $(".before-otp").show();
                    $(".after-otp").hide();
                    $("input[name='phonenumber']").attr('readonly', false);
                }, 60000);
            }

        }

        $(document).ready(function () {


            $("[data-toggle=popover]").on('shown.bs.popover', function () {

                state = false;
                password = document.getElementById("password");
                passwordStrength = document.getElementById("password-strength");
                lowUpperCase = document.querySelector(".low-upper-case i");
                number = document.querySelector(".one-number i");
                specialChar = document.querySelector(".one-special-char i");
                eightChar = document.querySelector(".eight-character i");

                password.addEventListener("keyup", function(){
                    let pass = document.getElementById("password").value;
                    checkStrength(pass);
                });

            });


            $("#phonenumber1").val({/literal}{$phonecode}{literal});
            $('.after-load-chosen').chosen();
            //$('#registrationTab li:first-child a').tab('show');
            //$('#registrationTab li a#tab2-tab').tab('show');

            $('#registrationTab a').on('click', function (e) {
                e.preventDefault()
                return false;
            });

        });

        $('.backward').click(function () {
            var no = $('.nav-wizard li.checked').length;
            $('#tab' + no + '-tab').parent('li').removeClass('checked');
            no = no - 1;
            $('#tab' + no + '-tab').tab('show');
            $('#wizard-title').text($('.tab-pane.active h5').text());
        })


        function checkStep(btn, action,step) {
            var no = $('.nav-wizard li.checked').length;
            SubmitForm(btn, urlprefix+"widget/save/register" + action, '#registration', '.alert-reg', 'true', '#loader', true, '', function (data) {
                if (data !== 'error') {
                    no = no + 1;
                    $('#tab' + no + '-tab').parent('li').addClass('checked').children('a').tab('show');
                    $('#wizard-title').text($('.tab-pane.active h5').text());

                    if(step === 'verified'){
                        mobileverified = true;
                    }

                    if(mobileverified){
                        $("input[name='phonenumber']").attr('readonly', true);
                        $('select[name="phonenumber1"]').prop('disabled', true).trigger("chosen:updated");
                        $('#before-valid-mobile').hide();
                        $('#after-valid-mobile').show();
                        $('#mobileverified-msg').show();
                        $('#mobile-not-verified').hide();
                        clearInterval(timer);
                    }
                }
            });
        }

        function registrationCallback(data) {
            if (data === 'success') {
                $('.registration-steps').hide();
            }
        }









        function toggle(){
            if(state){
                document.getElementById("password").setAttribute("type","password");
                state = false;
            }else{
                document.getElementById("password").setAttribute("type","text")
                state = true;
            }
        }

        function myFunction(show){
            show.classList.toggle("fa-eye-slash");
        }

        function checkStrength(password) {
            let strength = 0;

            //If password contains both lower and uppercase characters
            if (password.match(/([a-z].*[A-Z])|([A-Z].*[a-z])/)) {
                strength += 1;
                lowUpperCase.classList.remove('fa-circle');
                lowUpperCase.classList.add('fa-check');
            } else {
                lowUpperCase.classList.add('fa-circle');
                lowUpperCase.classList.remove('fa-check');
            }
            //If it has numbers and characters
            if (password.match(/([0-9])/)) {
                strength += 1;
                number.classList.remove('fa-circle');
                number.classList.add('fa-check');
            } else {
                number.classList.add('fa-circle');
                number.classList.remove('fa-check');
            }
            //If it has one special character
            if (password.match(/([!,%,&,@,#,$,^,*,?,_,~])/)) {
                strength += 1;
                specialChar.classList.remove('fa-circle');
                specialChar.classList.add('fa-check');
            } else {
                specialChar.classList.add('fa-circle');
                specialChar.classList.remove('fa-check');
            }
            //If password is greater than 7
            if (password.length > 7) {
                strength += 1;
                eightChar.classList.remove('fa-circle');
                eightChar.classList.add('fa-check');
            } else {
                eightChar.classList.add('fa-circle');
                eightChar.classList.remove('fa-check');
            }

            // If value is less than 2
            if (strength < 2) {
                passwordStrength.classList.remove('progress-bar-warning');
                passwordStrength.classList.remove('progress-bar-success');
                passwordStrength.classList.add('progress-bar-danger');
                passwordStrength.style = 'width: 10%';
            } else if (strength == 3) {
                passwordStrength.classList.remove('progress-bar-success');
                passwordStrength.classList.remove('progress-bar-danger');
                passwordStrength.classList.add('progress-bar-warning');
                passwordStrength.style = 'width: 60%';
            } else if (strength == 4) {
                passwordStrength.classList.remove('progress-bar-warning');
                passwordStrength.classList.remove('progress-bar-danger');
                passwordStrength.classList.add('progress-bar-success');
                passwordStrength.style = 'width: 100%';
            }
        }




        //phonecode
    </script>

    <style>
        .single-input {
            display: flex;
            justify-content: center;
            margin-bottom: 10px;
        }

        .single-input .form-control {
            width: 100%;
            text-align: center;
            font-size: 30px;
            margin: 3px;
        }


        .forward, .backward, .finished {
            width: 100%;
        }
        .backward{
            margin-right: 0.5rem;
        }
        .show-pass{
            position: absolute;
            top: 10px;
            right: 10px;
        }
    </style>
    {/literal}


    </div></div>




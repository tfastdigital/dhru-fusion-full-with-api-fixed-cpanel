

<div class="container"><div class="page-container">


    <div class="card">

        <div class="row">
            <div class="col-lg-12">

                <div>


                    <ul class="nav nav-pills  flex-nowrap mb-4 bottom-space">
                        <li class="nav-item ">
                            <a class="nav-link  active" data-toggle="tab" href="#profile">{$lang.editprofile} </a>
                        </li>
                        <li class="nav-item "
                            onclick="getContect('#tab','{$actionpasswordlink}?standalone=true','#changepassword',true,'#loader',true);">
                            <a class="nav-link" data-toggle="tab" href="#changepassword">{$lang.changepassword}</a>
                        </li>
                        <li class="nav-item "
                            onclick="getContect('#tab','{$actionpinlink}?standalone=true','#masterpin',true,'#loader',true);">
                            <a class="nav-link" data-toggle="tab" href="#masterpin">{$lang.masterpin}</a>
                        </li>
                        <li class="nav-item "
                            onclick="getContect('#tab','{$actionloginlink}?standalone=true','#logins',true,'#loader',true);">
                            <a class="nav-link" data-toggle="tab" href="#logins">{$lang.loginsecur}</a>
                        </li>
                        <li class="nav-item "
                            onclick="getContect('#tab','{$secondauthlink}?standalone=true','#step2varification',true,'#loader',true);">
                            <a class="nav-link" data-toggle="tab" id="stepverification"
                               href="#step2varification">{$lang.2stepverif} </a>
                        </li>
                    </ul>


                    <div class="tab-content">
                        <div class="tab-pane   fade" id="changepassword" role="tabpanel"
                             aria-labelledby="changepassword"></div>
                        <div class="tab-pane   fade" id="masterpin" role="tabpanel"
                             aria-labelledby="masterpin"></div>
                        <div class="tab-pane   fade" id="logins" role="tabpanel" aria-labelledby="logins"></div>
                        <div class="tab-pane   fade show active" id="profile" role="tabpanel"
                             aria-labelledby="home-tab">
                            <div class="p-3">
                                <form method="post" name="editprofile" id="editprofile" enctype="multipart/form-data">
                                    <div  class="alert alert-profile"></div>
                                    {$token}
                                    <div class="row">
                                        <div class="col-lg-6">

                                            <div class="">

                                                <div class="form-row ">
                                                    <div class="form-group   col-lg-12">
                                                       <div> <div class="text-muted font-normal">{$lang.username} </div>  {$username}  </div>
                                                        <div class="my-3"> <div class="text-muted font-normal"> {$lang.email} </div> {$email}  </div>
                                                        <div>   <div class="text-muted font-normal"> {$lang.avtar} </div> <a href="http://en.gravatar.com/"
                                                                           target="_blank">{$lang.uploadfrom}
                                                                gravatar.com </a> </div>
                                                    </div>

                                                    <div class="form-group   col-lg-6">
                                                        <label class="form-label"> {$lang.firstname} </label> {$first_name}

                                                    </div>

                                                    <div class="form-group   col-lg-6">
                                                        <label class="form-label"> {$lang.lastname}   </label>   {$last_name}
                                                    </div>

                                                </div>


                                                <div class="form-row ">

                                                    <div class="form-group mb-0 col-lg-6 col-md-12">
                                                        <label class="form-label"> {$lang.contactno} </label>
                                                        <div class="input-group mb-4 bottom-space">
                                                            {$phonenumber}
                                                            <div class="input-group-append">
                                                                <input {if $smsgateway && $verified eq 0}disabled{/if} type="submit" id="saveprofiles" class="btn btn-secondary"
                                                                       onClick="SubmitForm('#saveprofiles','{$sms_link}','#editprofile','.alert','true','#loader',true);"
                                                                       name="send" value="{$lang.send} {$lang.code}"/>
                                                            </div>
                                                        </div>
                                                    </div>


                                                    {if $verified eq 0    && $smsgateway}
                                                        <div class="form-group m-0 col-lg-6  col-md-12">
                                                            <label class="form-label"> {$lang.mobverificode} </label>
                                                            <div class="input-group mb-4 bottom-space">
                                                                {$applycode}
                                                                <div class="input-group-append">
                                                                    <input type="submit" class="btn btn-secondary" id="verify"
                                                                           onClick="SubmitForm('#verify','{$verify_link}','#editprofile','.alert','true','#loader',true);"
                                                                           name="ver" value="{$lang.apply}"/>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    {/if}


                                                </div>





                                                <div class="form-row ">
                                                    <div class="form-group m-0 col-lg-5  col-md-12">
                                                        <label class="form-label"> {$lang.minimum} {$lang.balance} {$lang.reminder} </label>
                                                        <div class='input-group mb-4 bottom-space'> {$creditlimit}</div>
                                                    </div>
                                                </div>


                                                <div class="form-row ">
                                                    <div class="form-group   col-lg-6  col-md-12">
                                                        <label class="form-label"> {$lang.language} </label>
                                                        {$language} </div>
                                                </div>


                                                <div class="form-row mt-2">
                                                    <div class="form-group  col-lg-12">
                                                        <div class="form-check checkbox">
                                                            <label class="form-check-label" for="news_letter">
                                                                {$news_letter}
                                                                <i class="helper" style="top: 4px;"></i>
                                                                {$lang.subscribefornewsletter}
                                                            </label>
                                                        </div>
                                                        <div><a href="{$actionmailnotification}">*{$lang.moreemailsettings}</a>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>


                                        <div class="col-lg-6">


                                            <div class="ml-lg-3">


                                                <div class="form-row "> {if $customfields}
                                                        {foreach from=$customfields key=name item=fields}
                                                            <div class="form-group    col-lg-6">
                                                                <label class="form-label"> {$name}: </label>
                                                                {$fields.input} </div>
                                                        {/foreach}
                                                    {/if} </div>




                                                <div class="form-row ">
                                                    <div class="form-group   col-lg-12">
                                                        <label class="form-label"> {$lang.address} 1 </label>
                                                        {$address1} </div>
                                                </div>
                                                <div class="form-row ">
                                                    <div class="form-group   col-lg-12">
                                                        <label class="form-label"> {$lang.address} 2 </label>
                                                        {$address2} </div>
                                                </div>

                                                <div class="form-row">
                                                    <div class="form-group   col-lg-6">
                                                        <label class="form-label"> {$lang.country} </label>
                                                        <input type="hidden"  class="form-control"   name="country"  value="">
                                                        <select class="form-control no-chosen" id="country_code" onchange="getState()" name="country_code"><option value="">Select</option><option value="AF">Afghanistan</option><option value="AX">Aland Islands</option><option value="AL">Albania</option><option value="DZ">Algeria</option><option value="AS">American Samoa</option><option value="AD">Andorra</option><option value="AO">Angola</option><option value="AI">Anguilla</option><option value="AQ">Antarctica</option><option value="AG">Antigua And Barbuda</option><option value="AR">Argentina</option><option value="AM">Armenia</option><option value="AW">Aruba</option><option value="AU">Australia</option><option value="AT">Austria</option><option value="AZ">Azerbaijan</option><option value="BS">Bahamas</option><option value="BH">Bahrain</option><option value="BD">Bangladesh</option><option value="BB">Barbados</option><option value="BY">Belarus</option><option value="BE">Belgium</option><option value="BZ">Belize</option><option value="BJ">Benin</option><option value="BM">Bermuda</option><option value="BT">Bhutan</option><option value="BO">Bolivia</option><option value="BA">Bosnia And Herzegovina</option><option value="BW">Botswana</option><option value="BV">Bouvet Island</option><option value="BR">Brazil</option><option value="IO">British Indian Ocean Territory</option><option value="BN">Brunei Darussalam</option><option value="BG">Bulgaria</option><option value="BF">Burkina Faso</option><option value="BI">Burundi</option><option value="KH">Cambodia</option><option value="CM">Cameroon</option><option value="CA">Canada</option><option value="CV">Cape Verde</option><option value="KY">Cayman Islands</option><option value="CF">Central African Republic</option><option value="TD">Chad</option><option value="CL">Chile</option><option value="CN">China</option><option value="CX">Christmas Island</option><option value="CC">Cocos (Keeling) Islands</option><option value="CO">Colombia</option><option value="KM">Comoros</option><option value="CG">Congo</option><option value="CD">Congo, Democratic Republic</option><option value="CK">Cook Islands</option><option value="CR">Costa Rica</option><option value="CI">Cote D'Ivoire</option><option value="HR">Croatia</option><option value="CU">Cuba</option><option value="CY">Cyprus</option><option value="CZ">Czech Republic</option><option value="DK">Denmark</option><option value="DJ">Djibouti</option><option value="DM">Dominica</option><option value="DO">Dominican Republic</option><option value="EC">Ecuador</option><option value="EG">Egypt</option><option value="SV">El Salvador</option><option value="GQ">Equatorial Guinea</option><option value="ER">Eritrea</option><option value="EE">Estonia</option><option value="ET">Ethiopia</option><option value="FK">Falkland Islands (Malvinas)</option><option value="FO">Faroe Islands</option><option value="FJ">Fiji</option><option value="FI">Finland</option><option value="FR">France</option><option value="GF">French Guiana</option><option value="PF">French Polynesia</option><option value="TF">French Southern Territories</option><option value="GA">Gabon</option><option value="GM">Gambia</option><option value="GE">Georgia</option><option value="DE">Germany</option><option value="GH">Ghana</option><option value="GI">Gibraltar</option><option value="GR">Greece</option><option value="GL">Greenland</option><option value="GD">Grenada</option><option value="GP">Guadeloupe</option><option value="GU">Guam</option><option value="GT">Guatemala</option><option value="GG">Guernsey</option><option value="GN">Guinea</option><option value="GW">Guinea-Bissau</option><option value="GY">Guyana</option><option value="HT">Haiti</option><option value="HM">Heard Island &amp; Mcdonald Islands</option><option value="VA">Holy See (Vatican City State)</option><option value="HN">Honduras</option><option value="HK">Hong Kong</option><option value="HU">Hungary</option><option value="IS">Iceland</option><option value="IN">India</option><option value="ID">Indonesia</option><option value="IR">Iran, Islamic Republic Of</option><option value="IQ">Iraq</option><option value="IE">Ireland</option><option value="IM">Isle Of Man</option><option value="IL">Israel</option><option value="IT">Italy</option><option value="JM">Jamaica</option><option value="JP">Japan</option><option value="JE">Jersey</option><option value="JO">Jordan</option><option value="KZ">Kazakhstan</option><option value="KE">Kenya</option><option value="KI">Kiribati</option><option value="KR">Korea</option><option value="XK">Kosovo</option><option value="KW">Kuwait</option><option value="KG">Kyrgyzstan</option><option value="LA">Lao People's Democratic Republic</option><option value="LV">Latvia</option><option value="LB">Lebanon</option><option value="LS">Lesotho</option><option value="LR">Liberia</option><option value="LY">Libyan Arab Jamahiriya</option><option value="LI">Liechtenstein</option><option value="LT">Lithuania</option><option value="LU">Luxembourg</option><option value="MO">Macao</option><option value="MK">Macedonia</option><option value="MG">Madagascar</option><option value="MW">Malawi</option><option value="MY">Malaysia</option><option value="MV">Maldives</option><option value="ML">Mali</option><option value="MT">Malta</option><option value="MH">Marshall Islands</option><option value="MQ">Martinique</option><option value="MR">Mauritania</option><option value="MU">Mauritius</option><option value="YT">Mayotte</option><option value="MX">Mexico</option><option value="FM">Micronesia, Federated States Of</option><option value="MD">Moldova</option><option value="MC">Monaco</option><option value="MN">Mongolia</option><option value="ME">Montenegro</option><option value="MS">Montserrat</option><option value="MA">Morocco</option><option value="MZ">Mozambique</option><option value="MM">Myanmar</option><option value="NA">Namibia</option><option value="NR">Nauru</option><option value="NP">Nepal</option><option value="NL">Netherlands</option><option value="AN">Netherlands Antilles</option><option value="NC">New Caledonia</option><option value="NZ">New Zealand</option><option value="NI">Nicaragua</option><option value="NE">Niger</option><option value="NG">Nigeria</option><option value="NU">Niue</option><option value="NF">Norfolk Island</option><option value="MP">Northern Mariana Islands</option><option value="NO">Norway</option><option value="OM">Oman</option><option value="PK">Pakistan</option><option value="PW">Palau</option><option value="PS">Palestinian Territory, Occupied</option><option value="PA">Panama</option><option value="PG">Papua New Guinea</option><option value="PY">Paraguay</option><option value="PE">Peru</option><option value="PH">Philippines</option><option value="PN">Pitcairn</option><option value="PL">Poland</option><option value="PT">Portugal</option><option value="PR">Puerto Rico</option><option value="QA">Qatar</option><option value="RE">Reunion</option><option value="RO">Romania</option><option value="RU">Russian Federation</option><option value="RW">Rwanda</option><option value="BL">Saint Barthelemy</option><option value="SH">Saint Helena</option><option value="KN">Saint Kitts And Nevis</option><option value="LC">Saint Lucia</option><option value="MF">Saint Martin</option><option value="PM">Saint Pierre And Miquelon</option><option value="VC">Saint Vincent And Grenadines</option><option value="WS">Samoa</option><option value="SM">San Marino</option><option value="ST">Sao Tome And Principe</option><option value="SA">Saudi Arabia</option><option value="SN">Senegal</option><option value="RS">Serbia</option><option value="SC">Seychelles</option><option value="SL">Sierra Leone</option><option value="SG">Singapore</option><option value="SK">Slovakia</option><option value="SI">Slovenia</option><option value="SB">Solomon Islands</option><option value="SO">Somalia</option><option value="ZA">South Africa</option><option value="GS">South Georgia And Sandwich Isl.</option><option value="ES">Spain</option><option value="LK">Sri Lanka</option><option value="SD">Sudan</option><option value="SR">Suriname</option><option value="SJ">Svalbard And Jan Mayen</option><option value="SZ">Swaziland</option><option value="SE">Sweden</option><option value="CH">Switzerland</option><option value="SY">Syrian Arab Republic</option><option value="TW">Taiwan</option><option value="TJ">Tajikistan</option><option value="TZ">Tanzania</option><option value="TH">Thailand</option><option value="TL">Timor-Leste</option><option value="TG">Togo</option><option value="TK">Tokelau</option><option value="TO">Tonga</option><option value="TT">Trinidad And Tobago</option><option value="TN">Tunisia</option><option value="TR">Turkey</option><option value="TM">Turkmenistan</option><option value="TC">Turks And Caicos Islands</option><option value="TV">Tuvalu</option><option value="UG">Uganda</option><option value="UA">Ukraine</option><option value="AE">United Arab Emirates</option><option value="GB">United Kingdom</option><option value="US">United States</option><option value="UM">United States Outlying Islands</option><option value="UY">Uruguay</option><option value="UZ">Uzbekistan</option><option value="VU">Vanuatu</option><option value="VE">Venezuela</option><option value="VN">Viet Nam</option><option value="VG">Virgin Islands, British</option><option value="VI">Virgin Islands, U.S.</option><option value="WF">Wallis And Futuna</option><option value="EH">Western Sahara</option><option value="YE">Yemen</option><option value="ZM">Zambia</option><option value="ZW">Zimbabwe</option></select>
                                                    </div>

                                                    <div class="form-group   col-lg-6">
                                                        <label class="form-label"> {$lang.state} </label>
                                                        <input type="hidden"  class="form-control reset-country"   name="state"    placeholder="State">
                                                        <select class="form-control no-chosen" name="state_code" onchange="getCity(this.value)" id="state_code"><option value="">Select State</option></select>
                                                    </div>

                                                </div>

                                                <div class="form-row ">
                                                    <div class="form-group   col-lg-6">
                                                        <label class="form-label"> {$lang.city} </label>
                                                        <input type="hidden"  class="form-control reset-state"   name="city"    placeholder="City">
                                                        <input type="hidden"  class="form-control reset-state"   name="latitude"   >
                                                        <input type="hidden"  class="form-control reset-state"   name="longitude"  >
                                                        <select class="form-control no-chosen"  name="city_code"  onchange="selectCity()" id="city_code"><option value="">Select City</option></select>
                                                    </div>
                                                    <div class="form-group   col-lg-6">
                                                        <label class="form-label"> {$lang.zip} </label>
                                                        <div> {$zip} </div>
                                                    </div>

                                                </div>

                                            </div>
                                        </div>





                                    </div>
                                    <div class="d-flex justify-content-between">

                                        <div class="d-actionbar-mobile   w-100">
                                            <div class="w-100 w-lg-auto">
                                                <button type="button" class="btn btn-primary"
                                                    id="saveprofile"
                                                    onClick="SubmitForm('#saveprofile','{$action_link}','#editprofile','.alert-profile','true','#loader',true);"
                                                    name="saveprofile" value="{$lang.save}">    {$lang.save} </button>
                                            </div>

                                            <div class="d-lg-flex  mr-3 ml-auto d-none">
                                                {if $userdetails.messengerid}
                                                    <button class="btn btn-primary" value="1" type="submit"
                                                            name="remtelegram">
                                                        <i class="fas fa-paper-plane"></i> &nbsp;
                                                        {$lang.remove} Telegram
                                                    </button>
                                                {/if}
                                                <div class="text-right">
                                                    <a class="text-danger no-wrap"
                                                       href="{$actioncloseac}"><i class="fal fa-trash"></i> &nbsp; {$lang.close} {$lang.account}</a>
                                                </div>
                                            </div>

                                        </div>

                                        {if $tmppass and $resellerstore}
                                            {$btn}
                                            {if $password}
                                                <br/>
                                                {$lang.temporary} {$lang.password}:{$password}
                                            {/if}
                                        {/if}

                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="tab-pane    fade" id="step2varification" role="tabpanel"
                             aria-labelledby="step2varification"></div>
                    </div>


                </div>
            </div>
        </div>
    </div>

    </div></div>

<script src="templates/default/js/address.js"></script>

{literal}
    <script>
        address = {/literal}{$defaultaddress}{literal};
        $.each(address, function (key, value) {
            $('#editprofile [name="' + key + '"]').val(value);
        });
        getState('setaddress');
    </script>
{/literal}

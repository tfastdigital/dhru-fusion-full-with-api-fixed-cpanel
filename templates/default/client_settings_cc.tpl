{literal}
    <script src="includes/js/ccvalidate.js" type="text/javascript"></script>
    <script type="text/javascript">
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

        function setImage(img) {
            $('.cc-image').attr('src', 'templates/default/images/' + img + '.png');
        }
    </script>
{/literal}

<div class="container"><div class="page-container">

    <div class="card">

        <div class="row">
            <div class="col-lg-4">

                <form method="post" name="api" id="api">
                    {if $notification}
                        <div   class="alert1 alert {$class}">
                            {$msg}
                        </div>
                    {else}
                        <div  class="alert"> </div>
                    {/if}
                    {$token}

                    {if $cardlastfours}
                        <div class="form-group ">
                            <label>
                                Current Card
                            </label>
                            XXXXXXXXX{$cardlastfours} -
                            <a class=""
                               href="settings.php?action=ccard&remove=true">
                                {$lang.remove}
                            </a>

                        </div>
                    {/if}

                    <div class="form-group ">
                        <label>
                            {$lang.card} {$lang.type}
                        </label>

                        <select name="cardtype" id="cardtype " class="cc-ddl-type form-control "
                                onchange="setImage(this.value);">
                            {foreach from=$ccarr item=cc key=id}
                                <option value="{$id}">{$cc}</option>
                            {/foreach}
                        </select>

                    </div>

                    <div class="form-group ">
                        <label>
                            {$lang.card} {$lang.number}
                        </label>

                        <input type="text" id="ccno" name="cardno" class="cc-card-number form-control " value=""/>

                    </div>
                    <div class="form-group ">
                        <label>
                            {$lang.card}{$lang.holder} {$lang.name}
                        </label>

                        <input type="text" class="form-control " name="cardname" value=""/>

                    </div>

                    <div class="form-group ">

                        <div class="row">
                            <div class="col">
                                <label>
                                    {$lang.expiry} {$lang.date}
                                </label>
                                <select onchange="javascript: checkp( $('#ccno').val(), $('#cardtype').val());"
                                        name="endmonth" id="cc-month" class="form-control ">
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
                            <div class="col">
                                <label> <br/> </label>
                                <select name="endyear"
                                        onchange="javascript: checkp( $('#ccno').val(), $('#cardtype').val());"
                                        id="Select1" class="form-control ">
                                    {section name=foo start=$exps loop=$expe step=1}
                                        <option value="{$smarty.section.foo.index}">{$smarty.section.foo.index}</option>
                                    {/section}
                                </select>
                            </div>

                            <div class="col">
                                <label>
                                    CCV
                                </label>
                                <input onkeyup="javascript: checkp( $('#ccno').val(), $('#cardtype').val());"
                                       type="text" name="ccv" size="3" value="" class="form-control "/>

                            </div>
                        </div>
                    </div>


                    <div class="d-actionbar-mobile">
                        <button type="submit" id="save"
                                onclick="SubmitForm('#save','{$actionlink}','#api','.alert','true','#loader',true);"
                                class="btn btn-primary w-100" name="save" value="{$lang.save}">
                            {$lang.save}
                        </button>

                    </div>
                </form>
            </div>
        </div>

    </div>
</div>
</div>

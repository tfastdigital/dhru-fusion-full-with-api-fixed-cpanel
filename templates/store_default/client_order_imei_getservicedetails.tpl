

	{literal}

    	<script>
            $(document).ready(function(){
                var maxo=parseInt(parseFloat($('#ccredit').text())/parseFloat(Math.round( $('#ocredit').text()*100 )/100 ).toString());
                if(!maxo){
                    maxo=0;
                }
                $('#maxo').text('You can order max. '+maxo+' of {/literal} {if $imeiservice.reqredfield.imei_custom_info} {$imeiservice.reqredfield.imei_custom_info} {else} IMEI {/if} {literal} service');

            	/*$("#imei_bulk").bind({
                	paste : function(){
                		cntr();
                	},
                	cut : function(){
                		cntr();
                	}
            	});*/
                //$('select:not(.no-chosen)').chosen();
            });


           function setprogressbar() {
               var balance = parseInt($('#ccredit').text());
               var credit = parseInt($('#ctotal').text());

               var percentage = parseInt((credit * 100) / balance);
               var template = '<div class="progress-bar bg-danger" role="progressbar" aria-valuenow="'+percentage+'" style="width: '+percentage+'%" aria-valuemin="0" aria-valuemax="100"></div>';
               $('#progress').html(template);
           }



            $(document).ready(function () {
                var qntrange = {/literal}{if $imeiservice.qntrangejson}{$imeiservice.qntrangejson}{else}''{/if}{literal};


                    var keys = Object.keys(qntrange);
                    $('#qnt').keyup(function () {
                        cntr2(this.value);
                    });
                    $('#qnt').change(function () {
                        cntr2(this.value);
                    });

                function cntr2(value){

                    if(qntrange) {
                        var firnalprice = qntrange[0].price;
                        for (var i = 0; i < keys.length; i++) {
                            if (qntrange[keys[i]].end != '') {
                                if ((parseInt(value) > parseInt(qntrange[keys[i]].start) && parseInt(value) < parseInt(qntrange[keys[i]].end)) || parseInt(value) == parseInt(qntrange[keys[i]].start) || parseInt(value) == parseInt(qntrange[keys[i]].end)) {
                                    firnalprice = qntrange[keys[i]].price;
                                }
                            }
                        }
                    }
                    else{
                        var firnalprice = {/literal}{$imeiservice.credit}{literal};
                    }
                    if($('#qnt').val()) {
                        $('#ctotal').text(parseFloat(firnalprice * parseInt($('#qnt').val())).toFixed(2));
                    }
                    else{
                        $('#ctotal').text(parseFloat(firnalprice).toFixed(2));
                    }
                }

            })

            function afterplaceorder(data) {
               if(data[3]) {
                   let reply = JSON.parse(atob(data[3]));
                   console.log(reply);
                   let r;
                   var html = '<table class="table mt-4 table-striped"><thead><tr><th>Status</th><th>IMEI</th><th>Reply</th></tr></thead>';
                   for (r in reply) {
                       html += '<tr><td>' + reply[r].status + '</td> <td>' + reply[r].imei + '</td> <td>' + reply[r].info + '</td>  </tr>';
                   }
                   html += '<table>';
                   $('#replyjson').html(html);
               }
            }


</script>

	{/literal}


 {if !$direct}
     {literal}
        	<script>

                $(document).ready(function(){

                    var maxo=parseInt(parseFloat($('#ccredit').text())/parseFloat(Math.round( $('#ocredit').text()*100 )/100 ).toString());
                    $('#imei_bulk').attr({'maxlength':maxo*16});
                    $('#maxo').text('You can order max. '+maxo+' of {/literal} {if $imeiservice.reqredfield.imei_custom_info} {$imeiservice.reqredfield.imei_custom_info} {else} IMEI {/if} {literal} service');
                    $('#IMEI_ADD').click(function(){
                        cntr();
                    });

                   $('#imei_bulk').keyup(function(e){
                        if(e.which==13 || e.which==8){
                            cntr();
                        }
                   });

                   var mo='';
                   function cntr(){
                        var codes=$('#imei_bulk').val().split(/\n/);
                        $('#ccnt').text(codes.length);
                        if(codes.length>0){
                            var tt=(parseFloat( $('#ocredit').text()*(codes.length) ).toString());
                        }
                        else{
                              var tt=(parseFloat( $('#ocredit').text() ).toString());
                        }

                        if(parseFloat($('#ccredit').text())){
                            if(parseFloat($('#ccredit').text())>=tt){
                                //$('#mult').show();
                                $('#ctotal').text(tt);
                                mo=$('#imei_bulk').val();
                                setprogressbar();
                            }
                            else{
                                alert('You have not enough balance');
                                $('#imei_bulk').val(mo);
                            }
                        }
                   }
                });
        </script>
     {/literal}
{/if}


{if !$min}
        {if $cart}
       <div class="m-0 mb-sm-3 mb-4 bottom-space">  <h2 class="page-title inner-page-title">    {$imeiservice.service_name}</h2> </div>
        {/if}
        {if $imeiservice.sku}
            <div class="text-muted"> #{$imeiservice.sku}</div>
        {/if}
{/if}

<div class="position-fixed bg-white p-5 active  w-100 text-center align-items-center" id="custom-alert" style="z-index: 99999;top: 0px;left: 0px;bottom: 0;display: none">

  <div class="sa-icon   animate">
    <span class="sa-line sa-tip animateSuccessTip"></span>
    <span class="sa-line sa-long animateSuccessLong"></span>
    <div class="sa-placeholder"></div>
    <div class="sa-fix"></div>
  </div>


        <div class="alert col-lg-5 mx-auto alert-success d-block" id="custom-alert-msg"></div>
    {$lang.continuetoplace}? <a class="btn" onclick="$('#custom-alert').hide()"> {$lang.clickhere}  </a>


    <div id="replyjson" class="m-auto"> </div>


    <div class="position-relative  mt-5 mx-auto">

    </div>


    {if $imeiservice.useasserver eq 1}
        <a class="btn p-3 btn-warning" href="{$serverorderhistorylink}">{$lang.view} {$lang.server} {$lang.order} {$lang.history} </a>
    {elseif $imeiservice.useasserver eq 2}
        <a class="btn p-3 btn-warning" href="{$remoteorderhistorylink}">{$lang.view} {$lang.remote} {$lang.order} {$lang.history} </a>
    {else}
        <a class="btn p-3 btn-warning" href="{$imeiorderhistorylink}">{$lang.view} {$lang.imei} {$lang.order} {$lang.history} </a>
    {/if}

    </div>



    <div   class="alert addedtocart"></div>

    <div class="row h-100">

        {if $min}
            <div class="col-lg-12">
                <div class="">

                    {if $cart}
                        <div class="form-group ">
                            <div class="">
                                <h5>
                                    {if $currency.prefix}
                                        <span class="prefix">{$currency.prefix}</span>
                                    {else}
                                        {$userdetails.currency.prefix}
                                    {/if}
                                    <span id="ctotal">
												{$imeiservice.credit-$imeiservice.discount}
											</span>
                                    {if $currency.suffix}
                                        <span class="suffix">{$currency.suffix}</span>
                                    {else}
                                        {$userdetails.currency.suffix}
                                    {/if}
                                </h5>


                                {if  $imeiservice.time} <span class="text-muted font-normal"> {$imeiservice.time} {$lang.deliverytime} </span> {/if}
                            </div>
                        </div>

                    {/if}

                </div>
            </div>
        {/if}



        <div class="{if $min} col-lg-12 {else} col-lg-5 {/if} placeorder-field d-flex col-left flex-column h-100">

            <div class="card card-min-height card-place-retail-order">

                <div class="h-100 flex-column">

                    {if $cart}

                    {if $direct eq true}
                        {if $imeiservice.qnt eq 1}
                            <div class="form-group ">
                                <label>
                                    {$lang.qnt}
                                </label>
                                <div class="controls">
                                    <input type="number"   class="form-control " id="qnt" name="qnt" size="5"  />
                                    {if $imeiservice.minqnt gt 0}
                                        {$lang.qnt} {$lang.range} {$lang.shouldbe} {$imeiservice.minqnt} - {$imeiservice.maxqnt}
                                    {/if}
                                </div>
                            </div>
                        {/if}

                    {if $imeiservice.useasserver eq '2'}
                        <div class="form-group ">
                            <label>
                                {$lang.server}
                            </label>
                            <div class="controls">
                                <textarea name="imei_custom" class="form-control " id="imei_custom" rows="6"  cols="50" ></textarea>
                            </div>
                        </div>
                    {elseif $imeiservice.useasserver eq '1'}
                        <div class="form-group ">
                            <label>
                                {$lang.server}
                            </label>
                            <div class="controls">
                                <textarea name="imei_custom" class="form-control " id="imei_custom" rows="6"  cols="50" ></textarea>
                            </div>
                        </div>
                    {elseif $imeiservice.reqredfield.imei_custom}
                        <div class="form-group  input-imei">
                            <label>
                                {$imeiservice.reqredfield.imei_custom_name}
                            </label>
                            <div class="controls">
                                <textarea name="imei_custom" class="form-control "  id="imei_custom" rows="6"   cols="30"></textarea>
                                <div class="text-muted">
                                <span id="maxo">
                                </span>
                                </div>
                            </div>
                        </div>
                    {else}
                    {if $imeiservice.reqredfield.imei_single ||  !$imeiservice.reqredfield.imei_bulk}
                        <div class="form-group   input-imei">
                            <label>
                                {$lang.imei}
                            </label>
                            <div class="d-flex">
                                <input name="imei1" type="text" class="form-control  col  mr-2"   class="imei1" id="imei1" onblur="remove_imei2()"
                    onkeyup="luhnCheck()" maxlength="14"   />
                                <input name="imei2" type="text" class="form-control  col-auto mr-2" style="width:50px" id="imei2" size="1"  readonly="true" class="imei2" />
                                {if $imeiservice.reqredfield.imei_bulk}
                                <button type="button" name="IMEI_ADD" id="IMEI_ADD" value="{$lang.addimei}" onclick="add_imei()" class="btn btn-secondary">
                                    {$lang.add}
                                </button>
                                {/if}
                               </div>
                                <div class="text-muted">{$lang.imeiinformation}</div>
                        </div>
                    {/if}
                        <div style="" id="plaorder-fields">
                            {if $imeiservice.reqredfield.imei_bulk}
                            <div class="form-group ">
                                <label>
                                    {$lang.imeibulk}
                                </label>
                                <div class="controls">
                                    <textarea name="imei_bulk"  class="form-control "  id="imei_bulk" rows="6" cols="30"  ></textarea>
                                    <div class="text-muted">
                                    <span id="maxo"></span>
                                    {$lang.imeibulkinformation}</div>
                                </div>
                            </div>
                            {/if}
                        </div>
                    {/if}
                    {else}

                    {if $imeiservice.qnt eq 1}
                    <div class="form-group ">
                        <label>
                            {$lang.qnt}
                        </label>
                        <div class="controls">
                            <input type="number"   id="qnt"  class="form-control " name="qnt" size="5"  />
                            {if $imeiservice.minqnt gt 0}
                                {$lang.qnt} {$lang.range} {$lang.shouldbe} {$imeiservice.minqnt} - {$imeiservice.maxqnt}
                            {/if}
                        </div>
                    </div>
                    {/if}
                    {if $imeiservice.useasserver gt '0'}

                    {elseif $imeiservice.reqredfield.imei_custom}
                    <div class="form-group ">
                        <label>
                            {$imeiservice.reqredfield.imei_custom_name}
                        </label>
                        <div class="controls">
                            <input type="text" class="form-control "
            name="imei_custom" id="imei_custom" />
                            <div class="text-muted">{$imeiservice.reqredfield.imei_custom_info}</div>
                        </div>
                    </div>
                    {else}
                    <div class="form-group">
                        <label>
                            {$lang.imei}
                        </label>
                        <div class="d-flex">
                            <input   name="imei1" type="text" class="form-control  col  mr-2" id="imei1" onblur="remove_imei2()" onkeyup="luhnCheck()" maxlength="14" />
                            <input name="imei2" type="text" class="form-control  col-auto mr-2" id="imei2"  style="width:50px" readonly="true" class="imei2" />
                        </div>
                        <div class="text-muted">{$lang.imeiinformation}</div>
                    </div>
                    {/if}
                    {/if}
                    {else}
                    {if $imeiservice.qnt eq 1}
                    <div class="form-group ">
                        <label>
                            {$lang.qnt}
                        </label>
                        <div class="controls">
                            {if $imeiservice.qntoptions}
                                {assign var=qntloop value=","|explode:$imeiservice.qntoptions}
                                <select name="qnt" id="qnt" class="form-control ">
                                    {foreach from=$qntloop item=foo}
                                        <option>{$foo}</option>
                                    {/foreach}
                                </select>
                            {else}
                            <input type="number" class="form-control "   id="qnt"   name="qnt" size="5"  />
                                {if $imeiservice.minqnt gt 0}
                                    {$lang.qnt} {$lang.range} {$lang.shouldbe} {$imeiservice.minqnt} - {$imeiservice.maxqnt}
                                {/if}
                            {/if}
                        </div>
                    </div>
                    {/if}
                    {if $imeiservice.useasserver gt '0'}

                    {elseif $imeiservice.reqredfield.imei_custom}
                    <div class="form-group ">
                        <label>
                            {$imeiservice.reqredfield.imei_custom_name}
                        </label>
                        <div class="controls">
                            <textarea name="imei_custom"  class="form-control "  id="imei_custom"   rows="6" cols="30"  style="width:200px" ></textarea>
                            <div class="text-muted">
                                <span id="maxo">
                                </span>
                             </div>
                        </div>
                    </div>
                    {else}
                    {if $imeiservice.reqredfield.imei_single ||  !$imeiservice.reqredfield.imei_bulk}


                        <div class="form-group    input-imei">
                        <label>
                                {$lang.imei}
                        </label>
                        <div class="d-flex">
                          <input name="imei1" type="text" class="form-control  col mr-2" id="imei1"   onblur="remove_imei2()" onkeyup="luhnCheck()" maxlength="14" />
                          <input name="imei2" type="text"   class="form-control  col-auto mr-2" style="width:50px" id="imei2"   readonly="true" class="imei2" />
                            {if $imeiservice.reqredfield.imei_bulk}
                                <button type="button" name="IMEI_ADD" id="IMEI_ADD" value="{$lang.addimei}" onclick="add_imei()" class="btn btn-secondary">
                                    {$lang.add}
                                </button>
                            {/if}
                        </div>
                            <div class="text-muted">{$lang.imeiinformation}</div>
                    </div>


                    {/if}

                    <div style="" id="plaorder-fields">
                        {if $imeiservice.reqredfield.imei_bulk}
                        <div class="form-group ">
                            <label>
                                {$lang.imeibulk}
                            </label>
                            <div class="controls">
                                <textarea name="imei_bulk"  class="form-control "  id="imei_bulk"   rows="6" cols="30"  ></textarea>
                                <div class="text-muted"><span id="maxo">
                                </span>
                                {$lang.imeibulkinformation}</div>
                            </div>
                        </div>
                        {/if}
                    </div>
                    {/if}
                    {/if}

                    {if $imeiservice.reqredfield.model}
                        <div class="d-flex justify-content-between">
                            <div>
                                <div class="form-group ">
                                    <label>
                                        {$lang.brand}
                                    </label>
                                    <div class="controls">
                                        {$brands} <div class="text-muted">{$lang.brandinformation}</div>
                                    </div>
                                </div>
                                <div id="modelsTr" style="display:none;" class="specialP form-group ">
                                    <label>
                                        {$lang.model}
                                    </label>
                                    <div class="controls">
                                        <div id="modelsdropdown">
                                        </div>
                                        <div class="text-muted">{$lang.modelinformation}</div>
                                    </div>
                                </div>
                            </div>
                            <span   id="modelsimage"></span>
                        </div>



                    {/if}

                    {if $imeiservice.reqredfield.provider}
                    <div class="form-group ">
                        <label>
                            {$lang.country}
                        </label>
                        <div class="controls">
                            {$provider_countrys}
                            <div class="text-muted">{$lang.countryinformation}</div>
                        </div>
                    </div>
                    <div id="providerTr" style="display:none;" class="specialP form-group ">
                        <label>
                            {$lang.provider}
                        </label>
                        <div class="controls">
                            <div id="providerdropdown">
                            </div>
                            <div class="text-muted">{$lang.providerinformation}</div>
                        </div>
                    </div>
                    {/if}


                    {if $imeiservice.reqredfield.mep}
                    <div class="form-group ">
                        <label>
                            {$lang.mep}
                        </label>
                        <div class="controls">
                            {$meps}
                            <div class="text-muted">{$lang.mepinformation}</div>
                        </div>
                    </div>
                    {/if}

                    {if $imeiservice.reqredfield.PIN}
                    <div class="form-group ">
                        <label>
                            {$lang.pin}
                        </label>
                        <div class="controls">
                            <input name="PIN" type="text" class="form-control "   maxlength="20" />
                            <div class="text-muted">{$lang.pininformation}</div>
                        </div>
                    </div>
                    {/if}

                    {if $imeiservice.reqredfield.KBH}
                    <div class="form-group ">
                        <label>
                            {$lang.kbh}
                        </label>
                        <div class="controls">
                            <input name="KBH" type="text" class="form-control "   maxlength="20" />
                            <div class="text-muted">{$lang.kbhinformation}</div>
                        </div>
                    </div>
                    {/if}

                    {if $imeiservice.reqredfield.PRD}
                    <div class="form-group ">
                        <label>
                            {$lang.prd}
                        </label>
                        <div class="controls">
                            <input name="PRD" type="text" class="form-control "   maxlength="20" />
                            <div class="text-muted">{$lang.prdinformation}</div>
                        </div>
                    </div>
                    {/if}
                    {if $imeiservice.reqredfield.SN}
                    <div class="form-group ">
                        <label>
                            SN
                        </label>
                        <div class="controls">
                            <input name="SN" type="text" class="form-control "   maxlength="20" />
                        </div>
                    </div>
                    {/if}
                    {if $imeiservice.reqredfield.SecRO}
                    <div class="form-group ">
                        <label>
                            SecRO
                        </label>
                        <div class="controls">
                            <input name="SecRO" type="text" class="form-control "   maxlength="20" />
                            <div class="text-muted">To get SRO, power on phone and type *#837# or *#3228# then search name that starts with
                            "
                            X
                            "
                            letter in the list. Example: XG55NBG3</div>
                        </div>
                    </div>
                    {/if}

                    {if $imeiservice.reqredfield.type}
                    <div class="form-group ">
                        <label>
                            {$lang.type}
                        </label>
                        <div class="controls">
                            <input name="Type" type="text" class="form-control "   maxlength="20" />
                            <div class="text-muted">{$lang.typeinformation}</div>
                        </div>
                    </div>
                    {/if}

                    {if $imeiservice.reqredfield.reference}
                    <div class="form-group ">
                        <label>
                            {$lang.reference}
                        </label>
                        <div class="controls">
                            <input name="Reference" type="text" class="form-control "  maxlength="20" value="25XXXXXXX" />
                            <div class="text-muted">{$lang.referenceinformation}</div>
                        </div>
                    </div>
                    {/if}


                    {if $imeiservice.reqredfield.locks}
                        <div class="form-group ">
                            <label>
                                {$lang.locks}
                            </label>
                            <div class="controls">
                                <div class="form-group ">
                                    <input type="checkbox" name="Locks[]" value="NCK" id="Lock0" />
                                    <label for="Lock0">
                                        {$lang.lock1} <b>NCK</b>
                                    </label>
                                </div>
                                <div class="form-group ">
                                    <input type="checkbox" name="Locks[]" value="NSCK" id="Lock1" />
                                    <label for="Lock1">
                                        {$lang.lock2} <b>NSCK</b>
                                    </label>
                                </div>
                                <div class="form-group ">
                                    <input type="checkbox" name="Locks[]" value="SPK" id="Lock2" />
                                    <label for="Lock2">
                                        {$lang.lock3} <b>SPK</b>
                                    </label>
                                </div>
                                <div class="form-group ">
                                    <input type="checkbox" name="Locks[]" value="CCK" id="Lock3" />
                                    <label for="Lock3">
                                        {$lang.lock4} <b>CCK</b>
                                    </label>
                                </div>
                                <div class="form-group ">
                                    <input type="checkbox" name="Locks[]" value="ESL" id="Lock4" />
                                    <label for="Lock4">
                                        {$lang.lock5} <b>ESL</b>
                                    </label>
                                    <div class="text-muted">{$lang.locksinformation}</div>
                                </div>
                            </div>
                        </div>
                    {/if}



                    {if $customfields}
                    {foreach from=$customfields key=name item=fields}
                        <div class="form-group custom-controls {$fields.type}-control">
                            <label>
                                {$name}
                            </label>
                            <div class="controls">
                                {$fields.input}  <span class="required"> {$fields.required} </span>
                                <div class="text-muted">{$fields.description}</div>
                            </div>
                        </div>
                    {/foreach}
                    {/if}
                    {if $ordernotes}
                    <div class="form-group">
                        <label>
                            {$lang.notes}
                        </label>
                        <div class="controls">
                            <input type="text" class="form-control "   name="notes"  />

                            <div class="text-muted">{$lang.additionalnote}</div>
                        </div>
                    </div>
                    {/if}
                    {if $ordercomments}
                    <div class="form-group ">
                        <label>
                            {$lang.comments}
                        </label>
                        <div class="controls">
                            <textarea name="comments"  class="form-control "    cols="30" rows="2" ></textarea>

                            <div class="text-muted">{$lang.remember}</div>
                        </div>
                    </div>
                    {/if}
                    {if $orderemail}
                    <div class="form-group ">
                        <label>
                            {$lang.responsemail}
                        </label>
                        <div class="controls">
                            <input type="text" class="form-control "   name="response"  />

                            <div class="text-muted">{$lang.responseinfo}</div>
                        </div>
                    </div>
                    {/if}
                    {if $pin eq 1}
                        <div class="form-group ">
                            <label>
                                {$lang.masterpin}
                            </label>
                            <div class="controls">
                                <input type="password" id="pin"   name="pin" maxlength="4" />

                            </div>
                        </div>
                    {/if}
                    {if $smsgateway && $userdetails.ordersms eq 1}
                    {if $orderno}
                    <div class="form-group ">
                        <div class="controls">
                            {if $responseno}
                            <label>
                                <input type="hidden" name="no" value="2" />
                                <input type="text" class="form-control " name="otherno"   value="{$responseno}"  />

                                <div class="text-muted">{$lang.mobilenumber}</div>
                            </label>
                            {else}
                            <input type="text" class="form-control " name="otherno"  />

                            <div class="text-muted">{$lang.mobilenumber}</div> {/if}
                        </div>
                    </div>
                    {/if}
                    {/if}

                </div>
                <div class="d-actionbar-mobile d-block">
                    {if $direct && $charge neq '1'}


                            <button type="button" class="btn btn-primary w-100"   id="placedirectorder"
                                    onclick="SubmitForm2('#placedirectorder','{$directorderlink}','#imeiorder_form{if $min}2{/if}','.alert','true','#loader','','',function(data) {
                                                 afterplaceorder(data);
                                            });" value="{$lang.placeorder}" >
                                {$lang.placeorder}
                            </button>


                    {else}
                        {if $cart or $charge eq '1'}

                                    <div class="d-flex justify-content-between align-items-center">
                                        <button type="button" class="btn btn-primary   placeorder w-100"   onclick="SubmitForm('.placeorder','{$cartlink}','#imeiorder_form{if $min}2{/if}','.alert-cart','true','#loader');" value="{$lang.addtocart}" >
                                            {$lang.addtocart}
                                        </button>
                                        {*{if $paypalactive	&& $quick_checkout && $imeiservice.credit gt 0}
                                            <button type="button" class="btn btn-secondary mr-2" id="quickcheckout" onclick="SubmitForm2('#quickcheckout','placeholder.php?gat=paypal','#imeiorder_form{if $min}2{/if}','.addedtocart','true','#loader');" value="{$lang.paypalquickcheckout}" >
                                                {$lang.paypalquickcheckout}
                                            </button>
                                        {/if}
                                        {if $googleactive && $quick_checkout && $imeiservice.credit gt 0}
                                            <button type="button" class="btn btn-secondary" id="googlequick" onclick="SubmitForm2('#googlequick','placeholder.php?gat=googlecheckout','#imeiorder_form{if $min}2{/if}','.addedtocart','true','#loader');" value="Google Checkout" >
                                                Google Checkout
                                            </button>
                                        {/if}*}
                                    </div>

                            {else}


                            {if $toc}
                                <div class="form-control mb-2">

                                    <label class="service-toc">
                                        <input type="checkbox" name="accept"/> {$lang.agreewithterms}
                                    </label>
                                </div>
                            {/if}

                            <div class="w-100">
                                    {if $forreward}
                                        <button type="button" class="btn btn-primary placeorder w-100"    onclick="SubmitForm2('.placeorder','{$placerewardorderlink}','#imeiorder_form{if $min}2{/if}','.alert','true','#loader','','',function(data) {
                                                afterplaceorder(data);
                                                });" value="{$lang.placeorder}" >
                                            {$lang.placeorder}
                                        </button>
                                        {else}
                                        <button type="button" class="btn btn-primary placeorder w-100"    onclick="SubmitForm2('.placeorder','{$placeorderlink}','#imeiorder_form{if $min}2{/if}','.alert','true','#loader','','',function(data) {
                                                afterplaceorder(data);
                                                });" value="{$lang.placeorder}" >
                                            {$lang.placeorder}
                                        </button>
                                    {/if}
                            </div>
                            {/if}
                    {/if}
                </div>

            </div>

        </div>



        {if !$min}
            <div class="col-lg-7 placeorder-details col-right">

                <div class="card card-min-height card-place-retail-order">
                    <div class="d-flex flex-column w-100">

                    <div class="">
                        <div>

                               <div class=" pb-2">


                                   {if $imeiservice.icon}
                                       <div>
                                           {$imeiservice.icon}
                                       </div>
                                   {/if}


                                    <div >

                                        <div>


                                       <div class="d-flex justify-content-start">
                                        <div>
                                            <div id="mult"  style="display:none !important;">
                                                 <div class="d-flex">
                                                    <h5 style="">	{if !$loggedin} <span class="prefix">{$currency.prefix}</span>  {else} {$userdetails.currency.prefix} 	{/if}
                                                    <span id="ocredit">{$imeiservice.credit-$imeiservice.discount}</span>
                                                    {if !$loggedin} <span class="suffix">{$currency.suffix}</span>  {else} {$userdetails.currency.suffix} {/if}
                                                    </h5><span>*</span><span id="ccnt">1</span><span>=</span> </div>
                                            </div>
                                            <div class="text-green align-items-center fw-100">

                                                {if $forreward}
                                                    <div id="">{$imeiservice.purchasepoint} Points</div>
                                                 {else}
                                                    <div>
                                                        <span  class="text-muted">
                                                            {if !$loggedin}
                                                                <span class="prefix">{$currency.prefix}</span>
                                                            {else}
                                                                {$userdetails.currency.prefix}
                                                            {/if}
                                                        </span>
                                                        <span id="ctotal" class="order-total">{$imeiservice.credit-$imeiservice.discount}</span>
                                                    </div>
                                                {/if}
                                                <span>	{if !$loggedin}<span class="suffix">{$currency.suffix}</span>  {else} {$userdetails.currency.suffix} {/if}</span>
                                            </div>


                                           <div class="text-muted font-normal">

                                              <div>
                                                  {if  $imeiservice.time}
                                                    {$imeiservice.time} {$lang.deliverytime}
                                                  {/if}
                                              </div>

                                               <div>
                                                   {if $averagetime}
                                                        {if $averagetime.d gt 0}
                                                            {$averagetime.d} {$lang.days}
                                                        {/if}
                                                        {if $averagetime.h gt 0}
                                                            {$averagetime.h}  {$lang.hours}
                                                        {/if}
                                                        {if $averagetime.m gt 0}
                                                            {$averagetime.m}  {$lang.minutes}
                                                        {/if}

                                                        {$lang.average} {$lang.deliverytime}
                                                    {/if}
                                               </div>

                                           </div>
                                         </div>

                                         </div>




                                            <div>
                                                {assign var='ftrarray' value=','|explode:$imeiservice.features}
                                                {foreach from=$ftrarray key=key item=features}
                                                {if $features}
                                                 <span class="badge badge-secondary"> {$features} </span>
                                                {/if}
                                                {/foreach}
                                            </div>

                                            <div>
                                                {if $imeiservice.type eq 'Database'} <span class="badge badge-info"> {$lang.datebase} </span> {/if}
                                                {if $imeiservice.type eq 'Calculator'} <span class="badge badge-info"> {$lang.calculator} </span> {/if}
                                                {if $imeiservice.type eq 'Other'} <span class="badge badge-info"> {$lang.other} </span> {/if}
                                                {if $imeiservice.verifiable} <span class="badge badge-info"> {$lang.verifiable} </span> {/if}
                                                {if $imeiservice.usercan_cancel} <span class="badge badge-info"> {$lang.cancancel} </span> {/if}
                                            </div>

                                        </div>



                                    </div>
                                </div>

                            <div>
                                <div class="progress" id="progress" style="height: 2px;">
                                    <div class="progress-bar bg-danger" role="progressbar" aria-valuenow="20" style="width: 25%" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>


                            {if $imeiservice.qntrange}


                            <table class="table border-0  table-striped mt-3">
                                <thead>
                                <tr>
                                    <th colspan="3">Qnt</th>
                                    <th>Price</th>
                                    <th class="w-100"></th>
                                </tr>
                                </thead>



                                {foreach from=$imeiservice.qntrange key=range item=qntrange}
                                    {if $range neq 0}
                                        <tr>
                                            <td>{$qntrange.start}  </td>
                                            <td>-</td>
                                            <td>{if $qntrange.end}{$qntrange.end}{else}&infin;{/if}</td>
                                            <td class="text-right">{$userdetails.currency.prefix}{$qntrange.price} </td>
                                            <td></td>
                                        </tr>
                                    {/if}
                                {/foreach}
                            </table>
                            {/if}


                        </div>
                    </div>

                    {if !$cart}
                        <div class="form-group mt-3">
                            <div class="controls">

                                <div class="col-lg-4">
                                    <div style="background: #ffc107;padding: 5px 8px;border-radius: 5px;width: 200px;">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" name="frequentlyuse" {if $imeiservice.frequent} checked='checked' {/if} onclick="setFrequent('{$imeiservice.id}',this);"  class="custom-control-input" id="frequentlyuse">
                                            <label class="custom-control-label" for="frequentlyuse">{$lang.frequentlymsg}</label>
                                        </div>

                                    </div>
                                </div>


                            </div>
                        </div>
                    {/if}


                        {if $imeiservice.download_link}
                            <a href="{$imeiservice.download_link}" download class="px-3" target="_blank">
                                <i class="fa fa-download"></i> {$lang.download}
                            </a>
                        {/if}



                        <div  class="service-information">
                            <div>
                                {if $infopos neq 2}
                                        {$imeiservice.customhtml}
                                {/if}

                                {if $direct}
                                     {if $imeiservice.retail_info}
                                            {$imeiservice.retail_info}
                                     {else}
                                            {$imeiservice.info}
                                    {/if}
                                {else}
                                    {$imeiservice.info}
                                {/if}
                            </div>
                        </div>


                    {if $cart}

                        <div id="pinfo">
                            <script>
                                getContect('#tab',"widget/getFeaturesDetail?serviceid={$item}&action=imeiinfo","#pinfo",true,'#loader',true);
                            </script>
                        </div>

                        {if $imeiservice.review eq 1}
                            <a data-toggle="modal" class="btn"  data-target="#modal-ajax" href="widget/getFeatures?serviceid={$item}&action=imeireview" data-whatever="{$lang.customer} {$lang.review}">
                                {$lang.customer} {$lang.review}
                            </a>
                        {/if}

                    {/if}

                        {if $imeiservice.faq_id}
                            <div id="knwbg">
                                <script>
                                    getContect('#tab',"widget/getKnowledgebase?id={$imeiservice.faq_id}","#knwbg",true,'#loader',true);
                                </script>
                            </div>
                        {/if}

                        {if $cart}

                        {if $imeiservice.acceptterms eq '1'}
                            <br />
                            <label><input type="checkbox" name="accept" >{$lang.agreewithterms}</label>
                        {/if}

                    {/if}


                    {if $imeiservice.feedback}
                        <div class="feedback">
                            <h4>
                                {$lang.feedback}
                            </h4>
                            <hr />
                            <div class="row-block">
                                {foreach from=$imeiservice.feedback key=key item=item}
                                {assign var="email" value=$item.email|md5}
                                {assign var="grav_url" value="http://www.gravatar.com/avatar/$email?d=mm&amp;s=50"}
                                <table class="table table-bordered">
                                    <tr>
                                        <td>
                                            <img src="{$grav_url}" alt=""/>
                                        </td>
                                        <td>
                                            {$item.comment}
                                        </td>
                                    </tr>
                                </table>
                                {/foreach}
                            </div>
                        </div>
                    {/if}
                    </div>
                </div>

            </div>
        {/if}

    </div>






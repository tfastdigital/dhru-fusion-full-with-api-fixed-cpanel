{literal}
<script>

$(document).ready(function(){

    var maxo=parseInt(parseFloat($('#ccredit').text())/parseFloat(Math.round( $('#ocredit').text()*100 )/100 ).toString());
    if(!maxo){
        maxo=0;
    }
    $('#maxo').text('You can have max. qnt is '+maxo+' of this service');

   $('input[name="qnt"]').keyup(function(e){
         cntr();
   });

   $('div.controls').on('focus','input[type="text"],textarea',function(){
        $(this).closest('.controls').addClass('focus');
    });

    $('div.controls').on('blur','input[type="text"],textarea',function(){
        $('.controls.focus').removeClass('focus');
    });


});

   function cntr(){

        var tt=(parseFloat(Math.round( $('#ocredit').text()*($('input[name="qnt"]').val()) * 100 )/100 ).toString());
        $('#ccnt').text($('input[name="qnt"]').val());
        if(parseFloat($('#ccredit').text())>=tt){
            $('#mult').show();
            $('#ctotal').text(tt);
        }
        else{
            alert('You have not enough balance');
        }
   }

</script>
{/literal}


{if !$cart}
    <h5 onclick="showservices()" class="align-right back-btn" style="cursor:pointer;float:right;margin-top:-17px;margin-right:0px;"><i class="icon-arrow-left"></i> Back</h5>
{/if}

 <div  style="position:relative">

 {if !$cart}
       <div class="sInfo" style="">
      {assign var='ftrarray' value=','|explode:$serverservice.features}
        {foreach from=$ftrarray key=key item=features}
            {if $features}
                <i class="icon-check" data-toggle="tooltip" data-original-title="{$features}"></i>
            {/if}
        {/foreach}

              <div class="clearfix"></div>
        </div>
{/if}

 <div class="pull-left" style="padding-right: 50px;width:40%">



<div  style="" class="form-inline frm-inline">

<div  class="alert1 alert"></div>


{if $serverservice.download_link}
    <div class="form-group "><label class="form-label">{$downloadlink}</label></div>
{/if}
{if $customfields}
     {foreach from=$customfields key=name item=fields}
        <div class="form-group "><label class="form-label">{$name}</label><div class="controls"> {$fields.input}{$fields.required}<br /> <small>{$fields.description}</small></div></div>
    {/foreach}
{/if}
{if $serverservice.qnt eq 1}
    <div class="form-group ">
    <label class="form-label">{$lang.qnt}:</label>
    <div class="controls"><input type="text" name="qnt" size="5"  /><br /> <span id="maxo"></span> </div></div>
    <br />
{/if}
{if $ordernotes}
  <div class="form-group "><label class="form-label">{$lang.notes}:</label><div class="controls"><input type="text" name="notes"  /><br /><small>{$lang.additionalnote}</small></div></div>
{/if}
{if $ordercomments}
  <div class="form-group "><label class="form-label">{$lang.comments}:</label><div class="controls"><textarea name="comments" cols="30" rows="2" ></textarea><br /><small>{$lang.remember}</small></div></div>
{/if}
{if $orderemail}
  <div class="form-group "><label class="form-label">{$lang.responsemail}:</label><div class="controls"><input type="text" name="response"  /><br /><small>{$lang.responseinfo}</small></div></div>
{/if}
{if $pin eq 1}
    <div class="form-group "><label class="form-label">{$lang.masterpin}:</label><div class="controls"><input type="password" id="pin" name="pin" maxlength="4" /><br /></div></div>
{/if}
{if $smsgateway && $userdetails.ordersms eq 1}
    {if $orderno}
          <div class="form-group "><label class="form-label">{$lang.responseno}:</label>
              <div class="controls">
                    {if $responseno}
                       <label style="float:left;padding:10px;"> <input checked="" type="radio" name="no" value="1" /> {$responseno}</label>
                       <label  style="float:left;padding:10px;"><input type="radio" name="no" value="2" /> </label> <input type="text" name="otherno" /> <small>{$lang.mobilenumber}</small>
                    {else}
                        <input type="text" name="otherno" /><br /><small>{$lang.mobilenumber}</small>
                    {/if}
              </div>
          </div>
    {/if}
{/if}




<div class="form-group " >
        <div class="controls">

        {if $serverservice.credit}
            <div class="creditCost">
               <span id="mult" style="display:none"> <span>{$userdetails.currency.prefix}<span id="ocredit">{$serverservice.credit-$serverservice.discount}</span>{$userdetails.currency.suffix}</span><span>*</span><span id="ccnt">1</span><span>=</span> </span>  <label>{$userdetails.currency.prefix}<span id="ctotal">{$serverservice.credit-$serverservice.discount}</span>{$userdetails.currency.suffix}</label>  {$lang.credit}s Required  <br /> {if  $serverservice.time} <span> {$serverservice.time} {$lang.deliverytime} </span> {/if}

            {if $averagetime}
                <br />
                <span>
                    {if $averagetime.d gt 0}
                        {$averagetime.d} Days
                    {/if}
                    {if $averagetime.h gt 0}
                        {$averagetime.h} Hours
                    {/if}
                    {if $averagetime.m gt 0}
                        {$averagetime.m} Minutes
                    {/if}
                    {$lang.average} {$lang.deliverytime}
                </span>
            {/if}

            </div>
        {/if}

</div></div>

{if !$cart}
 <div class="form-group "><label class="form-label"></label> <div class="controls">

          <div  class="icons" style="font-size: 14px;color: rgb(153, 153, 153);">
    {if $serverservice.type eq 'Database'}  <span> Database </span> {/if}
    {if $serverservice.type eq 'Calculator'}  <span> Calculator </span> {/if}
    {if $serverservice.type eq 'Other'}  <span> Other </span> {/if}
    {if $serverservice.verifiable}  <span> Verifiable </span> {/if}
    {if $serverservice.usercan_cancel}   <span> Can Cancel </span> {/if}
 </div>
 </div></div>
 {/if}

  {if $cart}
      <div class="form-group " >
        <div class="controls">
            <button type="submit" id="placeorder" class="btn btn-primary"  onclick="SubmitForm('#placeorder','includes/cart','#serverorder_form','.alert1','true','#loader');" value="{$lang.addtocart}" > {$lang.addtocart} </button>

        </div>
        <div class="clear"></div>
      </div>
  {else}
      <div class="form-group "   ><div class="controls">

      <button type="submit" class="btn btn-primary btn-large"  id="placeorder" onclick="SubmitForm('#placeorder','includes/getdata/placeorderserver','#serverorder_form','.alert1','true','#loader');" value="{$lang.placeorder}" > {$lang.placeorder} </button>
      </div>

      <div class="clear"></div>

      </div>
  {/if}

 </div>
 </div>

  <div class="pull-left" style="width: 58%;  position: relative;">
        {if $serverservice.icon_link} <div ><img src="{$serverservice.icon_link}"/> </div>{/if}

        {if $infopos neq 2}
               <div id="information"></div>
        {/if}

        <div   class="alert" style="position:relative;top:0;"></div>

        {$serverservice.customhtml}

    </div>
    <div class="clear"></div>
    {if !$cart}
       <hr /><br />
       <div class="knowleg">
           {if $serverservice.faq_id}
                <script>
                    getContect('','widget/getKnowledgebase?id={$serverservice.faq_id}','.knowleg',false,'#loader',true);
                </script>
           {/if}
        </div>
{/if}

<div class="clearfix"></div>




</div>
        <div class="clearfix"></div>
 </div>
<div class="clearfix"></div>
 </form>

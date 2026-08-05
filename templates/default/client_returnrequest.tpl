{literal}
<script>
function setAction(val){
    if(val==4){
        $("#other").show();
    }else{
        $("#other").hide();
    }
}
</script>
{/literal}
<div id="tabcontent">

  <div id="formstyle_1">
    <form class="form-inline frm-inline"  method="post" name="contact" id="contact">
    <input type="hidden" name="ids" value="{$ids}" />
      <fieldset>
          <div    class="alert"></div>


          <div class="form-group "><label class="form-label">{$lang.return} {$lang.reason}</label><div class="controls">
<select name="reason">
<option value="1" >Wrong item ordered</option>
<option value="2" >Wrong description online</option>
<option value="3" >Do not like the product</option>
<option value="4" >Can't get it to work</option>
<option value="5" >Manufacturer defect or DOA</option>
<option value="6" >Damaged during shipping</option>
<option value="7" >Wrong item sent</option>
</select></div></div>

          <div class="form-group "><label class="form-label">{$lang.whatliketodo} </label><div class="controls">
<select name="action" onchange="setAction(this.value);">
<option value="1" >Send replacement if within warranty</option>
<option value="2" >Repair and ship back</option>
<option value="3" >Give me a credit for future purchase</option>
<option value="4" >Other</option>
</select>
          </div></div>
          <p id="other" style="display:none;"><label>{$lang.other} {$lang.action} </label><div class="controls">
                 <textarea rows="4" cols="45" name="other"></textarea>
          </div></div>
          <div class="form-group "><label class="form-label">{$lang.comment} </label><div class="controls">
                 <textarea rows="4" cols="45" name="comment"></textarea>
          </div></div>
            <p class="button"><label></label>
                <span>
 <input type="submit"  id="send"
 onclick="SubmitForm('#send','includes/getdata/rejectrequest.php','#contact','.alert','true','#loader');" name="send" value="{$lang.submit}" />
                </span>
        	</p>

      </fieldset>
    </form>
  </div>
</div>
</div>
{include file="templates/default/client_profile_rightmenu.tpl"}

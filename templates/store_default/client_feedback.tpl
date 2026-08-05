<script src="includes/js/rating.js" type="text/javascript"></script>
<link rel="stylesheet" href="includes/css/rating.css" type="text/css"/>
<div class="subcontainerfullwidth">

    <div class="floatright" style="width:730px">
        <div id="tabcontent">

          <div id="formstyle_1">
            <form class="form-inline frm-inline" method="post" name="imeiorder_form" id="imeiorder_form" >
            <input type="hidden" name="id" value="{$mdservice}" />
              <fieldset>
                <div    class="alert"></div>
              {$token}

              <div class="form-group "><label class="form-label">{$lang.item}</label>
                  <span>
                             {$service}
                  </span>
              </p>
              <div class="form-group "><label class="form-label">{$lang.feedback} {$lang.type}:</label>
              <span>
<input type="radio" name="feedtype" value="1" id="fp" checked="checked" />{$lang.positive}
<input type="radio" name="feedtype" value="0" id="fn" />{$lang.negative}
               </span>
               </p>
              <p>
              <label>{$lang.review}:</label><div class="controls"><textarea name="comment" cols="30" rows="2" ></textarea>
               </span>
               </p>
               <div class="form-group "><label class="form-label">{$lang.rating}:</label><div class="controls">

              {literal}<script>$(document).ready(function() {
                $('#rates').rating('#estart', {maxvalue:5, increment:.5 ,curvalue: 4});
             });</script>{/literal}
              <div id="rates"  class="rating">&nbsp;</div>
              <input type="hidden" name="estart" id="estart" />

               </span>
               </p>

              <p class="button"><label></label>
              	<span><input type="submit" id="placeorder"
onclick="SubmitForm('#placeorder','includes/getdata/feedback.save.php','#imeiorder_form','.alert','true','#loader');"
value="{$lang.submit}" />  </span>
              </p>
              </fieldset>
            </form>
          </div>
        </div>
    </div>
</div>
<br /><br />

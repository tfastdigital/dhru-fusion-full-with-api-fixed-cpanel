<script src="includes/js/rating.js" type="text/javascript"></script>
<link rel="stylesheet" href="includes/css/rating.css" type="text/css"/>
<div class="subcontainerfullwidth">

    <div class="floatright" style="width:730px">
        <div id="tabcontent">

          <div id="formstyle_1">
            <form method="post" name="imeiorder_form" id="imeiorder_form" >
            <input type="hidden" name="id" value="{$mdservice}" />
            <input type="hidden" name="order" value="{$order}" />
            <input type="hidden" name="type" value="{$type}" />
              <fieldset>
                <div id="notification"></div>
              {$token}
              <legend>{$pagetitle}</legend>

              <p><label>{$lang.email}:</label>
              <span>
            <input type="text" name="email" value="{$email}" readonly="true" />
               </span>
               </p>

             <p><label>{$lang.rating} :</label><div class="controls">
              {literal}<script>$(document).ready(function() {
                $('#rates').rating('#estart', {maxvalue:5, increment:.5 ,curvalue: 4});
             });</script>{/literal}
              <div id="rates"  class="rating">&nbsp;</div>
              <input type="hidden" name="estart" id="estart" />
               </p>

              <p>
              <label>{$lang.feedback}:</label><span><textarea name="feedback" cols="30" rows="5" ></textarea>
               </span>
               </p>


              <p class="button"><label></label>
              	<span><input type="submit" id="placeorder"
onclick="SubmitForm('#placeorder','includes/getdata/feedback.save.php','#imeiorder_form','#notification','true','#loader');"
value="{$lang.submit}" />  </span>
              </p>
              </fieldset>
            </form>
          </div>
        </div>
    </div>
</div>
<br /><br />

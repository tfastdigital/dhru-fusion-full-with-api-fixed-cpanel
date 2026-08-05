 <script type="text/javascript" src="includes/js/imei.js"></script>
 <script type="text/javascript" src="includes/js/custom.js"></script>
 {literal}
    <style>
      .modellist-dp {
            border-radius: 0 0 0 0;
            color: white;
            display: block;
            font-size: 15px;
            margin: 0;
            padding: 0 10px;
        }
    .modellist-dp li {
        border-bottom: none;
        cursor: pointer;
        list-style: none outside none;
        padding: 5px;
    }
     .modellist-dp li:hover {
        color:#f4f4f4;
     }
     .form-inline frm-inline .form-group {width:auto;margin:0 10px 0 0}
     .creditCost label{font-size:20px;padding:0;}
    </style>
 {/literal}

 <div id="">
 <div id="notification2"    class="alert"></div>

 <div id="formstyle_1" style="text-align:left;">
  <form method="post" class="form-inline frm-inline" name="imeiorder_form" id="imeiorder_form" autocomplete="off" style="margin-top:0">
   <input type="hidden" name="servicetype" value="imei" />

 <div class="form-group ">
        <div class="controls">
             <input type="text" name="modelsearch" autocomplete="off"  onkeyup="quickModel(this)" id="modelsearch" placeholder="Search Model" />
            <ul id="modelslist" style="display:none;position:absolute;z-index:999999;background:black;width:198px;" class="modellist-dp"> </ul>
            <input type="hidden" name="brand" id="brand" />
            <input type="hidden" name="model_id" id="model" />
        </div>
        <small>Start here by type the model of your phone <br />or tablet to unlock...</small>
 </div>

 <div class="form-group " id="modelload" style="display:none;">
        <div class="controls"  id="modelsdropdown">
        </div>
 </div>

 <div class="form-group " id="countryload">
       <div class="controls"  id="countrydropdown">
            <select><option value="">-Country-</option></select>
       </div>
       <small>Select your country...</small>
 </div>

  <div class="form-group " id="providerload">
       <div class="controls"  id="providerdropdown" style="height:30px;line-height:30px">
        <select><option value="">-Provider-</option></select>
       </div>
       <small>Select your Provider...</small>
 </div>

 <div class="form-group " id="serviceload">
    <div class="controls"  id="servicedropdown"  style="height:30px;line-height:30px">
        <select><option value="">-{$lang.service}-</option></select>
    </div>
    <small>Select the actual carrier or service on which the phone is locked to.  Eq : Orange, Vodafone.... </small>
 </div>


<div class="form-group ">
    <div class="controls">
        <div id="serviceDetails">
            <div class="creditCost">
                <label>$0 USD</label>
            </div>
            <p class="button">
                <span>
                    <button type="button" value="Order Now" onclick="javascript:void(0)" class="btn btn-primary waves-effect waves-light" id="placeorder" >Order Now</button>
                </span>
            </p>
        </div>
    </div>
 </div>
 <div class="clear"></div>
 <br /><br />
      </form>
</div>
</div>

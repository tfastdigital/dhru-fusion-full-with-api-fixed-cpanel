
<form method="post"   name="imeiorder_form" id="imeiorder_form" autocomplete="off">

	<input type="hidden" name="servicetype" value="imei" />

 <div class="mt-3">

	 {if $servicearr}
		 <div class="form-group">

			 <select name="serviceid" id="serviceid"  class="form-control" onChange="getRetailDetails(this.value,'#loadretailorder');">
				 <option value="">-{$lang.select} {$lang.service}-</option>
				 {foreach from=$servicearr key=id item=order}
				 	<optgroup  label="{$id}">
						{foreach from=$order key=jd item=service}
							<option value="{$jd}">{$service}</option>
						 {/foreach}
					</optgroup>
				 {/foreach}
			 </select>
		 </div>
	 {else}


    {if $quickwidget eq 'brand'}

       	<div class="form-group">
    		<select name="brand" id="brand"  class="form-control " onChange="getModelslist('#modelsdropdown',this.value,'#modelload');">
    			<option value="">-{$lang.selectbrand}-</option>

                {foreach from=$brandarr key=id item=order}
                 {if $order}
                    <option value="{$id}">{$order}</option>
                 {/if}
                {/foreach}
    		</select>
    	</div>
    	<div id="modelload" class="form-group" style="display:none;">
    		<ul  class="list-group"  id="modelsdropdown"></ul>
    	</div>
    	<div id="servicelist" class="form-group"> </div>


	{else}


        <div class="form-group">
    		<div class="position-relative">
    		    <input type="text" class="form-control" name="modelsearch" onKeyUp="quickModel(this)" autocomplete="off"  id="modelsearch" placeholder="{$lang.search} {$lang.model} (eg. iPhone 5)" />
    			<ul id="modelslist"  class="modellist-dp position-absolute border-0 bg-gray p-0 w-100" style="z-index:99;overflow: auto;max-height:250px;display:none"> No result found </ul>

    			<input type="hidden" name="brand" id="brand" />
    			<input type="hidden" name="model_id" id="model" />
    		</div>
        </div>


	{/if}


        <div id="serviceload" class="form-group">
    		<div   id="servicedropdown">
    			<select class="form-control ">
    				<option value="">-{$lang.service}-</option>
    			</select>
    		</div>

    	</div>

	 {/if}
	</div>


</form>



<div id="loadretailorder">
	<div class="text-center text-muted">
	    Select service for Quick checkout
	</div>
</div>

<form method="post" action="cart.php" id="frmquickwid4">
	<input type="hidden" name="forquickcheckout" value="true"/>
	<input type="hidden" name="group" id="quickgroup" />
	<input type="hidden" name="item" id="quickitem" />
	<input type="hidden" name="bid" id="quickbrand" />
	<input type="hidden" name="mid" id="quickmodel" />
	<input type="hidden" name="service" value="imei" />
</form>




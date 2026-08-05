{literal}
    <script>
        $(document).ready(function(){
            $('.input-daterange input[type="text"]').each(function() {
                $(this).datepicker({format: 'yyyy-mm-dd'}).on('changeDate', function(e){
                    $(this).datepicker('hide');
                });
            });

            getServices('{/literal}{$smarty.request.type}{literal}','#serviceDetails','.alert',true,'#loader',{/literal}'{if $serverservice eq 2}2{else}{$smarty.request.serverservice}{/if}'{literal})

        });
    </script>
{/literal}

<div>
    <div>
    <div>


  <form method="post" name="export_form" id="export_form" action="{$advanceexportlink}" enctype="multipart/form-data">

    {if $notification.success}
    <div   class="alert alert-success">{$notification.success}</div>
    {elseif $notification.error}
    <div   class="alert alert-danger">{$notification.error}</div>
    {/if}

    {$token}

	  <div class="form-row ">

        <input type="hidden" name="type" value="{$smarty.request.type}"/>
        <div class="form-group   col-lg-12">
          <label>{$lang.status}:</label>
          <select name="status" class="form-control " >
            <option value="">{$lang.all}</option>
            <option value="0">{$lang.inprocess}</option>
            <option value="4">{$lang.available}</option>
            <option value="3">{$lang.cancel}</option>
          </select>
        </div>
</div>

      <div class="form-row mb-4 bottom-space">
          <div class="control-group col-lg-12">
              <label class="control-label">{$lang.service}:</label>
                  <div class="controls">
                      <div id="serviceDetails">
                          <select>
                              <option value="" >{$lang.selectservice}</option>
                          </select>
                      </div>
                  </div>
            </div>
      </div>

<div class="form-row  input-daterange">
    <div class="form-group  col-lg-6">
      <label>{$lang.from} {$lang.date}:</label>
      <input type="text" autocomplete="off" class="form-control " name="from" id="from"  />
    </div>

	  <div class="form-group   col-lg-6">
      <label>{$lang.to} {$lang.date}:</label>
      <input type="text" name="to" id="to" autocomplete="off"  class="form-control " />
    </div>
</div>

    <button type="submit" class="btn btn-primary" id="exportnow" name="exports" value="{$lang.export} {$lang.data}" >{$lang.export} {$lang.data}</button>
  </form>
</div>
    </div>
<br />

</div>

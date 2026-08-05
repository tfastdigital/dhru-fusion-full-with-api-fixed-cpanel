
<div class="container"><div class="page-container">

    <div class="card">

        <ul class="nav nav-pills flex-nowrap">

            {if $userdetails.access.imeiservice}
              	<li class="nav-item " onclick="getContect('#tab','{$imeilink}?standalone=true','#services',true,'#loader',true);"><a class="nav-link  active" data-toggle="tab" href="#imei"  id="tab1">{$lang.imeiservice}</a></li>
              {/if}
              {if $userdetails.access.fileservice}
              	<li class="nav-item " onclick="getContect('#tab','{$filelink}?standalone=true','#services',true,'#loader',true);"><a class="nav-link " href="#file"  data-toggle="tab"  id="tab2">{$lang.fileservice}</a></li>
              {/if}
              {if $userdetails.access.serverlogservice}
              	<li class="nav-item " onclick="getContect('#tab','{$serverlink}?standalone=true','#services',true,'#loader',true);"><a class="nav-link " href="#server"  data-toggle="tab"  id="tab3">{$lang.serverservice}</a></li>
              {/if}

        </ul>

	<div class="tab-content">
        <div class="tab-pane   fade show active" id="services" role="tabpanel" >   </div>
    </div>
</div>
    </div></div>

<script>
    getContect('#tab','{$imeilink}?standalone=true','#services',true,'#loader',true);
</script>

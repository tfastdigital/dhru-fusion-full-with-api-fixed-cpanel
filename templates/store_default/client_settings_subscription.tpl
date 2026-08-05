
<div class="container"><div class="page-container">

<div class="card">

<ul class="nav nav-pills flex-nowrap mb-4 bottom-space">
      {if !$eCommerce}
        {if $userdetails.access.imeiservice}
            <li class="nav-item " onclick="getContect('#tab','{$imeilink}?standalone=true','#services',true,'#loader',true);"><a class="nav-link  active" href="#imei"  data-toggle="tab" id="tab1">{$lang.imei} {$lang.service}</a></li>
        {/if}
        {if $userdetails.access.fileservice}
            <li  class="nav-item " onclick="getContect('#tab','{$filelink}?standalone=true','#services',true,'#loader',true);"><a class="nav-link " href="#file"  data-toggle="tab" id="tab2">{$lang.file} {$lang.service}</a></li>
        {/if}
        {if $userdetails.access.serverlogservice}
            <li  class="nav-item " onclick="getContect('#tab','{$serverlink}?standalone=true','#services',true,'#loader',true);"><a class="nav-link " href="#server"   data-toggle="tab" id="tab3">{$lang.server} {$lang.service}</a></li>
        {/if}
     {/if}

     </ul>

	<div class="tab-content">
        <div class="tab-pane   fade show active" id="services" role="tabpanel" aria-labelledby="imei">
            <script>
                getContect('#tab','{$imeilink}?standalone=true','#services',true,'#loader');
            </script>
        </div>
  </div>

</div>

    </div>
</div>

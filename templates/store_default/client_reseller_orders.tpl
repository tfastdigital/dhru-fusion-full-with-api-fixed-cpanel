
<div class="container"><div class="page-container">

	<div class="card">

    <ul class="nav nav-pills flex-nowrap">
      	<li class="nav-item " onclick="getContect('#tab1','{$imeilinks}?standalone=true','#tab1',true,'#loader',true);"><a data-toggle="tab" class="nav-link  active"  href="#tab1">{$lang.imeiservice}</a></li>
      	<li class="nav-item " onclick="getContect('#tab2','{$serverlink}?standalone=true','#tab1',true,'#loader',true);"><a data-toggle="tab" class="nav-link " href="#tab2">{$lang.server} Order</a></li>
        <li class="nav-item " onclick="getContect('#tab4','{$shoporderlink}?standalone=true','#tab1',true,'#loader',true);"><a data-toggle="tab" class="nav-link " href="#tab4">{$lang.product} Order</a></li>

    </ul>
    <div class="tab-content">
		<div class="tab-pane  fade active show" id="tab1">
			<script>
				getContect('#tab1','{$imeilinks}?standalone=true','#tab1',true,'#loader',true);
			</script>
		</div>
    </div>
	</div>
	</div></div>


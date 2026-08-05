
<div class="container"><div class="page-container">
	<div class="card">
		<ul class="nav nav-pills flex-nowrap mb-4 bottom-space">
			<li class="nav-item " onclick="getContect('#tab','{$ticketall}?standalone=true','#all',true,'#loader',true);" > <a class="nav-link  active" data-toggle="tab" href="#all"> {$lang.all} </a> </li>
			<li class="nav-item " onclick="getContect('#tab','{$ticketpending}?standalone=true','#pending',true,'#loader',true);"> <a  class="nav-link "   data-toggle="tab" href="#pending" id="tab4"> {$lang.pending} </a> </li>
			<li class="nav-item " onclick="getContect('#tab','{$ticketclose}?standalone=true','#close',true,'#loader',true);"> <a  class="nav-link "   data-toggle="tab" href="#close" id="tab4"> {$lang.close} </a> </li>
			<li class="nav-item " onclick="getContect('#tab','{$ticketaction}?standalone=true','#newticket',true,'#loader',true);"> <a  class="nav-link "   data-toggle="tab" href="#newticket" id="tab4"> {$lang.addnewticket} </a> </li>
	  </ul>
	  <div class="tab-content">
		<div class="tab-pane     fade show active" id="all" role="tabpanel" aria-labelledby="all">
			<script>
				getContect('#tab','{$ticketall}?standalone=true','#all',true,'#loader',true);
			</script>
		</div>
		<div class="tab-pane     fade" id="pending" role="tabpanel" aria-labelledby="pending"></div>
		<div class="tab-pane     fade" id="close" role="tabpanel" aria-labelledby="close"></div>
		<div class="tab-pane     fade" id="newticket" role="tabpanel" aria-labelledby="newticket"></div>
	  </div>
	</div>
	</div></div>

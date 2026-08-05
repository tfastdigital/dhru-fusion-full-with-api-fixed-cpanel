
<div class="container"><div class="page-container">

    <div>

  <div   class="alert"></div>

	<div class="row">
    <div class="col-lg-4">
        <div class="card h-100">
        <div>
            <h5 class="card-title"> <span> {$lang.my} {$lang.store} ({if $companyname}{$companyname}{else}{$lang.nostore}{/if}) </span></h5>
        {if $domain}
            <table class="table border-0">
                <tr><td colspan="2">  {$domain}    </td></tr>
                <tr><td colspan="2" class="link">{$viewmystore}</td></tr>
                <tr><td colspan="2">{$site_name}</td></tr>
                <tr>
                    <td>
                        <span>{$lang.my} {$lang.user}s {$lang.credit} {$lang.left} </span>
                    </td>
                    <td class="text-right">
                        <label class="badge badge-info"><span class="prefix">{$currency.prefix}</span> {$myucredit} {$currency.code}</label>
                    </td>
                </tr>
            </table>
        {else}
            <div class="link">
                <a  href="{$storelink}">{$lang.yourstoreisnotsetup}</a>
            </div>
        {/if}
        </div>
       </div>
    </div>


    <div class="col-lg-4">
        <div class="card h-100">
        <div>
        <h5 class="card-title"> <span> {$lang.commision} {$lang.earned} {$lang.from} {$lang.retail} {$lang.store}</span></h5>

            <div><div class="font-normal text-muted">{$lang.imei}  </div><div>  {if $imeiearn}{$imeiearn}{else}0{/if} {$currency.code}</div></div>
            <div class="my-3"><div class="font-normal text-muted">{$lang.server}  </div><div> {if $serverearn}{$serverearn}{else}0{/if} {$currency.code}</div></div>
            <div><div class="font-normal text-muted">{$lang.shop}  </div><div> {if $productearn}{$productearn}{else}0{/if} {$currency.code}</div></div>

            <div class="link mt-3" >
            <a  href="{$myuserlink}">{$lang.unpaid} {$lang.amount}   {$unpaid} {$currency.code} </a>
            </div>

        </div>
        </div>
    </div>

    <div class="col-lg-4">

        <div class="card h-100">
        <div>
        <h5 class="card-title">
         <span> {$lang.my} {$lang.store} {$lang.user} </span></h5>
        <table class="table border-0">
            <tr><td>{$lang.advance} {$lang.user}   </td><td class="text-right">  {$advance} </td></tr>
            <tr><td>{$lang.regular} {$lang.user}   </td><td  class="text-right">   {$regular} </td></tr>
        </table>
        </div>
        </div>
    </div>
</div>

<div class="card mt-4">


    <ul class="nav  nav-pills flex-nowrap">
        <li class="nav-item "><a href="#tab1" class="nav-link  active"  data-toggle="tab">{$lang.monthly} {$lang.order}</a></li>
        <li class="nav-item "><a href="#tab2" class="nav-link " data-toggle="tab">{$lang.monthly} {$lang.user}</a></li>
        <li class="nav-item "><a href="#tab3" class="nav-link " data-toggle="tab">{$lang.top} 10 {$lang.user}s</a></li>
    </ul>

    <div class="tab-content">
        <div id="tab1" class="tab-pane   active">
			<div class="chart-container" style="position: relative;">
 				<canvas id="monthlyorder"></canvas>
			</div>
        </div>

        <div id="tab2" class="tab-pane ">
            <div class="chart-container" style="position: relative;">
 				<canvas id="monthlyuser"></canvas>
			</div>
        </div>

        <div id="tab3" class="tab-pane ">
		    <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>{$lang.username}</th>
                        <th>{$lang.totalreceipts}</th>
                         <th>{$lang.balance}</th>
                    </tr>
                    </thead>
                    <tbody>
                    {foreach from=$topten key=GroupName item=pro}
                        <tr>
                          <td>{$pro.username}</td>
                          <td>{$pro.receipt} {$currency.code}</td>
                           <td>{$pro.credit_left} {$currency.code}</td>
                        </tr>
                    {/foreach}
                    </tbody>
                </table>
			</div>
        </div>
    </div>
</div>

    </div>

    </div></div>

{literal}

			<script>

var ctx = document.getElementById("monthlyorder").getContext('2d');
var myChart = new Chart(ctx, {
    type: 'line',
    data: {
        datasets: [{
			 label: 'IMEI',
			 data: [{/literal}{$monthlyimei.1}{literal},{/literal}{$monthlyimei.2}{literal},{/literal}{$monthlyimei.3}{literal},{/literal}{$monthlyimei.4}{literal},{/literal}{$monthlyimei.5}{literal},{/literal}{$monthlyimei.6}{literal},{/literal}{$monthlyimei.7}{literal},{/literal}{$monthlyimei.8}{literal},{/literal}{$monthlyimei.9}{literal},{/literal}{$monthlyimei.10}{literal},{/literal}{$monthlyimei.11}{literal},{/literal}{$monthlyimei.12}{literal}],
			borderColor: 'rgba(255,99,132,1)'
		  },{
			 label: 'File',
			 data: [{/literal}{$monthlyfile.1}{literal},{/literal}{$monthlyfile.2}{literal},{/literal}{$monthlyfile.3}{literal},{/literal}{$monthlyfile.4}{literal},{/literal}{$monthlyfile.5}{literal},{/literal}{$monthlyfile.6}{literal},{/literal}{$monthlyfile.7}{literal},{/literal}{$monthlyfile.8}{literal},{/literal}{$monthlyfile.9}{literal},{/literal}{$monthlyfile.10}{literal},{/literal}{$monthlyfile.11}{literal},{/literal}{$monthlyfile.12}{literal}],
			  borderColor: 'rgba(54, 162, 235, 1)'
		  }, {
			 label: 'Server',
			 data: [{/literal}{$monthlyserver.1}{literal},{/literal}{$monthlyserver.2}{literal},{/literal}{$monthlyserver.3}{literal},{/literal}{$monthlyserver.4}{literal},{/literal}{$monthlyserver.5}{literal},{/literal}{$monthlyserver.6}{literal},{/literal}{$monthlyserver.7}{literal},{/literal}{$monthlyserver.8}{literal},{/literal}{$monthlyserver.9}{literal},{/literal}{$monthlyserver.10}{literal},{/literal}{$monthlyserver.11}{literal},{/literal}{$monthlyserver.12}{literal}],
			  borderColor:  'rgba(255, 206, 86, 1)'
		  }],
		labels: [
			'Jan',
			'Feb',
			'Mar',
			'Apr',
			'May',
			'Jun',
			'Jul',
			'Aug',
			'Sep',
			'Oct',
			'Nov',
			'Dec'
		]
    },
    options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero:true
                }
            }]
        }
    }
});


var ctx = document.getElementById("monthlyuser").getContext('2d');
var myChart = new Chart(ctx, {
    type: 'bar',
    data: {
        datasets: [{
			 label: 'Users',
			 data: [{/literal}{$monthlyuser.1}{literal},{/literal}{$monthlyuser.2}{literal},{/literal}{$monthlyuser.3}{literal},{/literal}{$monthlyuser.4}{literal},{/literal}{$monthlyuser.5}{literal},{/literal}{$monthlyuser.6}{literal},{/literal}{$monthlyuser.7}{literal},{/literal}{$monthlyuser.8}{literal},{/literal}{$monthlyuser.9}{literal},{/literal}{$monthlyuser.10}{literal},{/literal}{$monthlyuser.11}{literal},{/literal}{$monthlyuser.12}{literal}],
			 borderColor: 'rgba(255,99,132,1)'
		  }],
		labels: [
			'Jan',
			'Feb',
			'Mar',
			'Apr',
			'May',
			'Jun',
			'Jul',
			'Aug',
			'Sep',
			'Oct',
			'Nov',
			'Dec'
		]
    },
    options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero:true
                }
            }]
        }
    }
});


</script>




{/literal}


<div class="container"><div class="page-container">
    <div class="card">
        <div class="row">
            <div class="col-lg-12 mx-auto">

                <ul class="nav nav-pills flex-nowrap">
                    <li class="nav-item "><a class="nav-link  active" data-toggle="tab" href="#tab1">
							<span onclick="getContect('#tab1','{$overviewlink}','#tabcontent3',true,'#loader',true);"> {$lang.overview} </span></a>
                    </li>
                    <li class="nav-item "><a class="nav-link " data-toggle="tab" href="#tab2">
							<span onclick="getContect('#tab2','{$creditlink}','#tabcontent3',true,'#loader',true);">{$lang.add}/{$lang.rebate} {$lang.credit}</span></a>
                    </li>

                    <li class="nav-item "><a class="nav-link " data-toggle="tab" href="#tab6">
							<span onclick="getContect('#tab4','{$satementlink}','#tabcontent3',true,'#loader',true);">{$lang.statement} / {$lang.add} {$lang.payment}</span></a>
                    </li>

                </ul>
                <div class="tab-content">
                    <div class="tab-pane   fade show active" id="tabcontent3"></div>
                </div>
            </div>
        </div>
    </div>
    </div></div>
<script>
    $(document).ready(function () {
        getContect('#tab1', '{$overviewlink}', '#tabcontent3', true, '#loader',true);
    });
</script>

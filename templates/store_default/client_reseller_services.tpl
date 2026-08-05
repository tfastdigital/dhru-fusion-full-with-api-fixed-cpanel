<div class="container"><div class="page-container">

    <div class="card">

        <ul class="nav nav-pills flex-nowrap">
            <li class="nav-item "><a data-toggle="tab"   class="nav-link active cursor-pointer" onclick="getContect('#tab1','widget/resellerservice/imei','#tabcontent1',true,'#loader',true);" id="tab1">{$lang.imei} {$lang.services}</a></li>
            <li class="nav-item "><a data-toggle="tab"   class="nav-link cursor-pointer" onclick="getContect('#tab3','widget/resellerservice/server','#tabcontent1',true,'#loader',true);" id="tab3">{$lang.server} {$lang.services}</a></li>
            <li class="nav-item "><a data-toggle="tab"   class="nav-link cursor-pointer" onclick="getContect('#tab4','widget/resellerservice/shop','#tabcontent1',true,'#loader',true);" id="tab4">{$lang.shopping} {$lang.item}</a></li>
        </ul>
        <div class="tab-content mt-3">
            <div id="tabcontent1"></div>
        </div>

    </div>

    </div></div>

{literal}
    <script>
        getContect('#tab1','widget/resellerservice/imei','#tabcontent1',true,'#loader');
    </script>
{/literal}


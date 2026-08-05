<script>
getContect('#tab1','{$emaillink}','#tabcontent1',true,'#loader');
</script>
    <ul id="tabmenu" >
        <li><a class="tabmenu_active" onclick="getContect('#tab1','{$emaillink}','#tabcontent1',true,'#loader');" id="tab1">{$lang.systememail}</a></li>
        <li><a onclick="getContect('#tab2','{$storelink}','#tabcontent1',true,'#loader');" id="tab2">{$lang.mysite}</a></li>
        <li><a onclick="getContect('#tab3','{$indexlink}','#tabcontent1',true,'#loader');" id="tab3">{$lang.indexcontent}</a></li>
        <div class="clearboth"></div>
    </ul>
    <div id="tabcontent1"></div>
</div>
{include file="templates/default/client_reseller_rightmenu.tpl"}

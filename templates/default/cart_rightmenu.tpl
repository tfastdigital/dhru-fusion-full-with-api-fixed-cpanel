{if $resellerstore}


        <div class="col-lg-3">
            <div class="sidebar card d-none d-lg-block">
                {if $cart}
                    <div class="cart border-0">
                        <div class="nav-header">Categories</div>

                        {foreach from=$groupheiarachy key=id item=gid}
                            {foreach from=$groupdetail key=cid item=name}
                                {if $id eq $cid}
                                    <a class="parent-category" href="{$name.seo}">{$name.name} </a>

                                    {if $groupdetail[$cid].sub}
                                        {foreach from=$groupdetail[$cid].sub key=cid item=name}
                                            {if $cid eq $currecntgroupid}
                                                <a class="current-category" href="{$name.seo}"> <span>{$name.name}</span> </a>
                                            {/if}
                                        {/foreach}
                                    {/if}

                                {/if}
                            {/foreach}

                            {foreachelse}
                                <a class="current-category" href="{$groupdetail[$currecntgroupid].seo}"> <span>{$groupdetail[$currecntgroupid].name}</span> </a>
                        {/foreach}

                        <ul class="sidebar-child-items">
                            {if $groupdetail[$currecntgroupid].sub}
                                {foreach from=$groupdetail[$currecntgroupid].sub key=id item=name}
                                    <li>
                                        <a href="{$name.seo}">{$name.name} </a>
                                    </li>
                                {/foreach}
                            {/if}
                        </ul>
                    </div>
                {/if}



                <div id="features"></div>


                {literal}
                    <script>
                        getContect('#features','{/literal}{$featurelink}{literal}','#features',true,'#loader');
                    </script>
                {/literal}

            </div>

            <div class="modal hide sidebar-modal" tabindex="-1" id="navbarsidebar" role="dialog">
                <div class="modal-dialog h-100 m-0" role="document">
                    <div class="modal-content h-100 rounded-0">
                        <div class="modal-header p-3">
                            <h4 data-dismiss="modal"> <i class="fa fa-arrow-left"></i>  &nbsp;  Filter </h4>
                        </div>
                        <div class="modal-body overflow-auto p-1">
                            <div id="features2"></div>
                            {literal}
                            <script>
                                getContect('#features2','{/literal}{$featurelink}{literal}','#features2',true,'#loader');
                            </script>
                            {/literal}
                        </div>
                    </div>
                </div>
            </div>

        </div>

    {/if}





    {literal}
        <style type="text/css">
            .sidebar{
                border: transparent solid 1px;
                padding: 0px;
            }
            .sidebar ul{
                list-style: none;
                margin:0;
                padding:0;
            }
            .sidebar .cart{
                padding:15px;
                border-top: #ddd solid 1px;
            }
            .sidebar ul.catloglist li a{
                color:#999;
            }
            .sidebar .sidebar-child-items{
                padding-left: 3px;
            }
            .sidebar .sidebar-child-items a{
                display: block;
                padding:3px 10px;
            }
            .sidebar .sidebar-child-items a:hover{
                background: #eee;
            }
            .sidebar   a.parent-category,.sidebar   a.current-category{
                position: relative;
                padding-left: 15px;
                display: flex;
                align-items: center;
                color:#888
            }
            .sidebar a.current-category{
                color:black
            }
            .sidebar   a.parent-category:after,.sidebar   a.current-category:after{
                content:"\f053";
                position: absolute;
                left:0;
                font-family: "Font Awesome 5 Pro";
                font-size: 12px;
            }
            .sidebar   a.current-category:after{
                content:"\f078";
            }
            .sidebar .catloglist input[type="text"]{
                align-items: center;
                vertical-align: middle;
            }
            input[name="findbyprice"]{
                margin-left: 0.5rem;
            }
            .sidebar .nav-header{
                font-weight: 600;
                text-transform: uppercase;
                margin-bottom: 10px;
            }

            .sidebar-modal .cart{
                padding: 15px;
                border-bottom: #eee solid 1px;
            }
            .sidebar-modal .cart .catloglist{
                 padding: 0;
            }
            .sidebar-modal .filter-features{
                list-style: none;
                padding: 0;
            }
            .sidebar-modal .nav-header{
                font-weight: 600;
                text-transform: uppercase;
                margin-bottom: 10px;
            }
            .sidebar-modal .catloglist input[type="text"]{
                border: #ccc solid 1px;
                margin-right: 5px;
                border-radius: 3px;
                align-items: center;
                vertical-align: middle;
            }
        </style>
    {/literal}

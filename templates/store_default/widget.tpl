{literal}
    <style>
        .fHeight{height:200px;overflow:hidden;padding:10px;}
        .header{color:black;padding:5px;margin:-10px -10px 5px -10px;font-size:15px;}
        #serviceDetails .creditCost label{}
        .span4.alert1{border-radius: 10px;}
        .accordion-inner{padding:10px 0px;}
        .nav-list{border-radius:0;}
        .accordion-group{margin-bottom:20px;margin-top:0;}
        .accordion-heading{background:none;}
        .display-block{width:195.9px}
       .accordion-heading .accordion-toggle {
           background:#eee;
        }
        footer{border:none !important}
        .nav-list > li > a, .nav-list .nav-header{margin:0}
        .sidebar .nav-header {
            background: none repeat scroll 0 0 #F4F4F4;
            padding: 5px 10px !important;
        }
        .nav-list{padding-bottom:0;}

        .quick_checkout .form-group {width:19%;}
        .quick_checkout .form-group  select{width:100%}
        .nav-list{padding-top:0}
        .why h2 {
            border-bottom: 1px solid #D4D4D4;
            color: #FF8F00;
            font-size: 14px;
            margin: 0 0 10px;
            padding: 0 0 5px;
        }
        .hot{position:relative;top:auto;float:right}
        h4{padding:5px 10px;margin-bottom:20px;}
    </style>

   <script>
        $(document).ready(function(){
            $("a[data-target*='modal']").click(function(ev) {
        		var cur = $(this).attr('data-target');
        		ev.preventDefault();
        		var target = $(this).attr("href");
                getContect('#tab',target,cur+" .modal-body",true,'#loader');
        	});
        });


        $(document).ready(function () {
            $(".display-grid").gridalicious({
                width:200,
                gutter: 20,
                animate: true,
                animationOptions: {
                    speed: 50,
                    duration: 100,
                    complete: onComplete
                },
            });
            function onComplete(data) {

            }
        });

    </script>



{/literal}

<div id="modal1" class="modal hide fade"   style="width:960px;margin-left:-480px;">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span>&times;</span></button>
        <h3>{$lang.quickview}</h3>
    </div>
    <div class="modal-body" style="max-height:500px;overflow-y:auto">

    </div>
    <div class="modal-footer">
        <a href="#" data-dismiss="modal" class="btn">{$lang.close}</a>
    </div>
</div>

<div class="subcontainerfullwidth" style="margin: 0;padding:0">




<div style="background:white;padding:30px 0 0px 0">
    <div class="container content-fluid">


        {if $resellerstore}

        {else}

            <div style="width:width:1197px;margin-right:-30px">
                <a href="storefeatures.html" >
                    <img src="templates/default/images/reseller-banner.jpg" style=""/>
                </a>
            </div>

       {/if}

    </div>
</div>


<div style="background:white;text-align:left">




    <div class="row-fluid">
       {include file="templates/default/cart_rightmenu.tpl"}
   </div>



   <div class="clearfix"></div>
 </div>




   </div>
</div>

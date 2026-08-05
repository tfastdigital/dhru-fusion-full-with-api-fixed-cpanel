<script type="text/javascript" src="includes/js/lightbox.js"></script>
<link rel="stylesheet" type="text/css" href="includes/css/lightbox.css" media="screen" />

	{literal}
	<script>
        jQuery(document).ready(function(){
             $('a.gallery').lightBox();

            var url = document.location.toString();
            if (url.match('#')) {
                $('.nav-tabs a[href="#'+url.split('#')[1]+'"]').tab('show');
            }

            $("[data-toggle=popover]").popover().click(function(e) {
                e.preventDefault();
            });

         });
     </script>
	<style>
        .gallery img {
            width: 110px;
            border: #f4f4f4 solid 3px;
            margin: 3px;
        }
    </style>
	{/literal}



<div class="container"><div class="page-container">



	{if $isiframe}
	   <iframe src="{$siteurl}/cms.php?pageid={$pageid}&action=showiframe" style="width:100%;border:0;min-height:600px" name="childframe" id="childframe"></iframe>
	{else}
	   {eval var=$body}
	{/if}

    <div id="iframe"></div>
    </div></div>

	{literal}
    	<script>
            $('#childframe').load(function()
            {
                document.getElementById('childframe').style.height = document.getElementById('childframe').contentWindow.document.body.scrollHeight + 20 +"px";
            });
        </script>
	{/literal}

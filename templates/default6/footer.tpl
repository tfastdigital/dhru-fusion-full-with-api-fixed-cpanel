<div class="text-center">
    {if $adds_index.4 or $adds_login.4 or $adds_productdetails.4}
        <div style="text-align: center;padding:10px 0;margin-bottom:10px">{$adds_index.4} {$adds_login.4} {$adds_productdetails.4}</div>
    {/if}

    {if $adds.4}
        <div style="margin-bottom:20px">
            {$adds.4}
        </div>
    {/if}
</div>


</div>
</div>
</div>
<div>


    {include file="templates/default/chunks/footer-links.tpl"}


</div>


</div>

{include file="templates/default/chunks/footer-modals.tpl"}

{literal}
    <script>
        $(document).ready(function() {
            var o=function(){
                if($(this).scrollTop()>100){
                    $(".index .header").addClass("navbar-shrink");
                }
                else{
                    $(".index .header").removeClass("navbar-shrink");
                }
            };

            if($(window).width()>992){
                o();
                $(window).scroll(o);
            }
        });
    </script>
{/literal}

</body></html>

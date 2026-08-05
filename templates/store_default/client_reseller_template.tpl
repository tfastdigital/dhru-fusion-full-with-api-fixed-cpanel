
    <div class="py-3 px-1">
<form method="post" name="imeipricing" id="imeipricing">
    <div class="table-responsive">



            {foreach from=$emailtemplatelist key=GroupName item=Temp}
                <table class="table border-0 table-striped">
                    <thead>
                        <tr>
                            <th colspan="2"><h5 class="m-0">{$GroupName}</h5></th>
                        </tr>
                    </thead>
                    {foreach from=$Temp key=id item=email}

                        <tr class="href w-100" href="{$email.link}?standalone=true" role="button" data-toggle="modal"
                            data-whatever="{$email.name}" data-target="#modal-ajax">
                            <td>{$email.name} </td>
                            <td class="text-right"><i class="fal fa-edit"></i></td>
                        </tr>
                        {foreachelse}
                            <tr>
                                <td colspan="4">{$lang.norecordsfound}</td>
                            </tr>

                    {/foreach}

                </table> <br/><br/>
            {/foreach}



    </div>
</form>
    </div>

{literal}
    <script>
        $("a[data-target*='modal']").click(function (ev) {
            var cur = $(this).attr('data-target');
            ev.preventDefault();
            var target = $(this).attr("href");
            getContect('#tab', target, cur + " .modal-body", true, '#loader');
        });
    </script>
{/literal}

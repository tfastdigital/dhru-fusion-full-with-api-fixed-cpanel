{literal}
    <script type="text/javascript">

        function popupOrder2(ServicesID,servicename){
            if(servicename==''){
                servicename='Place Order';
            }
            $('.service-title').text(servicename);
            $('#service-id').val(ServicesID);

            $('#modal-order2').show();
            getServicedetailsIMEI(ServicesID,'#serviceDetails2','.alert',true,'#loader2','','','#information',0);
        }

    </script>
{/literal}


<div class="table-responsive">
    <table class="table align-items-center  table-hover table-striped">
        <tbody>
            {foreach from=$servicelist key=id item=serv}
                {if $serv.service_name}
                    <tr>
                        <td class="w-100"><span>{$serv.service_name}  </span> </td>
                        <td>
                            <button class="btn btn-primary" type="button"  onclick="popupOrder2('{$serv.id}','{$serv.service_name}');"> {$lang.placeorder}</button>
                        </td>
                    </tr>
                {/if}

            {foreachelse}
                <div class="text-center p-3 text-muted">
                    {$lang.nofrequentlyusedservicefound}, <br />
                    {$lang.toshowservicesinthisarea}  <br /> {$lang.pleaseselecttickbox}  <br /> {$lang.fromplaceorderpage}
                    <br />
                    <img src="templates/default/images/frequntly-used.png" />
                </div>
            {/foreach}
        </tbody>
    </table>
</div>




<div id="modal-order2" class="modal  modal-ajax" tabindex="-1" style="display: none">
    <div class="backdrop-over"></div>
    <div class="modal-dialog modal-dialog-centered modal-xl mx-auto">
        <div class="modal-content rounded">
            <div class="modal-header">
                <h5 class="modal-title service-title"> {$lang.placeorder}</h5>
                <button type="button" class="close" onclick="$('#modal-order2').hide()"  aria-hidden="true"> <span class="d-none d-md-block">&times;</span><span class="d-block d-md-none"><i class="fal fa-arrow-left"></i> </span> </button>
            </div>
            <div class="modal-body">
                <form method="post" name="imeiorder_form" id="imeiorder_form">
                    {$token}
                    <input type="hidden" id="service-id" name="id"/>
                    <input type="hidden" id="service-name" name="servicename"/>
                    <div id="serviceDetails2" class="position-relative">
                        <div class="">
                            <h2 class="p-5 text-center mt-5" style="color:#ccc;font-weight:100;">
                                <i class="fas fa-arrow-up"></i>&nbsp;&nbsp;
                                <div>
                                    {$lang.select} {$lang.service}
                                </div>
                            </h2>
                        </div>
                    </div>
                    <div id="loader2" style="display: none">
                        <div class="position-absolute d-flex justify-content-center align-items-center w-100 h-100 text-center" style="top:0;left:0;">
                            <div class="ajax-responsive loading"></div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

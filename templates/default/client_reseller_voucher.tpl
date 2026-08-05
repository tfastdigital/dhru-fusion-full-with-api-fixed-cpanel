{literal}
<script>
    function generateVoucher()
    {
        var cnt=document.getElementById('nocode').value;

        var length=20;
        var buf='';
        var chars = '123456789ABCDEFGHIJKLMNPQRSTUVWXTZ'.split('');
        for(var j=0;j<cnt;j++){

            if (! length) {
                length = Math.floor(Math.random() * chars.length);
            }

            var str = '';
            for (var i = 0; i < length; i++) {
                str += chars[Math.floor(Math.random() * chars.length)];
            }
            if(buf!=''){
                buf=buf+"\r\n"+str;
            }else { buf=str; }

        }

        document.getElementById('voucher').value=buf;

    }
</script>
{/literal}
<div class="container"><div class="page-container">
    <div   class="alert "></div>
    <div class="tab-pane pt-3" >
        <form  method="post" id="frmvoucher" enctype="multipart/form-data">
            {$token}

            <div class="form-group">
                <label>{$lang.generate} {$lang.recharge} {$lang.code}</label>
                <div class="input-group">
                    <input type="text" class="form-control " id="nocode" name="nocode" />
                    <div class="input-group-append">
                        <button type="button" class="btn input-group-text btn-primary"
                                onclick="generateVoucher();"
                                id="createcode" name="createcode"  >Generate Voucher </button>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label>{$lang.code} {$lang.list}</label>
                <div class="input-group">
                    <textarea class="form-control " id="voucher" name="voucher" ></textarea>

                </div>
            </div>
            <div class="form-group">
                <label>{$lang.credit} {$lang.amount}</label>
                <div class="input-group">
                    <input type="text" class="form-control" name="credit" />

                </div>
            </div>
        </form>

        <div class="form-group ">
            <button type="button" id="btnv" class="btn input-group-text btn-primary"
onclick="SubmitForm('#btnv','includes/getdata/reseller.save.php?action=voucher','#frmvoucher','.alert','true','#loader');"
                    name="createvoucher">Create Voucher</button>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead>
            <tr>
                <th>{$lang.code}</th>
                <th>{$lang.credit}</th>
                <th>{$lang.status}</th>
                <th>{$lang.action}</th>
            </tr>
            </thead>
            <tbody>

            {foreach from=$voucherlist key=id item=voucher}
                <tr>
                    <td>{$voucher.code}</td>
                    <td>{$voucher.amount}</td>
                    <td>{$voucher.used}</td>
                    <td>
                        {if $voucher.used eq 'Pending'}
                        <a href="reseller.php?action=voucher&rem={$voucher.md5id}">{$lang.remove}</a>
                        {/if}</td>
                </tr>
                {foreachelse}
                <tr>
                    <td  class="text-center" colspan="4">{$lang.norecordsfound}</td>
                </tr>
            {/foreach}
            </tbody>

        </table>
    </div>
    </div></div>

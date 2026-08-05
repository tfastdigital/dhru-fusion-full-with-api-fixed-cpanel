<div class="container"><div class="page-container">

    <div class="card card-simple-form">

        <form method="post" name="savepassword" id="savepassword">
            {$token}




            <div class="row">
                <div class="col-lg-4 m-auto">
                    <div class="alert"></div>
                    <div class="form-group ">
                        <span class="text-muted font-normal">{$lang.from} : </span>
                       <h5> {$userdetails.firstname} {$userdetails.lastname}
                           <small class="text-muted"> ({$userdetails.email}) </small>
                       </h5>
                    </div>

                    <div class="form-group ">
                        <label>
                            {$lang.to_} <small>({$lang.gift} {$lang.recipient} {$lang.email})</small>
                        </label>
                        {$to}
                    </div>

                    <div class="form-group ">
                        <label>
                            {$lang.amount}
                        </label>
                        <div class='input-group mb-4 bottom-space'>
                            {$amount}
                        </div>
                    </div>

                    <div class="form-group ">
                        <label>
                            {$lang.paymentmethod}
                        </label>


                        <select name="paymentmethod" class="form-control ">
                            {foreach key=num item=gateway from=$gateways}
                                <option value="{$gateway.sysname}">{$gateway.name}</option>
                            {/foreach}
                        </select>

                    </div>

                    <div class="form-group">
                        <label>
                            {$lang.message}
                        </label>

                        {$message}
                        <div class="text-muted"> {$lang.recipient} {$lang.message} </div>

                    </div>

                    <div class="d-actionbar-mobile">

                    <button type="submit" class="btn btn-primary w-100" id="chagepassword"
                            onClick="SubmitForm('#chagepassword','{$action_link}','#savepassword','.alert','true','#loader');"
                            name="changepassword" value="{$lang.generate} {$lang.giftcerti}">
                        {$lang.generate} {$lang.giftcerti}
                    </button>

                    </div>

                </div>

            </div>




        </form>
    </div>

    </div></div>

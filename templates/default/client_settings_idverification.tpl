<div class="container"><div class="page-container">

    <div class="card">

        <div class="inner-container">
            {if $status eq '2'}
                <div class="alert d-block  alert-danger">Document verification rejected - {$reason}</div>
            {elseif $status eq '1'}
                <div class="alert d-block m-0 alert-success">Document verified</div>

            {elseif $status eq '0'}
                <div class="alert d-block alert-success">Document already submitted we will review asap.</div>
            {/if}
        </div>


        {if $status neq '0' && $status neq '1'}

        <form  method="post" name="verification" enctype="multipart/form-data" id="verification">
            <input type="submit" style="display:none;"/>

            <div class="inner-container">

                <div  class="alert alert-pin">
                </div>
                <div  class="alert d-block alert-info">
                    KYC or ‘Know Your Customer’ is a mandatory verification procedure. Provide us one of this document to complete KYC verification procedure.
                </div>

            </div>

            {$token}

            <div class="row">

            <div class="{if !$standalone}col{else}w-100{/if}">
            <div class="form-group">
                <label>
                    {$lang.contactno} <span class="text-muted"> * </span>
                </label>
                <input type="text" placeholder="Contact no" required  name="contactno" value="{$contact}" class="form-control">
            </div>

            <div class="row">
                <div class="form-group col-lg-6">
                    <label>
                        {$lang.city} <span class="text-muted"> * </span>
                    </label>
                    <input type="text" placeholder="City" required name="city" value="{$city}" class="form-control">
                </div>
                <div class="form-group col-lg-6">
                    <label>
                        PIN Code <span class="text-muted"> * </span>
                    </label>
                    <input type="text" placeholder="Pin Code" required name="pin" value="{$pin}" class="form-control">
                </div>
            </div>

            <div class="row">
                <div class="form-group col-lg-6">
                    <label>
                        {$lang.country} <span class="text-muted"> * </span>
                    </label>
                    {$country}
                </div>
                <div class="form-group col-lg-6">
                    <label>
                        {$lang.state} <span class="text-muted"> * </span>
                    </label>
                    <input type="text" required placeholder="State" name="state" value="{$state}" class="form-control">
                </div>
            </div>

            <div class="row">
                <div class="form-group col-lg-6">
                    <label>
                        Document Type <span class="text-muted"> * </span>
                    </label>
                    <select class="form-control no-chosen" required name="doctype" onchange="setField(this.value)">
                        <option {if $doctype eq 'Passport'} selected {/if}>Passport</option>
                        <option {if $doctype eq 'Driving License'} selected {/if}>Driving License</option>
                        <option {if $doctype eq 'Bank Statement'} selected {/if}>Bank Statement</option>
                        <option {if $doctype eq 'Utility Document'} selected {/if}>Utility Document</option>
                        <option {if $doctype eq 'Other'} selected {/if}>Other</option>
                    </select>
                </div>
                <div class="form-group col-lg-6">
                    <label>
                        Document <span class="text-muted"> * </span>
                    </label>
                    <input type="file" required class="form-control file" name="document">
                </div>
            </div>

                <div class="row">
                    <div class="form-group col-lg-12">
                        <label>
                            Other Document
                        </label>
                        <input type="file" class="form-control file" name="statement">
                    </div>
                </div>

            <div class="row">
                <div class="form-group col-lg-12" id="other" style="display: none">
                    <label>
                        Other
                    </label>
                    <textarea class="form-control" name="other" placeholder="Other">{$other}</textarea>
                </div>
                <div class="form-group col-lg-12">
                    <label>
                        User Notes
                    </label>
                    <textarea class="form-control" name="notes" placeholder="User Notes">{$notes}</textarea>
                </div>
            </div>
            {if $status eq '1'}

            {else}
                <div class="d-actionbar-mobile">
                <button type="button" onclick="validation()"  style="{if $standalone}display:none{/if}" id="idverification-btn" class="btn btn-primary"   value="{$lang.save}" >
                    {$lang.save}
                </button>
                </div>
            {/if}


    </div>

                {if $idhelperimage}
                <div style="max-width:600px">

                    <div  class="{if !$standalone}p-0 p-sm-3{/if}">
                    <div class="mb-4 bottom-space">
                        Please upload selfie image with your passport or ID and white paper have the current date (all in the same selfie) and all data should be readable
                    </div>


                    <div class="position-relative">
                        <img src="templates/default/images/id-selfee.png"/>
                        <div class="position-absolute" style="top:20px;left:50px;width:200px;height:50%">
                            <div class="text-center mt-5"> <h5 class="text-dark"> {$companyname}</h5> </div>

                            <div class="text-center"> Current Date <h6>Ex. {$smarty.now|date_format:"%D"}</h6> </div>

                        </div>
                    </div>
                    <div class="text-center mt-3"> <small class="text-muted">Selfie Example </small> </div>
                    </div>

                </div>
                {/if}
        </form>
        {/if}
</div>

</div>

</div>


<script>

    function validation(){
        if (!$('#verification')[0].checkValidity()) {
            $('form').find('input[type="submit"]').click();
            return false;
        }
        SubmitFormFile('#idverification-btn','{$actionlink}','#verification','.alert-pin','true','#loader','','','','','',{if $standalone}true{else}false{/if},{if $standalone}function(data){  verificationSuccess()  }{/if});
    }



    function setField(value) {
        if(value == 'Other'){
            $('#other').show();
        }
        else{
            $('#other').hide();
        }
    }

</script>

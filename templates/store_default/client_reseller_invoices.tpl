<div class="container"><div class="page-container">


    <div class="table-responsive">

        <table class="table table-bordered table-striped table-hover">
            <thead>
            <tr>
                <th>{$lang.invoice} </th>
                <th>{$lang.user} </th>
                <th>{$lang.amount} </th>
                <th>{$lang.date} </th>
                <th>{$lang.status}</th>
                <th>{$lang.action}</th>
            </tr>
            </thead>
            {foreach from=$invoices key=id item=det}
                <tr>
                    <td>{$det.id}</td>
                    <td>{$det.username}</td>
                    <td>{$det.total}</td>
                    <td>{$det.date}</td>
                    <td>{$det.status}</td>
                    <td>{$det.action}</td>
                </tr>
            {/foreach}
        </table>

    </div>

    </div></div>

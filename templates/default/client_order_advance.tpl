<script src="templates/default/js/handsontable.full.min.js"></script>
<link href="templates/default/css/handsontable.full.min.css" rel="stylesheet">


<div class="container container-advance-history mw-100"><div class="page-container">
    <div class="card">


        <form method="post" name="filterorders" id="filterorders">
            <div class="form-row">

                <div class="form-group  col">
                    <select name="type" class="form-control  no-chosen">
                        <option value="all" selected="selected">{$lang.all}</option>
                        <option value="imei">{$lang.imei}</option>
                        <option value="server">{$lang.server}</option>
                        <option value="remote">{$lang.remote}</option>
                    </select>
                </div>

                <div class="form-group  col">
                    <input type="text" autocomplete="off" data-date-format="yyyy-mm-dd"  name="startdate"   placeholder="{$lang.from} {$lang.date}" id="from"  class="form-control "  />
                </div>
                <div class="form-group   col">
                    <input type="text" name="enddate" autocomplete="off" id="to" data-date-format="yyyy-mm-dd"   placeholder="{$lang.to} {$lang.date}"   class="form-control " />
                </div>

                <div class="form-group   col">
                    <button type="submit" id="btn-filterorders" class="btn btn-success"
                       onclick="SubmitFormJSON('#btn-filterorders','{$advanceorderlink}','#filterorders','.alert','true','#loader',true,'',function(data) {
                               getOrders(data);
                       });"
                      value="{$lang.search}" name="searchbulk" >{$lang.search}</button>
                </div>

                {*<div class="form-group  ">
                    <button type="submit" id="export-file" class="btn btn-warning"
                            value="{$lang.export}" name="export" >{$lang.export} CSV</button>
                </div>*}


            </div>

        </form>



        <div id="dataTable"></div>



    </div>
    </div></div>



{literal}
    <script>
        function getOrders(response) {
            const data = response.data;
            const header = response.header;

            $('#dataTable').html('');

            const container = document.getElementById('dataTable');


            const hot = new Handsontable(container, {
                data: data,
                rowHeaders: false,
                colHeaders: header,
                columnSorting: {
                    indicator: true
                },
                filters: true,
                dropdownMenu: true,
                multiColumnSorting: {
                    indicator: false
                },
                /*exportFile: true,*/
                licenseKey: 'non-commercial-and-evaluation'
            });


           /* var exportfile = document.getElementById('export-file');
            var exportPlugin = hot.getPlugin('exportFile');

            exportfile.addEventListener('click', function() {
                exportPlugin.downloadFile('csv', {
                    bom: false,
                    columnDelimiter: ',',
                    columnHeaders: true,
                    exportHiddenColumns: true,
                    exportHiddenRows: true,
                    fileExtension: 'csv',
                    filename: 'Order-Export-CSV-file_[YYYY]-[MM]-[DD]',
                    mimeType: 'text/csv',
                    rowDelimiter: '\r\n',
                    rowHeaders: false
                });
            });*/


        }





        $(function() {
            var nowTemp = new Date();
            var now = new Date(nowTemp.getFullYear(), nowTemp.getMonth(), nowTemp.getDate(), 0, 0, 0, 0);
            $('#from,#to').datepicker({ format: 'yyyy-mm-dd'}).on('changeDate', function(e){
                $(this).datepicker('hide');
            });

            SubmitFormJSON('#btn-filterorders','{/literal}{$advanceorderlink}{literal}','#filterorders','.alert','true','#loader','','',function(data){
                getOrders(data);
            });

        });
    </script>


    <style>
        .handsontable td, .handsontable th {
            padding: 0.2rem;
        }
        .handsontable th{
            background: #f5f5f5;
        }
    </style>




{/literal}

{literal}
    <script>
        $(document).ready(function(){
            $("[data-toggle='tooltip']").tooltip(); 
            
            $('div.controls').on('focus','input[type="text"],textarea',function(){                
                $(this).closest('.controls').addClass('focus');
            });
            
            $('div.controls').on('blur','input[type="text"],textarea',function(){        
                $('.controls.focus').removeClass('focus');        
            });
                        
        });
    </script>
    
{/literal}

<!--  Credit/Time Field  -->
{if $customfields}
<div class="price_detail" style="padding: 0;margin-bottom:5px;">
  <table style="width: 100%;" cellspacing="10">
    {foreach from=$customfields key=name item=fields}
        <tr>
        {if $fields.type eq 'radio'}
            <td colspan="2">
            <fieldset style="padding: 5px; ">
            <legend >{$name}</legend>
               {$fields.input}<br /><small style="color: #ccc;">{$fields.description}</small> 
            </fieldset>
            </td>
        {else}
          <td style="font-size:11px;"><label>{$name}</label></td>
          <td style="">{$fields.input}{$fields.required}<br /><small style="color: #ccc;">{$fields.description}</small></td>
        {/if}
        </tr>
    {/foreach}
  </table>
</div>
{/if} 
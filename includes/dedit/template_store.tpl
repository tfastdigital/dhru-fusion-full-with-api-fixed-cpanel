<link rel="stylesheet" media="screen" type="text/css" href="{$siteurl}/includes/colorpicker/css/colorpicker.css" />
<script type="text/javascript" src="{$siteurl}/includes/colorpicker/js/colorpicker.js"></script>
<script type="text/javascript" src="{$siteurl}/includes/js/template.editor2.js"></script>
<script src="{$siteurl}/includes/js/draggable/jquery.ui.core.js"></script>
<script src="{$siteurl}/includes/js/draggable/jquery.ui.widget.js"></script>
<script src="{$siteurl}/includes/js/draggable/jquery.ui.mouse.js"></script>
<script src="{$siteurl}/includes/js/draggable/jquery.ui.draggable.js"></script>

{literal}
<script>
    function newWindow(file,window){
        msgWindow=open(file,window,'scrollbars=yes,resizable=no,width=550,height=400');
        if (msgWindow.opener == null) msgWindow.opener = self;
    }
</script>
{/literal}
<link rel="stylesheet" media="screen" type="text/css" href="{$siteurl}/includes/dedit/style.css" />

<div class="editor" style="display:none;">
<div class="admineditor">
    <div id="notification10" style="z-index:9999;position: absolute;margin:0;left:350px;top:5px;padding:10px;right:350px;text-align:center;font-size:12px"></div>
   <ul style="list-style:none;float:right" class="editorul">
         <li style="background-image:none;padding:0 5px"><span  class="activeeditor">Active Editor</span> </li>
         <li class="seperatorli">&nbsp;</li>
       <div class="clear"></div>
  </ul>
    <div class="clear"></div>
    <div class="editorcontent">
        <form class="adminForm" name="adminForm" id="adminForm">
            <input type="hidden" id="seteditor" value="0"/>
        <div class="editorinnerelements">
        <div class="mainpanel">Editor Panel <span style="float: right;" class="closeall">X</span></div>
 <div style="font-size:10px;text-align:center;color:#white;padding:5px;background:#ccc;margin:1px 0"><div id="tag" style="float:left"></div> <div style="float:right">
 <input type="checkbox" name="hover" id="hover"/> <label for="hover" style="font-size:10px;display:inline"> OnMouseover</label>
 <!--<input type="checkbox" name="thisonly" id="thisonly" onclick="conformation('undo');"/> <label onclick="conformation('undo');" for="thisonly" style="font-size:10px;display:inline"> Apply on selected only</label>-->
 </div>  <div style="clear:both"></div></div> <hr />
  <h2>Background</h2>
    <table width="100%" cellpadding="0" cellspacing="0" class="open" >
        <tr><td></td><td><strong>Background Color</strong></td></tr>
            <tr>
                <td>Background</td>
                <td><input type='text' name='backgroundColor' id='backgroundColor' style="width:15px !important;display:block;text-indent:-99999px;cursor:pointer;"/>
                </td>
            </tr>
            <tr>
                <td>R</td>
                <td><input type='hidden' value="255" name='backgroundR' id='backgroundR'/><div class="backgroundR" style="width: 108px; height: 1px;background:#ccc;position:relative;margin-top:10px"><div class="ball" style="right: 0px; top: 0px;"></div> </div>
                </td>
            </tr>
            <tr>
                <td>G</td>
                <td><input type='hidden' value="255"  name='backgroundG' id='backgroundG'/><div class="backgroundG" style="width: 108px; height: 1px;background:#ccc;position:relative;margin-top:10px"><div class="ball" style="right: 0px; top: 0px;"></div> </div>
                </td>
            </tr>
            <tr>
                <td>B</td>
                <td><input type='hidden' value="255"  name='backgroundB' id='backgroundB'/><div class="backgroundB" style="width: 108px; height: 1px;background:#ccc;position:relative;margin-top:10px"><div class="ball" style="right: 0px; top: 0px;"></div> </div>
                </td>
            </tr>
            <tr>
                <td>Opacity</td>
                <td><input type='hidden' value="1"  name='backgroundOpacity' id='backgroundOpacity'/>
                    <div class="backgroundOpacity" style="width: 108px; height: 1px;background:#ccc;position:relative;margin-top:10px"><div class="ball" style="right: 0px; top: 0px;"></div> </div>
                </td>
            </tr>
            <tr><td></td><td><strong>Background Gradient</strong></td></tr>
            <tr><td>Gradient</td><td><input type='text' name='gradientFrom' id='gradientFrom' style="width:15px !important;display:block;text-indent:-99999px;cursor:pointer;float:left;margin-right:3px" /> &nbsp;&nbsp;&nbsp;  <input type='text' name='gradientTo' id='gradientTo' style="width:15px !important;display:block;text-indent:-99999px;cursor:pointer;float:left" />  </td></tr>
</table>
<hr />
  <h2>Font</h2>
        <table style="width: 100%;"  cellpadding="0" cellspacing="0">
     <tr><td>Family</td>
        <td>
            <select name="fontFamily" id="fontFamily">
                <option value="">Select</option>
                <option value="arial">Arial</option>
                <option value="verdana">Verdana</option>
            </select>
        </td>
    </tr>
    <tr><td>Color</td><td><input type='text' name='color' id='color' style="width:15px !important;display:block;text-indent:-99999px;cursor:pointer;" /></td></tr>
    <tr><td>Size</td>
        <td>
            <select name="fontSize" id="fontSize">
                <option value="">Select</option>
                {php}
                    for($i=8;$i<=50;$i++){
                        echo "<option value=".$i."px>".$i."px</option>";
                    }
                {/php}
            </select>
        </td>
    </tr>
    <tr>
       <td>Style</td>
        <td>
            <select id="fontStyle" name="fontStyle">
                <option value="">Select</option>
                <option value="normal">Normal</option>
                <option value="italic">Italic</option>
                <option value="oblique">Oblique</option>
            </select>
            &nbsp;
            <select id="fontWeight" name="fontWeight">
                <option value="">Select</option>
                <option value="400">normal</option>
                <option value="700">bold</option>
            </select>
       </td>
    </tr>
    <tr><td>Align</td>
        <td>
            <select name="textAlign" id="textAlign">
                <option value="">Select</option>
                <option value="left">Left</option>
                <option value="center">Center</option>
                <option value="right">Right</option>
            </select>
        </td>
    </tr>
    <tr>
       <td>Decoration</td>
        <td>
            <select id="textDecoration" name="textDecoration">
                <option value="">Select</option>
                <option value="none">None</option>
                <option value="underline">Underline</option>
                <option value="overline">Overline</option>
                <option value="line-through">Line Through</option>
            </select>
       </td>
    </tr>
    <tr>
       <td>Case</td>
       <td>
            <select id="textTransform" name="textTransform">
                <option value="">Select</option>
                <option value="none">None</option>
                <option value="lowercase">Lowercase</option>
                <option value="uppercase">Uppercase</option>
                <option value="capitalize">Capitalize</option>
            </select>
            &nbsp;
            <select id="fontVariant" name="fontVariant">
                <option value="">Select</option>
                <option value="normal">Normal</option>
                <option value="small-caps">small-caps</option>
            </select>
       </td>
    </tr>
    <tr>
       <td>Text Shadow</td>
       <td>
            <table style="display: block;">
                <tr>
                    <td>
                        <div class="textpositionPicker" style="width: 40px; height: 40px;"><div style="height: 12px;width: 12px;position: relative;margin-top: 19px;margin-left: 19px;"><div class="ball" style="left: 0px; top: 0px;"></div></div> </div>
                    </td>
                    <td>
                         <table  style="display: block;" cellspacing="5" class="inTable">
                            <tr>
                                <td> X </td><td><input type='text' name='hShadow' id='hShadow' style="width:30px !important" class="textShadow"/></td>
                                <td> Blur </td><td><input type='text' name='blurShadow' id='blurShadow' style="width:30px !important" class="textShadow"/></td>
                            </tr>
                            <tr>
                                <td>Y </td> <td><input type='text' name='vShadow' id='vShadow' style="width:30px !important" class="textShadow"/></td>
                                <td>Color </td><td><input type='hidden' name='textShadow' id='textShadow'/><input type='text' name='colorShadow' id='colorShadow' style="width:15px !important;display:block;text-indent:-99999px;cursor:pointer;" /></td>
                            </tr>
                           </table>
                    </td>
                </tr>
            </table>
       </td>
    </tr>
</table>
 <hr />
 <h2>Box</h2>
        <table style="width: 100%;"  cellpadding="0" cellspacing="0">
            <tr>
                <td>
                   Margin
                </td>
                <td>
                    <table style="display: block;">
                        <tr class="direction">
                            <td>Top</td>
                            <td>Right</td>
                            <td>Bottom</td>
                            <td>Left</td>
                            <td rowspan="2"><img src="images/margin_icon.png"/></td>
                        </tr>
                        <tr>
                            <td><input type='text' name='marginTop' id='marginTop' style="width:30px !important;" class="px"/></td>
                            <td><input type='text' name='marginRight' id='marginRight' style="width:30px !important;" class="px"/></td>
                            <td><input type='text' name='marginBottom' id='marginBottom' style="width:30px !important;" class="px"/></td>
                            <td><input type='text' name='marginLeft' id='marginLeft' style="width:30px !important;" class="px"/></td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td>
                   Padding
                </td>
                <td>
                    <table style="display: block;">
                        <tr class="direction">
                            <td>Top</td>
                            <td>Right</td>
                            <td>Bottom</td>
                            <td>Left</td>
                            <td rowspan="2"><img src="images/padding_icon.png"/></td>
                        </tr>
                        <tr>
                            <td><input type='text' name='paddingTop' id='paddingTop' style="width:30px !important;" class="px"/></td>
                            <td><input type='text' name='paddingRight' id='paddingRight' style="width:30px !important;" class="px"/></td>
                            <td><input type='text' name='paddingBottom' id='paddingBottom' style="width:30px !important;" class="px"/></td>
                            <td><input type='text' name='paddingLeft' id='paddingLeft' style="width:30px !important;" class="px"/>  </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
               <td>Height</td>
               <td>
                     <input type='text' name='height' id='height' class="px"/>
               </td>
            </tr>
            <tr>
               <td>Width</td>
               <td>
                   <input type='text' name='width' id='width' class="px"/>
               </td>
            </tr>
            <tr>
               <td>Line Height</td>
               <td>
                   <input type='text' name='lineHeight' id='lineHeight' class="px"/>
               </td>
            </tr>
            <tr>
       <td>Box Shadow</td>
       <td>
            <table style="display: block;">
                <tr>
                    <td style="vertical-align:top">
                        <div class="positionPicker" style="width: 40px; height: 40px;"><div style="height: 12px;width: 12px;position: relative;margin-top: 19px;margin-left: 19px;"><div class="ball" style="left: 0px; top: 0px;"></div></div> </div>
                    </td>
                    <td>
                         <table style="display: block;" cellspacing="5" class="inTable">
                            <tr>
                                <td> X </td><td><input type='text' name='bhShadow' id='bhShadow' style="width:30px !important;" class="boxShadow"/></td>
                                <td> Blur </td><td><input type='text' name='bblurShadow' id='bblurShadow' style="width:30px !important;" class="boxShadow"/></td>
                            </tr>
                            <tr>
                                <td>Y </td> <td><input type='text' name='bvShadow' id='bvShadow' style="width:30px !important;" class="boxShadow"/></td>
                                <td>Color </td><td><input type='hidden' name='boxShadow' id='boxShadow'/><input type='text' name='bcolorShadow' id='bcolorShadow' style="width:15px !important;text-indent:-99999px;cursor:pointer;" /></td>
                            </tr>
                            <tr><td colspan="4"><select id="shadowType" class="boxShadow"><option value="">Select</option><option value="inset">Inset</option></select></td></tr>
                           </table>
                    </td>
                </tr>
            </table>
       </td>
    </tr>
         </table>
        <hr />
<h2>Border</h2>
      <table>
          <tr>
              <td style="padding: 0 4px;">
                  <div class="borders">
                    <table style="display: block;" cellspacing="5" class="inTable">
                    <tr>
                        <td><strong>Border</strong></td>
                        <td><div title="All borders"  class="border" id="active"><span></span></div></td>
                        <td><div title="Top border"  class="borderTop"><span></span></div></td>
                        <td><div title="Right border"  class="borderRight"><span></span></div></td>
                        <td><div title="Bottom border" class="borderBottom"><span></span></div></td>
                        <td><div title="Left border"  class="borderLeft"><span></span></div></td>
                    </tr>
                    <tr>
                       <td>Style</td>
                            <td colspan="4"><select id="borderStyle" name="borderStyle">
                            <option value="">Select</option>
                            <option value="none">None</option>
                            <option value="dotted">Dotted</option>
                            <option value="dashed">Dashed</option>
                            <option value="solid">Solid</option>
                            <option value="inset">Inset</option>
                            <option value="double">Double</option>
                            <option value="groove">Groove</option>
                            <option value="hidden">Hidden</option>
                            <option value="outset">Outset</option>
                            <option value="ridge">Ridge</option>
                            </select>
                            </td>
                    </tr>
                    <tr>
                        <td>
                          Width
                        </td>
                        <td colspan="3"><input type='text' name='borderWidth' id='borderWidth' style="width:30px !important;" class="px"/></td></tr>
                    <tr>
                        <td>Color</td><td colspan="3"><input type='text' name='borderColor' id='borderColor' style="width:15px !important;display:block;text-indent:-99999px;cursor:pointer;" /></td>
                    </tr>
                    </table>
                  </div>
              </td>
          </tr>
                  <tr><td><strong>Border Radius</strong></td></tr>
          <tr>
            <td style="padding: 0 4px;">
               <table  style="display: block;" cellspacing="5" class="inTable"><tr><td>
                    <div class="borderrds">
                        <table style="display: block;">
                            <tr>
                                <td><strong>Radius</strong></td>
                                <td><div title="All borders" class="borderRadius" id="active"><span></span></div></td>
                                <td><div title="Top left" class="borderTopLeftRadius"><span></span></div></td>
                                <td><div title="Top right" class="borderTopRightRadius"><span></span></div></td>
                                <td><div title="Bottom right"  class="borderBottomRightRadius"><span></span></div></td>
                                <td><div title="Bottom left" class="borderBottomLeftRadius"><span></span></div></td>
                            </tr>
                            <tr><td>Size</td><td colspan="3"><input type='text' name='borderRadius' id='borderRadius' style="width:30px !important;" class="px"/></td></tr>
                        </table>
                      </div>
                  </td></tr>
                </table>
          </td>
          </tr>
      </table>

<hr />
<h2>Advance</h2>
<table width="100%" style="overflow: ;">
    <tr>
        <td>Font</td>
         <td>
            <select  onchange="savefont(this.value);">
                <option value="">Select</option>
                {php}
                    include 'includes/google.fonts.php';
                    foreach($fontfamily as $key=>$value){
                        if($font_==$key){
                            echo "<option value='$key' selected='selected'>$value</option>";
                        }
                        else{
                            echo "<option value='$key'>$value</option>";
                        }
                    }
                {/php}
            </select>
        </td>
    </tr>
    <tr>
        <td>Overflow</td>
         <td>
            <select id="overflow" name="overflow">
                <option value="">Select</option>
                <option value="hidden">Hidden</option>
                <option value="scroll">Scroll</option>
                <option value="visible">Visible</option>
            </select>
        </td>
    </tr>
    <tr>
                <td>
                   Display
                </td>
                <td>
                    <select id="display" name="display">
                        <option value="">Select</option>
                        <option value="none">None</option>
                        <option value="block">Block</option>
                        <option value="inline">Inline</option>
                        <option value="inline-block">Inline Block</option>
                        <option value="table-cell">Table Cell</option>
                        <option value="table-row">Table Row</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td>
                   Float
                </td>
                <td>
                    <select id="float" name="float">
                        <option value="">Select</option>
                        <option value="none">None</option>
                        <option value="left">Left</option>
                        <option value="right">Right</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td>
                   Position
                </td>
                <td>
                     <select id="position" name="position">
                        <option value="">Select</option>
                        <option value="relative">Relative</option>
                        <option value="absolute">Absolute</option>
                        <option value="fixed">Fixed</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td>
                   Left
                </td>
                <td>
                   <input type='text' name='left' id='left' style="width:30px !important;" class="px"/>
                </td>
            </tr>
            <tr>
                <td>
                   Top
                </td>
                <td>
                    <input type='text' name='top' id='top' style="width:30px !important;" class="px"/>
                </td>
            </tr>
            <tr>
                <td>
                   Right
                </td>
                <td>
                   <input type='text' name='right' id='right' style="width:30px !important;" class="px"/>
                </td>
            </tr>
            <tr>
                <td>
                   Bottom
                </td>
                <td>
                    <input type='text' name='bottom' id='bottom' style="width:30px !important;" class="px"/>
                </td>
            </tr>
            <tr>
                <td>
                   Z-Index
                </td>
                <td>
                    <input type='text' name='z-index' id='z-index' style="width:30px !important;"/>
                </td>
            </tr>
            <tr>
                <td>Opacity</td>
                <td><input type='text' name='opacity' id='opacity' style="width:30px !important;" class="ops"/>
                    &nbsp; <div class="opacity" style="width: 108px; height: 1px;background:#ccc;float:right;position:relative;margin-top:10px"><div class="ball" style="right: 0px; top: 0px;"></div> </div>
                </td>
            </tr>
             <tr  style="display:none">
                <td colspan="2">
                <input type='checkbox' name='important' id='important'/>
                    Important
                </td>
            </tr>
            <tr style="display:none">
                <td colspan="2"><input type='checkbox' id="visible" name='visible'/>To show all mouse over element of selected tag</td>
            </tr>
</table>
 <hr />
 <h2 onclick="getRestorepointfile();">Restore & Backup Template</h2>
 <table  width="100%">
 <tr><td><strong>Restore</strong></td></tr>
 <tr>
    <td>
    <span class="restorepointdropdown"></span>
    <input type="button" class="btn" id="undo" style="" onclick="restoreSelected();" value="Restore" />
    <br /><br /> <input type="checkbox" value="1" name="backup" id="backup"/> <label for="backup" style="display:inline"><small>Save current before restore</small> </label>
     </td>
  </tr>
  <tr><td><strong>Backup</strong></td></tr>
  <tr>
    <td><input type="button" id="undo" class="btn btn-success" onclick="SubmitForm('#undo','includes/getdata/editor.create.restorepoint.php','#frmaddadmin','#notification10','true','#loader');" value="Create Restore Point or Backup" /></td>
  </tr>
 </table>
        <div  class="mainpanel">
            <div style="float:left;">
                <input type="button" id="savebut" class="btn btn-primary" onclick="SubmitForm('#savebut','includes/getdata/editor.save.php','#frmaddadmin','#notification10','true','#loader');" value="Save" />
            </div>
            <div style="float:right;">
                    <input type="button" class="btn btn-warning"  id="undo"  onclick="conformation('undo');"  value="Undo" />
                    <input type="button" class="btn"  id="reset" onclick="conformation('reset');" value="Reset Default" />
            </div>
            <div style="clear:both"></div>
        </div>
    </div>
  </form>
</div>

</div>
<div class="tagname" style="display: none;"></div>
    <div class="elementSelect">
        <table style="width: 100%;height: 100%;" border="0">
            <tr><td class="lt">&nbsp;</td><td class="rt">&nbsp;</td></tr>
            <tr><td class="lb">&nbsp;</td><td class="rb">&nbsp;</td></tr>
        </table>
    </div>
    <div class="hoverElement"></div>
</div>

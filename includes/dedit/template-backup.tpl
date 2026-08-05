<link rel="stylesheet" media="screen" type="text/css" href="{$siteurl}/includes/colorpicker/css/colorpicker.css" />
<script type="text/javascript" src="{$siteurl}/includes/colorpicker/js/colorpicker.js"></script>
<script type="text/javascript" src="{$siteurl}/includes/js/template.editor2.js"></script>
<script src="{$siteurl}/includes/js/draggable/jquery-ui-1.10.4.custom.min.js"></script>

<!--<script src="{$siteurl}/includes/js/draggable/jquery.ui.core.js"></script>
<script src="{$siteurl}/includes/js/draggable/jquery.ui.widget.js"></script>
<script src="{$siteurl}/includes/js/draggable/jquery.ui.mouse.js"></script>
<script src="{$siteurl}/includes/js/draggable/jquery.ui.draggable.js"></script>
<script src="{$siteurl}/includes/js/draggable/jquery.ui.droppable.js"></script>

<script type="text/javascript" src="{$siteurl}/includes/js/jquery.wysiwyg.js"></script>
<link rel="stylesheet" type="text/css" href="{$siteurl}/includes/css/jquery.wysiwyg.css" />
-->
{literal}
    <script>
        function newWindow(file,window){
            msgWindow=open(file,window,'scrollbars=yes,resizable=no,width=550,height=400');
            if (msgWindow.opener == null) msgWindow.opener = self;
        }
    </script>

    <style>
        .admineditor{transition:all 0.5s;width:470px;top:0}
        .admineditor.ope{top:0px;transition:all 0.5s}
        .editorul .dropdown-header{
            color: #636363 !important;
            font-size: .875rem;
            padding: 5px 8px;
        }
        .editorul .dropdown-divider {
            border-top: 1px solid #333333;
        }
        .editorul .dropdown-item {
            padding: 3px 10px;
        }
        .admineditor .nav-link:focus{
            background: #000;
        }
    </style>

{/literal}
<link rel="stylesheet" media="screen" type="text/css" href="{$siteurl}/includes/dedit/style.css?1" />
<div class="editor" style="display:none;">
    <div class="admineditor">
        <div id="notification10" style="z-index:9999;margin:0;top:5px;text-align:center;"></div>







        <div>
            <ul  class="editorul">
                <li  style="position:relative">
                    <a href="{$site_address}{$admindir}" style="color:white;padding:5px;display:block;"> &larr;  Back to admin</a>
                </li>

                <li  class="listtemplate" style="position:relative">
                    <form method="post" id="frmtmp" class="template">
                        <select onchange="javascript: location.href='index.php?template='+this.value" style="background: black;color: white;padding: 4px 10px;border: none;">
                            {foreach from=$utemplate key=FolderName item=theme}
                                <option value="{$FolderName}" {if $FolderName eq $template} selected="selected" {/if}>
                                    {$theme}
                                </option>
                            {/foreach}
                        </select>

                    </form>

                </li>

                {if $template eq 'components'}
                    <li class="nav-item d-none d-sm-block  dropdown">
                        <a class="nav-link text-white" data-toggle="dropdown" href="#" style="white-space: nowrap">
                            Template Setting
                            <i class="fal fa-cog fa-spin"></i>
                        </a>
                        <div class="dropdown-menu  dropdown-menu-right shadow-sm w-auto p-3 theme-colors" style="width: 400px !important;background: black">
                            <h6 class="dropdown-header text-white">Theme Color</h6>

                            <a class="dropdown-item theme theme1 ml-4" onclick="javascript: setcolor('theme1');" >   </a>
                            <a class="dropdown-item theme theme2" onclick="javascript: setcolor('theme2');" >   </a>
                            <a class="dropdown-item theme theme3" onclick="javascript: setcolor('theme3');" >  </a>
                            <a class="dropdown-item theme theme4" onclick="javascript: setcolor('theme4');" >   </a>
                            <a class="dropdown-item theme theme5" onclick="javascript: setcolor('theme5');" >   </a>
                            <a class="dropdown-item theme theme6" onclick="javascript: setcolor('theme6');" >  </a>
                            <a class="dropdown-item theme theme7" onclick="javascript: setcolor('theme7');" >   </a>
                            <a class="dropdown-item theme theme8" onclick="javascript: setcolor('theme8');" >   </a>
                            <a class="dropdown-item theme theme9" onclick="javascript: setcolor('theme9');" >  </a>
                            <a class="dropdown-item theme theme10" onclick="javascript: setcolor('theme10');" >   </a>

                            <div>
                                <a class="dropdown-item theme theme11 ml-4" onclick="javascript: setcolor('theme11');" >   </a>
                                <a class="dropdown-item theme theme12" onclick="javascript: setcolor('theme12');" >   </a>
                                <a class="dropdown-item theme theme13" onclick="javascript: setcolor('theme13');" >  </a>
                                <a class="dropdown-item theme theme14" onclick="javascript: setcolor('theme14');" >   </a>
                                <a class="dropdown-item theme theme15" onclick="javascript: setcolor('theme15');" >   </a>
                                <a class="dropdown-item theme theme16" onclick="javascript: setcolor('theme16');" >  </a>
                                <a class="dropdown-item theme theme17" onclick="javascript: setcolor('theme17');" >   </a>
                                <a class="dropdown-item theme theme18" onclick="javascript: setcolor('theme18');" >   </a>
                                <a class="dropdown-item theme theme19" onclick="javascript: setcolor('theme19');" >  </a>
                                <a class="dropdown-item theme theme20" onclick="javascript: setcolor('theme20');" >   </a>
                            </div>

                            <div class="dropdown-divider"></div>
                            <h6 class="dropdown-header text-white">Page Size - {$bannersizes}</h6>

                            <a class="dropdown-item" onclick="javascript: setsize('box');" >  Box  </a>
                            <a class="dropdown-item" onclick="javascript: setsize('full');" >  Full Width </a>

                            <div class="dropdown-divider"></div>
                            <h6 class="dropdown-header text-white">Menu Background - {$navbar}</h6>

                            <a class="dropdown-item" onclick="javascript: setmenus('transparent');" >  Transparent  </a>
                            <a class="dropdown-item" onclick="javascript: setmenus('none');" >  None </a>





                            <div class="dropdown-divider"></div>
                            <h6 class="dropdown-header text-white">Banner Footer Shape  </h6>

                            {section name=foo start=1 loop=22 step=1}
                                <a class="dropdown-item" onclick="javascript: setshape('svg{$smarty.section.foo.index}');" >  Shape {$smarty.section.foo.index}  </a>
                            {/section}
                            <a class="dropdown-item" onclick="javascript: setshape('svg');" >  None  </a>

                            <div class="dropdown-divider"></div>
                            {*  <h6 class="dropdown-header text-white">Banner Widget - {$bannercontent} </h6>

                              <a class="dropdown-item" onclick="javascript: setbannercontent('checkout');" style="width: auto">  Quick Checkout  </a>
                              <a class="dropdown-item" onclick="javascript: setbannercontent('login');" >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  Login </a>
                              <a class="dropdown-item" onclick="javascript: setbannercontent('none');" >  None </a>
                               <div class="dropdown-divider"></div>



                              <h6 class="dropdown-header text-white">Banner Position - {$bannerposition} </h6>

                              <a class="dropdown-item" onclick="javascript: setbannerposition('top');" style="width: auto">  Top  </a>
                              <a class="dropdown-item" onclick="javascript: setbannerposition('middle');" >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  Middle </a>
                              <a class="dropdown-item" onclick="javascript: setbannerposition('bottom');" >  Bottom </a>



                              <div class="dropdown-divider"></div>
                              *}
                            <h6 class="dropdown-header text-white">After login announcement popup  - {$announcementpopup} </h6>



                            <label class="dropdown-item text-white"  style="width: auto"> <input type="checkbox" onclick="javascript:setannouncementpopup(this)" {if $announcementpopup eq 'true'}checked="checked"{/if} value="1">  Enable  </label>

                        </div>
                    </li>

                {/if}

                {if $template neq 'default6'}
                    <li  style="position:relative"><span  class="activeeditor">Active Editor</span> </li>
                {/if}

            </ul>

            <div style="text-align: center">
                <a style="cursor: pointer;background: #000000bd;display: inline-block;padding: 7px 10px;border-radius: 0 0 5px 5px;"  onclick="$('.admineditor').toggleClass('ope')"> <img src="images/admin-icon.png" /> </a>
            </div>
        </div>












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
                        <tr><td></td><td><strong>Background Image</strong></td></tr>
                        <tr><td>Gradient</td><td><input type='text' name='gradientFrom' id='gradientFrom' style="width:15px !important;display:block;text-indent:-99999px;cursor:pointer;float:left;margin-right:3px" /> &nbsp;&nbsp;&nbsp;  <input type='text' name='gradientTo' id='gradientTo' style="width:15px !important;display:block;text-indent:-99999px;cursor:pointer;float:left" />  </td></tr>
                        <tr><td>Image</td><td><input type='text' name='backgroundImage' id='backgroundImage' class="backgroundImage"/>
                                <a href="javascript:void(0)" onclick="newWindow('{$site_address}{$admindir}/includes/gallery.php?id=backgroundImage', 'windowname1')"> Add  </a> &nbsp;  <input type="button" class="addBgImageok" id="btns" value="OK" style="font-size: 10px !important;height: 20px !important;line-height: 20px !important;padding:0px 10px !important;border:none"/></td></tr>
                        <tr><td>Position</td>
                            <td>
                                <select id="backgroundPosition" name="backgroundPosition">
                                    <option value="">Select</option>
                                    <option value="top">Top</option>
                                    <option value="bottom">Bottom</option>
                                    <option value="left">Left</option>
                                    <option value="right">Right</option>
                                </select>
                            </td>
                        </tr>
                        <tr><td>Repeat</td>
                            <td>
                                <select id="backgroundRepeat" name="backgroundRepeat">
                                    <option value="">Select</option>
                                    <option value="repeat-x">repeat-x</option>
                                    <option value="repeat-y">repeat-y</option>
                                    <option value="repeat">repeat</option>
                                    <option value="no-repeat">no-repeat</option>
                                </select>
                            </td>
                        </tr>
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
                    <h2>Animation</h2>
                    <table width="100%" cellpadding="0" cellspacing="0">
                        <tr class="hover-hide">
                            <td>Property</td>
                            <td><input type='hidden' value="" name='transition' id='transition'/>
                                <select name="transitionProperty" id="transitionProperty" multiple="multiple">
                                    <option value="all">All</option>
                                    <option value="transform">Transform</option>
                                    <option value="color">Color</option>
                                    <option value="background">Background</option>
                                    <option value="width">Width</option>
                                    <option value="height">Height</option>
                                    <option value="opacity">Opacity</option>
                                    <option value="box-shadow">Box Shadow</option>
                                    <option value="font-size">Font Size</option>
                                    <option value="text-shadow">Text Shadow</option>
                                    <option value="text-decoration">Text Decoration</option>
                                    <option value="display">Display</option>
                                    <option value="left">Left</option>
                                    <option value="right">Right</option>
                                    <option value="top">Top</option>
                                    <option value="bottom">Bottom</option>
                                </select>
                            </td>
                        </tr>
                        <tr class="hover-hide">
                            <td>Duration</td>
                            <td>
                                <select name="transitionDuration" id="transitionDuration">
                                    <option value="">Select</option>
                                    <option value="0.3s" selected="">0.3s</option>
                                    <option value="0.5s" selected="">0.5s</option>
                                    <option value="1s" selected="">1s</option>
                                    <option value="2s">2s</option>
                                    <option value="3s">3s</option>
                                    <option value="3s">4s</option>
                                    <option value="3s">5s</option>
                                </select>
                            </td>
                        </tr>
                        <tr class="hover-show" style="display:none">
                            <td>Rotate</td>
                            <td><input type='hidden' value="" name='transform' id='transform'/> <input type='text' class="rotate" name='rotate' id='rotate' style="width:100px !important;"/> deg
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
                        <tr>
                            <td colspan="2">
                                <input type='checkbox' name='important' id='important'/>
                                Important
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2"><input type='checkbox' id="visible" name='visible'/>To show all mouse over element of selected tag</td>
                        </tr>
                    </table>
                    <h2>Rular Bar</h2>
                    <table width="100%">
                        <tr>
                            <td><div class="addhorizontal" title="Add Horizontal Rular Bar" style="cursor:pointer"><img src="images/horizontaltop.png"/></div></td> <td> Add Horizontal Rular Bar</td>
                        </tr>
                        <tr>
                            <td><div class="addvertical" title="Add Vertical Rular Bar"  style="cursor:pointer"><img src="images/verticaltap.png"/></div></td> <td> Add Vertical Rular Bar</td>
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
                    <!--
                     <h2>Elements</h2>
                    <table width="100%">
                        <tr>
                            <td>
                           <div id="catalog">
                              <ul class="controls">
                                <li>
                                    <table class="custom" width="100%" border="0">
                                        <tr>
                                            <td colspan="2" class="banner"></td>
                                        </tr>
                                        <tr><td class="firstTD">Hello</td><a><td class="secondTD">How Are You</td></a></tr>
                                    </table>
                                    <img class="dropImg" src="images/verticaltap.png"/>
                                </li>
                                <li>
                                    <table class="custom" width="100%" border="0">
                                        <tr><td class="firstTD">First Column</td><a><td class="secondTD">Second Column</td></a></tr>
                                    </table>
                                    <img class="dropImg" src="images/verticaltap.png"/>
                                </li>
                              </ul>
                            </div>
                        </div>
                            </td>
                        </tr>
                    </table>
                     <hr />
                    -->
                    <div  class="mainpanel">
                        <div style="float:left;">
                            <input type="button" id="savebut" class="btn btn-primary" onclick="SubmitForm('#savebut','includes/getdata/editor.save.php','#frmaddadmin','#notification10','true','#loader');" value="Save" />
                        </div>
                        <div style="float:right;">
                            <input type="button" class="btn btn-warning"  id="undo"  onclick="conformation('undo');"  value="Undo" />
                            <input type="button" class="btn"  id="reset" onclick="conformation('reset');" value="Reset Template" />
                        </div>
                        <div style="clear:both"></div>
                    </div>
                </div>
            </form>
        </div>
        <div class="horizontaltap">
            {php}
                for($i=0;$i<=2500;$i=$i+50){
                echo "<span>".$i."</span>";
                }
            {/php}
            <div class="tapclose">X</div>
        </div>
        <div class="verticaltap">
            {php}
                for($i=0;$i<=2500;$i=$i+50){
                echo "<span>".$i."</span>";
                }
            {/php}
            <div class="tapclose">X</div>
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

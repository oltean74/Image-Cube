<?php   defined('C5_EXECUTE') or die(_("Access Denied."))?>


<div id="accordion">

    <h3><a href="#">Fileset settings</a></h3>
            <div>               
                <table width="100%" >
                <tr>
                <td style="width:50%; padding:10px;">
                        <label class="label"  for="fsID"><?php        echo t('File Set') ?>:</label>
                        <select name="fsID" title="fsID" id="fsID" onchange='refreshFsID(this.value)'>
                                <?php        foreach($s1 as $fs) {
                                echo '<option value="'.$fs->getFileSetID().'" ' . ($fsID == $fs->getFileSetID() ? 'selected="selected"' : '') . '>'.$fs->getFileSetName().'</option>\n';
                                  }?>
                        </select>
                        <?php       if (is_array($s1) && count($s1) >= 1) : ?>

                        <?php       else : ?>
                                <h2 style="color:#ff0000">Create file set first<br><span style="font-size:9px">Go to your dashboard > file manager</span></h2>
                        <?php       endif ?>
                        
                </td>
                 </tr>
                </table>
            </div>      
  
           <h3><a href="#">Basic options</a></h3>
            <div>
                
                <table width="100%" class='separate' cellpadding="10">
		<tr>
			<td>
				<label class="label"  for="cubewidth"><?php        echo t('Cube Width');?></label>
			</td>
			<td>
				  <input type="text" id="cubewidth" name="cubewidth" style="border:0; font-weight:bold; width:30px; background:#fafafa;"  readonly="readonly" /> <?php        echo t('Cube width')?>                                                                        
				   <div id="range-cubewidth"></div>
			</td>
		</tr>
		<tr>
			<td>
				<label class="label"  for="cubeheight"><?php        echo t('Cube Height');?></label>
			</td>
			<td>
				  <input type="text" id="cubeheight" name="cubeheight" style="border:0; font-weight:bold; width:30px; background:#fafafa;"  readonly="readonly" />  <?php        echo t('Cube Height')?>                                                               
				   <div id="range-cubeheight"></div>
			</td>
		</tr>	<tr>
			<td style="width:50%;">
				<label class="label"  for="animSpeed"><?php        echo t('Animation Speed <small>(milliseconds)</small>');?></label>
			</td>   

			<td>
				  <input type="text" id="animSpeed" name="animSpeed" style="border:0; font-weight:bold; width:30px; background:#fafafa;"  readonly="readonly" /> <?php        echo t('ms')?>                                                                      
				   <div id="range-animSpeed"></div>
			</td>
		</tr>
		<tr><td>
				<label class="label"  for="pauseTime"><?php        echo t('Pause Time <small>(milliseconds)</small>');?></label>
			</td>
			<td>
				  <input type="text" id="pauseTime" name="pauseTime" style="border:0; font-weight:bold; width:30px; background:#fafafa;"  readonly="readonly" /> <?php        echo t('ms')?>                                                                      
				   <div id="range-pauseTime"></div>
			</td>   </tr>                   
	

                </table>
                <div id="ccm-file-infos-list">
                        
                </div>

        </div>
  
        <h3><a href="#">Advanced options</a></h3>
        <div>
        <table cellpadding="10" width="100%" class='separate' >
                <tr valign="top">
                        <td style="width:50%; padding:10px;">
				<label class="label"  for='repeat'>Repeat</label>
					
				</td>
				<td>
					<input type='checkbox' <?php   echo in_array('repeat',$options) ? 'checked' : '' ?> name='options[]' value='repeat' id='repeat' />                                                        
				</td>
			</tr>
			<tr>
				<td>
					<label class="label"  for='full3D'>Full3D</label>                                                   
				</td>
				<td>
					<input type='checkbox' <?php   echo in_array('full3D',$options) ? 'checked' : '' ?> name='options[]' value='full3D' id='full3D' />                                                        
				</td>
			</tr>
			<tr>
				<td>
					<label class="label"  for='shading'>Shading</label>                                                     
				</td>
				<td>
					<input type='checkbox' <?php   echo in_array('shading',$options) ? 'checked' : '' ?> name='options[]' value='shading' id='shading' />                                                        
				</td>
			</tr>
 		<tr>
			<td>
				<label class="label"  for="segments"><?php        echo t('Segments');?></label>
			</td>
			<td>
				  <input type="text" id="segments" name="segments" style="border:0; font-weight:bold; width:30px; background:#fafafa;"  readonly="readonly" /> <?php        echo t('segments')?>                                                                
				   <div id="range-segments"></div>
			</td>
		</tr>
		
		<tr>
			<td>
				<label class="label"  for="reduction"><?php        echo t('Reduction');?></label>
			</td>
			<td>
				  <input type="text" id="reduction" name="reduction" style="border:0; font-weight:bold; width:30px; background:#fafafa;"  readonly="readonly" />  <?php        echo t('reduction')?>                                                                
				   <div id="range-reduction"></div>
			</td>
		</tr>
		<tr>
			<td>
				<label class="label"  for="expansion"><?php        echo t('Expansion');?></label>
			</td>
			<td>
				  <input type="text" id="expansion" name="expansion" style="border:0; font-weight:bold; width:30px; background:#fafafa;"  readonly="readonly" />  <?php        echo t('expansion')?>                                                                
				   <div id="range-expansion"></div>
			</td>
		</tr>
        <tr>
		<td>
			<label class="label"  for="effect"><?php        echo t('Direction');?></label>
		</td>
		<td>
			<?php   echo $form->select('effect',$controller->addKeyToArray($controller->effects),$effect)?>
		       
		</td>
	</tr>
	<tr>
		<td style="width:50%; padding:10px;">
		
			<label class="label"  for="selection"><?php        echo t('Selection')?>:</label>
		</td>
		<td>
			<?php   echo $form->select('selection',$controller->addKeyToArray($controller->selections),$selection)?>
		       
		</td>
		</tr>
       </table>
        </div>

 
        
</div>

<script type="text/javascript">

  TOOLS_URL = "<?php    echo $tools_url?>";
  BLOCK_ID = '<?php     echo $this->controller->bID?>';

  $(document).ready(function() { 
  <?php   
	  if ($fsID && $link == 'multipages') : ?>
	  refreshFsID(); 
  <?php    endif ?>
	  $(':checkbox').iToggle();
	  $( "#accordion" ).accordion({autoHeight:false,collapsible: true});

	  setjQuerySlider('animSpeed',1000,5000,'<?php      echo $animSpeed ?>');
	  setjQuerySlider('pauseTime',1000,5000,'<?php      echo $pauseTime ?>');
	  setjQuerySlider('cubewidth',200,800,'<?php      echo $cubewidth ?>');
	  setjQuerySlider('reduction',10,50,'<?php      echo $reduction ?>');
	  setjQuerySlider('cubeheight',200,800,'<?php      echo $cubeheight ?>');
	  setjQuerySlider('segments',20,50,'<?php      echo $segments ?>');
 	  setjQuerySlider('expansion',5,30,'<?php      echo $expansion ?>');
  });
</script>

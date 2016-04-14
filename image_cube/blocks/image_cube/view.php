<?php         defined('C5_EXECUTE') or die(_("Access Denied."));
if (in_array('randomize', $options)) shuffle ($gal);
?>

<?php     $c = Page::getCurrentPage();
if ($c->isEditMode()) : ?>

<div class="ccm-edit-mode-disabled-item" style="height:100px">
	<div style="padding: 30px 0px 0px 0px">
		<?php     echo t('Image Cube<br />Content disabled in edit mode.')?>
    </div>
</div>

<?php     else : ?>
<div style="clear:both"></div>
<script type="text/javascript">
$(document).ready(function() {
	$('#cube-<?php   echo $bID?>_handler').imagecube({
	direction:'<?php   echo $controller->effect?>',
	speed:<?php   echo (int) $controller->animSpeed?>,
	pause:'<?php   echo $controller->pauseTime?>',
	repeat:<?php   echo in_array('repeat',$options) ? 'true' : 'false'?>, 
    full3D:<?php   echo in_array('full3D',$options) ? 'true' : 'false'?>,
    shading:<?php   echo in_array('shading', $options) ? 'true' : 'false'?>,
	segments:<?php   echo (int)($controller->segments)?>,
	reduction:<?php   echo (int) $controller->reduction?>,
	expansion:<?php   echo (int) $controller->expansion?>,
	selection:'<?php   echo $controller->selection?>',
	});
	
});
</script>

<div id='cube-<?php   echo $bID?>_handler' style='width:<?php   echo $controller->cubewidth?>px; height:<?php   echo $controller->cubeheight?>px'>
	<?php       foreach ($gal as $img) : ?>
					<?php      $hh = $hh < $img['height'] ?  $img['height'] : $hh; ?>
				<?php       if ($img['isLink']):?><a href='<?php      echo $img['link']?>'><?php    endif ?>
				<img src='<?php      echo $img['src']?>' width='<?php      echo $img['width']?>' height='<?php   echo $img['height']?>' />
				<?php       if ($img['isLink']):?></a><?php    endif?>
	<?php       endforeach ?>					<?php      $ww = $ww < $img['width'] ?  $img['width'] : $ww; ?>
	</div>
<div style="clear:both"></div>

<?php      endif ?>
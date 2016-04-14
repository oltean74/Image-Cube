<?php  
$bt_ns = BlockType::getByHandle('image_cube');
$bt_ns->controller->fsID = 1; // ID of your fileset
$bt_ns->controller->effect = 'random';
$bt_ns->controller->cubewidth = 200;
$bt_ns->controller->cubeheight = 200;
$bt_ns->controller->animSpeed = 2000;
$bt_ns->controller->pauseTime = 2000;
$bt_ns->controller->reduction = 20; 
$bt_ns->controller->options('repeat','full3D','shading'); // remove option from string to disable them
$bt_ns->render('view');
?>
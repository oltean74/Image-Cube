<?php        defined('C5_EXECUTE') or die(_("Access Denied."));

Loader::library('file/types');
Loader::model('file');
$al             = Loader::helper('concrete/asset_library');
$db             = Loader::db();
$ih             = Loader::helper('image');
$pageSelector   = Loader::helper('form/page_selector');

if ($_REQUEST['bID']) {
        $b = Block::getByID($_REQUEST['bID']);
        $bi = $b->getInstance();
}

$pla = explode(',',$bi->linkPageID);
$pli = explode(',',$bi->fileLink);

$vals = array( $_GET['fsID']);
$sql = 'SELECT fID FROM FileSetFiles WHERE fsID=?';
$files = $db->getAll($sql,$vals);

?>


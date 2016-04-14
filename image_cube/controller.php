<?php        

defined('C5_EXECUTE') or die(_("Access Denied."));

class ImageCubePackage extends Package {

	protected $pkgHandle = 'image_cube';
	protected $appVersionRequired = '5.3.3';
	protected $pkgVersion = '1.0';
	
	public function getPackageDescription() {
		return t("jQuery Image Cube ported to Concrete5 by Ioan Oltean");
	}
	
	public function getPackageName() {
		return t("Image Cube");
	} 
	
	public function install() {
		$pkg = parent::install();
		
		// install block
		BlockType::installBlockTypeFromPackage('image_cube', $pkg);
 
	}

}
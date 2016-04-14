<?php        
defined('C5_EXECUTE') or die(_("Access Denied."));

class ImageCubeBlockController extends BlockController {
	
	var $pobj;
	
	protected $btTable = 'btImageCube';
	protected $btInterfaceWidth = "550";
	protected $btInterfaceHeight = "400";
	
	public $effect_default		= 'random';
    public $selection_default	= 'random';
	public $cubewidth_default		= 200;
	public $cubeheight_default		= 200;
	public $animSpeed_default	= 2000;
	public $pauseTime_default	= 3000;
	public $reduction_default	= 30;
	public $effects = array('random','up','down','left','right');
	public $selections = array('random','forward','backward');
	
	public function __construct($obj = null) {		
		parent::__construct($obj);
		$this->db = Loader::db();
	}
	
	function add () {
		$this->edit_utilities();

		$this->set('effect',      $this->effect_default);
		$this->set('selection',   $this->selection_default);
		$this->set('cubewidth',      $this->cubewidth_default);
		$this->set('cubeheight',     $this->cubeheight_default);
		$this->set('animSpeed',   $this->animSpeed_default);
		$this->set('pauseTime',   $this->pauseTime_default);
		$this->set('reduction',  $this->reduction_default);
		$this->set('cubeheight',200);
		$this->set('segments',20);
		
	}
	
	function edit () {
		$this->edit_utilities();
		
	}
	function edit_utilities () {
		$this->set('pageSelector', Loader::helper('form/page_selector'));
		$url = Loader::helper('concrete/urls');
		$this->set('tools_url', $url->getToolsURL('options','image_cube'));
		$this->set('form', Loader::helper('form'));

		$html = Loader::helper('html');
		$this->addHeaderItem($html->css($this->get_block_url() . '/auto.css'));


		Loader::model('file_set');
		Loader::model('file_attributes');
		
		$this->set('fileAttributes', FileAttributeKey::getList()); 
		$this->set('s1', FileSet::getMySets());
		$this->set('options', explode(',',$this->options));
		$this->set('bUrl',$this->get_block_url());
	}
	
	public function on_page_view() {
		/* Themes pas assez solide
		if ($this->theme != 'default'){
			$html = Loader::helper('html');
			$this->addHeaderItem($html->css($this->get_block_url() . "/themes/$this->theme/$this->theme.css"));			
		}
		*/
	}
	
	public function getBlockTypeDescription() {
		return t("jQuery Image Cube ported by Ioan Oltean.");
	}
	
	public function getBlockTypeName() {
		return t("Image Cube");
	}
	public function getJavaScriptStrings() {
	return array(
		'fsID-required' => t('You must enter a fileset.'),
	);
	}
	
	function view() {
		$this->set('bID', $this->bID ? 	$this->bID : rand(1,1000)+2000);
		$this->set('gal', $this->getGallery());
		$this->set('hh', 0);
		$this->set('options', explode(',', $this->options));
		$this->set('c', Page::getCurrentPage());
		$this->set('theme','default');
	}
	
	
	
	public function getGallery() {
			// Check compatibility with Concrete 5.4.1
			if ($this->db->getAll("SHOW COLUMNS FROM FileSetFiles LIKE 'fsDisplayOrder'") ) {
				$data = $this->db->getAll("SELECT fsID,fID FROM FileSetFiles WHERE fsID=? ORDER BY fsDisplayOrder", array($this->fsID) );				
			} else {
				$data = $this->db->getAll("SELECT fsID,fID FROM FileSetFiles WHERE fsID=? ORDER BY timestamp", array($this->fsID) );				
			}
			if (!is_array($data)) return false;
			Loader::model('file');
			$nv = Loader::helper('navigation');
			$i = Loader::helper('image');
			
			$v = array();
			$cc = 0;
			if ($this->link == 'multipages') {
				$pla = explode(',',$this->linkPageID);
				$pli = explode(',',$this->fileLink);
			}
			
			foreach ($data as $d){
			  $img = File::getByID($d['fID']);
			  $s = @getimagesize($img->getPath());
			  // this test take some time if you want to improve speed, delete from here
			  $fv = $img->getExtension();
			  Loader::library('file/types');
			  $ft = FileTypeList::getType($fv);
			  if ($ft->type == 1) {
			  // to here
				if( (bool) $this->link) {
					$v[$cc]['isLink'] = true; 
					switch ($this->link) {
						case 'image' :
						      $v[$cc]['link'] = $img->getRelativePath();
						break;
						case 'page' :
							$page = Page::getByID($this->linkPageID);
							$v[$cc]['link'] = $nv->getLinkToCollection($page);
						break;
						case 'multipages':
							$page = Page::getByID($pla[array_search($d['fID'],$pli)]);
							if($page->cID)
								$v[$cc]['link'] = $nv->getLinkToCollection($page);
							else
								$v[$cc]['isLink'] = false;
						break;
				      
				      }
				}
				$v[$cc]['desc'] = 	$this->getFileFieldValue($img,$this->fsDescription);
				$v[$cc]['title'] =	$this->getFileFieldValue($img,$this->fsTitle);
				$v[$cc]['alt'] =	$img->getTitle();			
				$v[$cc]['width'] = 	$s[0] ;
				$v[$cc]['height'] = 	$s[1] ;
				$v[$cc]['src'] = 	$i->getThumbnail($img,$s[0],$s[1])->src;
				$v[$cc]['thumb'] = 	$i->getThumbnail($img,50,50)->src;
				$cc ++;
			  }
			}
			return $v;
	}
	
	private function getFileFieldValue($f,$handle) {
	if(!is_object($f)) {
		return false;
	}
	$value = "";
	switch($handle) {
		case "title";
			$value = $f->getTitle();
		break;
		case "description";
			$value = $f->getDescription();
		break;
		case "date":
			$value = $f->getDateAdded();
		break;
		case "filename":
			$value = $f->getFileName();
		break;
		default:
			$value = $f->getAttribute($handle);
		break;
	}
	return $value;
}
	function save ($data) {
		
		// some check 
		$data['cubewidth'] = 	(is_numeric($data['cubewidth']) && $data['cubewidth'] >= 0) ? $data['cubewidth'] : $this->cubewidth_default;
		$data['animSpeed'] = 	(is_numeric($data['animSpeed']) && $data['animSpeed'] > 0 ) ? $data['animSpeed'] : $this->animSpeed_default;
		$data['cubeheight'] = 	(is_numeric($data['cubeheight']) && $data['cubeheight'] > 0 ) ? $data['cubeheight'] : $this->cubeheight_default;
		$data['pauseTime'] = 	(is_numeric($data['pauseTime']) && $data['pauseTime'] > 0) ? $data['pauseTime'] : $this->pauseTime_default;
		$data['reduction'] = 	(is_numeric($data['reduction']) && $data['reduction'] >= 0) ? $data['reduction'] : $this->reduction_default;
		//var_dump($data['options']);
		$data['options'] = 	is_array($data['options']) ? implode(',',$data['options']) : $data['options'];
		parent::save($data);

	}
	function get_block_url() {
		$pkg_handle =  'image_cube';
		return BASE_URL . DIR_REL . '/' . DIRNAME_PACKAGES . '/' . $pkg_handle . '/' . DIRNAME_BLOCKS . '/' . $pkg_handle;
	}
	public function addKeyToArray ($array) {
		if (is_array($array)) {
			$return = array();
			foreach ($array as $k) {
			$return[$k] = $k;
		}
		return $return;
		}
	}
}
?>

<?php
/**
*
*/

namespace JFStudio;

class Layout
{
	# const vars
	const ROOT = "../";
	# public vars
	public $_page_name = "";
	public $_layout    = "";
	public $_view      = "";
	public $_js_path   = null;
	public $_css_path  = null;
	public $_path      = "";
	public $_vars      = [];
	public $_warnings  = [];
	public $_root      = null;
	public $_css_files = null;
	public $_js_files  = null;
	public $_layout_root= null;
	public $virtual_view= null;
	public $_view_root  = null;
	public $content_virtual_view = null;
	public $_pretitle  = 'Gran Capital Fund - ';
	public $modules    = [];
	# protected vars

	# private vars

	# __construct::
	# INPUT = (String)$page_name = Title used in <title> tags
	#       = (String)$view = Name of "$view".view.php
	#       = (String)$layout = Name of "$layout".layout.php
	#       = (String)$root = path of caller
	private static $instance;

	public static function getInstance()
 	{
	    if(!self::$instance instanceof self)
	      self::$instance = new self;

	    return self::$instance;
 	}

	public function init($page_name = 'Página', $view = false, $layout = false, $root = "", $layout_root = "../../", $view_root = false,$virtual_view = false)
	{
		$this->_layout_root = ($layout_root) ? $layout_root : $root;
		$this->_view_root   = ($view_root) ? $view_root : $root;
		$this->virtual_view  = ($virtual_view) ? $virtual_view : $virtual_view;

		$this->_root = $root;
		
		if(isset($this->_css_path,$this->_js_path) == false) {
			$this->setScriptPath('../../src/');
		}

		$this->setPageName($this->_pretitle.$page_name);
		$this->getPath();
		$this->setLayout($layout);
		$this->setView($view);
		$this->setDefaultModules();
	}

	public function __destruct() { }

	public function __clone() { }

	private function getPath()
	{
		$__path = $_SERVER['PHP_SELF'];
		$__path = explode("/", $__path);
		$__path = $__path[count($__path)-2];

		return $this->_path = $__path;
	}

	private function getPageName()
	{
		return $this->_page_name;
	}

	public function makeVirtualFile() {
		$file = fopen($this->_view, "w") or die("Unable to open file!");
		fwrite($file, $this->getContentVirtualView());
		fclose($file);
	}

	public function getContentVirtualView() {
		return $this->content_virtual_view;
	}

	public function setContentVirtualView($content_virtual_view = null) {
		$this->content_virtual_view = $content_virtual_view;
	}

	private function setPageName($page_name)
	{
		$this->_page_name = $page_name;
	}

	private function setView($view)
	{
		if($view)
		{
			$this->_view = "{$this->_view_root}view/{$view}.view.php";

			if($this->virtual_view === false)
			{
				if( file_exists( $this->_view ) ) return true;
				else {
					$this->_warnings['ERROR_VIEW']['MESSAGE'] = 'VIEW NOT FOUND';
					$this->_warnings['ERROR_VIEW']['PATH'] = $this->_view;
					$this->_view = false;
					$this->showWarnings();
					exit();
				}
			}
		}
	}
	private function showWarnings()
	{
		echo count($this->_warnings) . '<n style="color:red"> WARNING ! <n><br>';

		foreach ($this->_warnings as $key => $_warning)
		{
			echo '<n style="color:green">';
			echo ' [ ' . $key . ' ] ';
			if(is_array($_warning))
			{
				foreach ($_warning as $_key => $_value)
					echo $_value.'<br>';
			} else echo $_warning;
			echo '</n>';
		}
	}
	private function setLayout($layout)
	{
		if($layout)
		{
			$this->_layout = "{$this->_layout_root}layout/{$layout}.layout.php";
			$this->_layout_root;

			if( file_exists( $this->_layout ) )
			    return true;
			else {
				$this->_warnings['ERROR_LAYOUT']['MESSAGE'] = 'LAYOUT NOT FOUND';
				$this->_warnings['ERROR_LAYOUT']['PATH'] = $this->_layout;
				$this->_layout = false;
				$this->showWarnings();
				exit();
			}
		}
	}

	public function __invoke($get_content = false,$layout_content = false,$view_content = false)
	{
		$this->display($get_content,$layout_content,$view_content);
	}

	public function display($get_content = false,$layout_content = false,$view_content = false)
	{
		if($this->_layout)
		{
			$__layout_content = ($layout_content) ? $layout_content : $this->getLayoutContent();
			$__view_content   = ($view_content) ? $view_content : $this->getViewContent();

			$__content = $this->runView($__layout_content,$__view_content);

			if($get_content) return $__content;

			echo $__content;
		} else {
			return false;
		}
	}

	public function replaceView(string $module,string $haystack,string $needle)
	{
		return str_replace("%{$module}%",$haystack,$needle);
	}

	public function runView( $layout_content, $view_content )
	{
		# replacing title page
		$__content = $this->replaceView("title",$this->_page_name,$layout_content);
		// $__content = str_replace( "%title%", $this->_page_name, $layout_content );
		# replacing content
		$__content = $this->replaceView("content",$view_content,$__content);

		# replacing js scripts
		if($this->_js_scripts)
			$__content = $this->replaceView("js_scripts",$this->_js_scripts,$__content);
		else $__content = $this->replaceView("js_scripts","",$__content);

		# replacing css scripts
		if($this->_css_scripts)
			$__content = $this->replaceView("css_scripts",$this->_css_scripts,$__content);
		else $__content = $this->replaceView("css_scripts","",$__content );

		# looking for modules
		if($this->modules)
		{
			foreach ($this->modules as $module)
			{
				if($find_start = strpos($__content, $module) )
				{
					$module_size = strlen($module);
					$data = substr($__content, ($find_start + $module_size) );

					if( $find_end = strpos($data, $module))
					{
						$data = substr($data, 0, $find_end);

						# deleting old data from html
						$__content = str_replace( $module . $data . $module, "", $__content );

						# adding new data content for layout
						$__content = str_replace( $module, $data, $__content );
					} else $__content = str_replace( $module, '', $__content );
				}
			}
		}

		return $__content;
	}

	# function:: adds the defaults modules
	public function setDefaultModules()
	{
		$this->setModule("aside");
		$this->setModule("footer");
		$this->setModule("headerController");
		$this->setModule("menu");
		$this->setModule("scripts_async");
		$this->setModule("metadata");

		return true;
	}

	# function:: add new module
	# INPUT  = (String)$module_name = Module name
	# OUTPUT = true or 1
	public function setModule(string $name)
	{
		if($name && !$this->modules["%{$name}%"]) $this->modules[] = "%{$name}%";

		return true;
	}

	# function:: get the view content belogns html
	public function getViewContent()
	{
		ob_start();
		extract($this->_vars);
	  	include $this->_view;
		$__content = ob_get_contents();
		ob_end_clean();

		return $__content;
	}

	# function:: get the layout content belogns html
	# OUTPU = (String)$__content
	public function getLayoutContent()
	{
		ob_start();
		extract($this->_vars);
		include $this->_layout;
		$__content = ob_get_contents();
		ob_end_clean();

		return $__content;
	}

	# function:: assings vars for using in "view".view.php
	# INPUT = (String)$name = Name of var
	#         (Array,String,Int,Bool,Long,Double)$value = value of var
	public function setVar($name = null,$value = null)
	{
		if(is_array($name))
		{
			foreach($name as $key => $_value)
			{
				$this->_vars[$key] = $_value;
			}

			return true;
		} else if( is_string($name) && $value ) {
			$this->_vars[$name] = $value;
			return true;
		}

		return false;
	}

	public function getHtml($layout_content = false,$view_content = false,$trim = true)
	{
		$content = false;

		if($trim === true) {
			$content = preg_replace('/\s+/',' ',$this->display(true,$layout_content,$view_content));

			if($this->virtual_view === true) {
				unlink($this->_view);
			}
		}

		return $content;
	}
	
	# function:: adds scripts to "view".view.php
	# INPUT = (String)$files_names = files separated by ampersent
	# Example setScript("style.css & json.js")
	public function setScript($files_names = false,$clear_cache = false)
	{
		if($files_names)
		{
			foreach ($files_names as $key => $value)
			{
				$value .= "?t=".time();

				if( !strpos($value,".css") === false )
					$this->_css_scripts[] = $value;
				else if( !strpos($value,".js") === false )
					$this->_js_scripts[] = $value;
				else if(!strpos($value,".*") === false ) {
					$this->_css_scripts[] = str_replace("*", "css", $value);
					$this->_js_scripts[] = str_replace("*", "js", $value);
				}
			}

			if( $this->_css_scripts )
				$this->_css_scripts = $this->setCssScripts();

			if( $this->_js_scripts )
				$this->_js_scripts = $this->setJsScripts();
		}
	}

	# function:: adds js scripts to "view".view.php
	# extended by setScript()
	# fixed fo vuejs
	public function isJsModule($script = null)
	{
		return strpos($script, ".module.") !== false || strpos($script, ".vue.") !== false;
	}
	public function setJsScripts()
	{
		$__files_names = null;

		foreach ($this->_js_scripts as $js_file_name) {
			if($this->isJsModule($js_file_name) === true)
			{
				$__files_names .= "<script type='module' src='{$this->_root}{$this->_js_path}js/{$js_file_name}'></script>";
			} else {
				$__files_names .= "<script src='{$this->_root}{$this->_js_path}js/{$js_file_name}'></script>";
			}
		}

		return $__files_names;
	}

	# function:: adds css scripts to "view".view.php
	# extended by setScript()
	public function setCssScripts()
	{
		$__files_names = null;
		foreach ($this->_css_scripts as $key => $css_file_name)
			$__files_names .= "<link rel='stylesheet' type='text/css' href='{$this->_root}{$this->_css_path}css/{$css_file_name}'>";

		return $__files_names;
	}

	public function setScriptPath($script_path)
	{
		$this->_css_path = $script_path;
		$this->_js_path  = $script_path;
	}

	public function setScript_css_path($css_path)
	{
		$this->_css_path = $css_path;
	}

	public function setScript_js_path($js_path)
	{
		$this->_js_path = $js_path;
	}
}
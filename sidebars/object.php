<?php


class Sidebar_Settings_Object extends Runway_Object {

	public $option_key, $sidebars_options;

	public function __construct($settings){
		$this->option_key = $settings['option_key'];
		$this->sidebars_options = get_option( $this->option_key );
		add_action('init', array($this, 'add_shortcodes'));
		add_action('widgets_init', array($this, 'init_sidebars'));
	}

	public function add_shortcodes(){
		add_shortcode('sidebar', array($this, 'sidebar_shortcode'));		
	}
	
	function init_sidebars(){
		// Register each sidebar
	    $sidebars = $this->get_sidebars();

	    if(is_array($sidebars)){
			global $shortname;

			$sidebarName = get_option( $shortname. 'sidebarSettings'); // get name values

			foreach($sidebars as $key => $value){
				$id = $key;
				$name = $value['title'];
				$description = $value['description'];
				$alias = $value['alias'];
				
				$sidebar_class = $this->name_to_class($alias);
				
				register_sidebar(array(
			    	'name'=>$name,
					'id'=> "generated_sidebar-$id",
					'description'   => $description,
			    	'before_widget' => '<div id="%1$s" class="widget scg_widget '.$sidebar_class.' %2$s">',
		   			'after_widget' => '</div>',
		   			'before_title' => '<h4 class="widgetTitle">',
					'after_title' => '</h4>',
		    	));				
			}
		}
	}

	// Gets the generated sidebars
	//...............................................
	function get_sidebars(){		
		return $this->sidebars_options['sidebars_list'];
	}
	
	function name_to_class($name){
		$class = str_replace(array(' ',',','.','"',"'",'/',"\\",'+','=',')','(','*','&','^','%','$','#','@','!','~','`','<','>','?','[',']','{','}','|',':',),'',$name);
		return $class;
	}

	// sidebar shortcode callback
	function sidebar_shortcode( $atts, $content = null ) {
		global $wp_registered_sidebars, $wp_registered_widgets;
		extract(shortcode_atts(array(
			'alias' => false
	    ), $atts));	    
		
		if ( $alias ) {
			// find the sidebar ID by the alias
			$sidebars = $this->get_sidebars();
			foreach($sidebars as $key => $value){
				if (isset($value['alias']) && $value['alias'] == $alias) {
					$id = $key;
					break;
				}
			}
		
			if ($id) {
				// turn on output buffering to capture output
				ob_start();
				// generate sidebar
				dynamic_sidebar($id);
				// get output content
				$content = ob_get_clean();
				// return the content
				return $content;
			}
		}

	}

} ?>
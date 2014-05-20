<?php
function mslide_widget() {
	register_widget( 'mslide_init_widget' );
}
class mslide_init_widget extends WP_Widget {

	function mslide_init_widget() {
		// Instantiate the parent object
		parent::__construct( false, 'Memphis Sliding Menu' );
	}
	
	function widget( $args, $instance ) {
		$exclude_parents = get_option('mslide-exclude-list');
		$exclude_list = array();
		foreach($exclude_parents as $index => $parent) {
			$args =  array(
				'child_of' => $parent,
				'post_status' => 'publish'
			);
			$children = get_pages($args);
			foreach($children as $index =>$child) {
				array_push($exclude_list, $child->ID);
			}
		}
		$exclude = implode(',',$exclude_list).','.implode(',',$exclude_parents);
		if ( is_user_logged_in() ) $post_status = array('private','publish');
		else $post_status = array('publish');
		$args =  array(
			'link_before' => '',
			'link_after' => '<div></div>',
			'title_li' => '',
			'sort_column' => 'menu_order',
			'post_status' => $post_status,
			'exclude' => $exclude
		);
		?>
		<script>
			jQuery(document).ready(function(){
				memphis_sliding_menu();
			});
		</script>
		<div class="memphis-sliding-menu noprint">
			<ul> <?php wp_list_pages($args); ?> </ul>
		</div>
		<?php
	}

	function update( $new_instance, $old_instance ) {
		// Save widget options
	}

	function form( $instance ) {
		// Output admin widget options form
		if(!empty($_POST)  && isset($_POST['mslide-post-id'])) update_option('mslide-exclude-list',$_POST['mslide-post-id']);
		elseif(!empty($_POST) && !isset($_POST['mslide-post-id'])) update_option('mslide-exclude-list',array());
		$include = INCLUDE_LIST;
		$list_array = array('private','publish','draft', 'pending');
		$args =  array(
			'sort_column' => 'menu_order',
			'post_status' => $list_array,
		);
		$page_list = get_pages($args);
		$hidden_pages = get_option('mslide-exclude-list');
		$depth = 0;
		echo '<p>'.__('This menu is sorted using the Pages component for WordPress.  If you are looking to change the page order, make your changes there.').'</p>';
		echo '<ul class="mslide-list">';
		foreach($page_list as $index => $page) {
			$current_depth = 0;
			$parent_id = $page->post_parent;
			while($parent_id > 0) {
				$test_page = get_page($parent_id);
				$parent_id = $test_page->post_parent;
				$current_depth++;			
			}
			if($current_depth > $depth) { echo '<ul>'; $depth = $current_depth; }
			if($current_depth < $depth) {
				$diff = $depth - $current_depth;
				for($i=0; $i < $diff; $i++) echo '</ul>';
				$depth = $current_depth;
			}
			if($page->post_status != 'publish') $page_title = $page->post_title.' - <i><b>'.$page->post_status.'</b></i>';
			else $page_title = $page->post_title;
			if(in_array($page->ID, $hidden_pages)) echo '<li><input name="mslide-post-id[]" value="'.$page->ID.'" type="checkbox" checked />'.$page_title.'</li>';
			else echo '<li><input name="mslide-post-id[]" value="'.$page->ID.'" type="checkbox" />'.$page_title.'</li>';
			$parent_id = $page->post_parent;
		}
		echo '</ul>';
	}
	
}
function mslide_script() {
	wp_enqueue_style( 'memphis-sliding-menu-style', plugins_url().'/memphis-sliding-menu/mslide-css.php' );
	wp_enqueue_script( 'memphis-sliding-menu-script', plugins_url().'/memphis-sliding-menu/memphis-sliding-menu.js');
}
function mslide_admin_script() {
	//LOAD MEMPHIS SLIDING MENU SCRIPTS
	wp_enqueue_style( 'memphis-sliding-menu-style', plugins_url().'/memphis-sliding-menu/mslide-admin-css.php' );
	wp_enqueue_script( 'memphis-sliding-menu-script', plugins_url().'/memphis-sliding-menu/memphis-sliding-menu.js');
	//WORDPRESS IRIS COLOR PICKER
	wp_enqueue_style( 'wp-color-picker' );
    wp_enqueue_script( 'mdocs-color-picker', plugins_url('memphis-sliding-menu.js', __FILE__ ), array( 'wp-color-picker' ), false, true );
}
function mslide_admin_document_ready() {
?>
<script>
	jQuery(document).ready(function(){
		mslide_admin_menu();
	});
</script>
<?php
}
?>
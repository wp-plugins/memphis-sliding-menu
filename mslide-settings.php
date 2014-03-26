<?php
function mslide_admin() {
	register_setting('mslide-config','mslide-exclude-list');
	add_option('mslide-exclude-list',array());
	//update_option('mslide-exclude-list',array(5,22,483,582,1427,1813));
}
?>
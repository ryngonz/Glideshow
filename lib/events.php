<?php
/* Update */

if (isset($_POST["update_settings"])) :
	
	foreach($_POST as $postname=>$val){
		if($postname == "glides"){
			update_option($postname, json_encode($val));	
		}else{
			update_option($postname, $val);
		}
	}

	add_action( 'admin_notices', 'glideshow_admin_notice' );

endif;

function glideshow_admin_notice() {
    ?>
    <div class="updated">
        <p><?php _e( 'Settings has successfully been updated.', 'glideshow-notification' ); ?></p>
    </div>
    <?php
}

/* END - Update */
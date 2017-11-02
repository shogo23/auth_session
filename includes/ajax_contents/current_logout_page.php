<?php
    $options = get_option( 'AS_Auth_Session' );
    $options = json_decode( $options, true );
    $page = $options['as_options']['page_logout_redirect'];
?>

<div class="AS_admin_current_logout_page_container">
    <?php echo $page; ?>
</div>
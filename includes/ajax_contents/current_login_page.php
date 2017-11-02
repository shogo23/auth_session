<?php
    $options = get_option( 'AS_Auth_Session' );
    $options = json_decode( $options, true );
    $page = $options['as_options']['page_login_redirect'];
?>

<div class="AS_admin_current_login_page_container">
    <?php echo $page; ?>
</div>
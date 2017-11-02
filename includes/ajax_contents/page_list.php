<?php
  use Shogo\Auth_Session\Classes\Actions;

  $action = new Actions();
  $current_pages = get_option( 'AS_Auth_Session' );
  $current_pages = json_decode( $current_pages, true );
?>

<ul>
    <?php $i = 0; foreach ( $action->get_pages() as $page ): $i++; ?>
        <?php if ( ! in_array( $page->post_name, $current_pages['as_options']['restrict_pages'] ) && ( $page->post_name !== 'sa-session-login' && $page->post_name !== 'sa-session-logout' ) ): ?>
            <li class="p_<?= $i; ?> l_page" id="<?= $page->post_name ?>"><?= $page->post_name ?></li>
        <?php endif; ?>
    <?php endforeach; ?>
</ul>

<script type="text/javascript">
    var page_selected = "";

    jQuery(".AS_admin_page_list ul li").each(function( i ) {
        i = i + 1;

        jQuery(".AS_admin_page_list ul li:nth-child(" + i + ")").on("click", function() {
            jQuery(".AS_admin_page_list ul li").css("background-color", "transparent").css("color", "#000");
            jQuery(".AS_admin_page_list ul li:nth-child(" + i + ")").css("background-color", "blue").css("color", "#fff");
            page_selected = jQuery(".AS_admin_page_list ul li:nth-child(" + i + ")").attr( "id" );
        });
    });
</script>

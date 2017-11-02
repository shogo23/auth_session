<?php
  use Shogo\Auth_Session\Classes\Actions;

  $action = new Actions();
  $current_pages = get_option( 'AS_Auth_Session' );
  $current_pages = json_decode( $current_pages, true );
?>

<?php foreach ( $action->get_pages() as $page ): ?>
  <?php if ( ( $page->post_name !== $current_pages['as_options']['page_login_redirect'] ) && ( ( $page->post_name !== $current_pages['as_options']['page_logout_redirect'] ) ) && ( $page->post_name !== 'sa-session-login' && $page->post_name !== 'sa-session-logout' ) ): ?>
    <option value="<?= $page->post_name ?>"><?= $page->post_name; ?></option>
  <?php endif; ?>
<?php endforeach; ?>

<script type="text/javascript">
  page_login_selected = jQuery(".AS_admin_login_redirect_page_list_mobile option:first-child").val();
</script>

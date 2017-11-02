<?php
  use Shogo\Auth_Session\Classes\Actions;

  $action = new Actions();
  $current_pages = get_option( 'AS_Auth_Session' );
  $current_pages = json_decode( $current_pages, true );
?>

<?php foreach ( $action->get_pages() as $page ): ?>
  <?php if ( ! in_array( $page->post_name, $current_pages['as_options']['restrict_pages'] ) && ( $page->post_name !== 'sa-session-login' && $page->post_name !== 'sa-session-logout' ) ): ?>
    <option value="<?= $page->post_name ?>"><?= $page->post_name ?></option>
  <?php endif; ?>
<?php endforeach; ?>

<script type="text/javascript">
  page_selected = jQuery(".AS_admin_page_list_mobile option:first-child").val();
</script>

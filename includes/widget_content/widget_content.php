<?php

  use Shogo\Auth_Session\Classes\Actions;
  use Shogo\Auth_Session\Classes\Recaptcha;

  $action = new Actions();
  $session = $action->session_details();
  $is_logged_in = $session['AS_is_logged_in'];
  $session_name = $session['session_name'];
  $recaptcha = new Recaptcha();
?>

<?php if ( !$is_logged_in ): ?>
  <ul>
    <li>
      <a href="<?= get_site_url() ?>/sa-session-login/">Login</a>
    </li>
  </ul>
<?php else: ?>
  <ul>
    <li>Welcome <?= $session_name; ?></li>
    <li>
      <div class="AS_widget_logout">
        <a href="<?= get_site_url() . '/sa-session-logout'; ?>">Logout</a>
      </div>
    </li>
  </ul>
<?php endif; ?>

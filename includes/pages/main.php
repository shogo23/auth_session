<?php
  use Shogo\Auth_Session\Classes\Actions;

  $action = new Actions();
?>

<div class="AS_admin_main_container">
    <h1><?php _e( 'Session Lists' ) ?></h1>
    <?php if ( $action->session_count() == 0 ): ?>
        <div class="AS_admin_main_session_empty">
          There are no sessions at this time.
        </div>
    <?php else: ?>
        <table class="AS_admin_main_table" cellpadding="0" cellspacing="0">
            <thead>
                <tr>
                    <th><?php _e( 'Session Name' ); ?></th>
                    <th><?php _e( 'Authentication Code' ) ?></th>
                    <th><?php _e( 'Start Date' ) ?></th>
                    <th><?php _e( 'End Date' ) ?></th>
                    <th><?php _e( 'Status' ) ?></th>
                    <th><?php _e( 'Created' ) ?></th>
                    <th>&nbsp;</th>
                    <th>&nbsp;</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ( $action->session_results() as $result ): ?>
                    <tr>
                        <td><?= $result->session_name ?></td>
                        <td><?= $result->session_auth ?></td>
                        <td><?= $action->datetimeToStr( $result->start_date ) ?></td>
                        <td><?= $action->datetimeToStr( $result->end_date ) ?></td>
                        <td><?= $action->session_status( $result->start_date, $result->end_date ) ?></td>
                        <td><?= $result->created ?></td>
                        <td><a href="<?= admin_url( 'admin.php?page=as_create_auth&edit=' . $result->id ) ?>">Edit</a></td>
                        <td><a href="javascript: AS_delete(<?= $result->id ?>)">Delete</a></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

      <script type="text/javascript">

        function AS_delete( id ) {
          var c = confirm("Are you sure you want to delete this session?");

          if ( c ) {
            var data = {
              "action": "AS_auth_session",
              "operation": "delete_session",
              "id": id
            }

            jQuery.post(ajaxurl, data, function(r) {
              location.reload();
            });
          }
        }

      </script>
    <?php endif; ?>
</div>

<div class="AS_admin_main_container_mobile">
  <h1><?php _e( 'Session Lists' ) ?></h1>

  <?php if ( $action->session_count() == 0 ):  ?>
    <div class="AS_admin_main_session_empty">
      There are no sessions at this time.
    </div>
  <?php else: ?>
    <ul class="AS_admin_main_mobile">
      <?php foreach ( $action->session_results() as $result ): ?>
        <li class="AS_admin_session_mobile">
          <ul>
            <li>
              <span style="font-weight: bold;"><?php _e( 'Session Name:' ) ?></span><br />
              <?= $result->session_name ?>
            </li>
            <li>
              <span style="font-weight: bold;"><?php _e( 'Authentication Code:' ) ?></span><br />
              <?= $result->session_auth ?>
            </li>
            <li>
              <span style="font-weight: bold;"><?php _e( 'Start Date:' ) ?></span><br />
              <?= $action->datetimeToStr( $result->start_date ) ?>
            </li>
            <li>
              <span style="font-weight: bold;"><?php _e( 'End Date:' ) ?></span><br />
              <?= $action->datetimeToStr( $result->end_date ) ?>
            </li>
            <li>
              <span style="font-weight: bold;"><?php _e( 'Status:' ) ?></span><br />
              <?= $action->session_status( $result->start_date, $result->end_date ) ?>
            </li>
          </ul>
          <a class="button" href="<?= admin_url( 'admin.php?page=as_create_auth&edit=' . $result->id ) ?>">Edit</a>
          <a class="button" href="javascript: AS_delete(<?= $result->id ?>)">Delete</a>
        </li>
      <?php endforeach; ?>
    </ul>
  <?php endif; ?>
</div>


<div class="AS_form_container">
  <?= $auth_session->Form->page_authorize() ?>
  <?= $auth_session->Form->start(); ?>
    <field>
      <span style="color: red;"><?= $auth_session->Form->validation_message() ?></span>
      <?= $auth_session->Form->label(); ?>
      <?= $auth_session->Form->auth_field() ?>
    </field>
    <div>
      <?= $auth_session->Form->recaptcha() ?>
    </div>
    <div>
      <?= $auth_session->Form->submit() ?>
    </div>
  <?= $auth_session->Form->end(); ?>
</div>

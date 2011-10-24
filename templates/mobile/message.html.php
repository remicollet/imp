<div id="message" data-role="page">
  <div data-role="header">
    <a href="#" id="imp-message-back" data-icon="arrow-l" data-direction="reverse"><?php echo _("Mailbox") ?></a>
    <h1 id="imp-message-title">&nbsp;</h1>
    <?php if ($this->logout): ?>
    <a href="<?php echo $this->logout ?>" rel="external" data-theme="e" data-icon="delete"><?php echo _("Log out") ?></a>
    <?php endif ?>
  </div>
  <div class="ui-body ui-body-c">
    <strong id="imp-message-subject"></strong><br>
    <small id="imp-message-date"></small>
  </div>
  <div class="ui-body ui-body-c">
    <a id="imp-message-more" href="#" data-role="button" data-icon="arrow-d" data-iconpos="notext"><?php echo _("Show more") ?></a>
    <?php echo _("From:") ?> <span id="imp-message-from"></span>
  </div>
  <div class="ui-body ui-body-c" style="display:hidden">
    <a id="imp-message-less" href="#" data-role="button" data-icon="arrow-u" data-iconpos="notext"><?php echo _("Show less") ?></a>
    <table id="imp-message-headers"><tbody></tbody></table>
  </div>
  <div id="imp-message-body" data-role="content"></div>
  <div data-role="footer" class="ui-bar">
    <div data-role="controlgroup" data-type="horizontal">
      <a href="#" id="imp-message-prev" data-role="button" data-icon="arrow-l"><?php echo _("Previous") ?></a>
      <a href="#" id="imp-message-next" data-role="button" data-icon="arrow-r"><?php echo _("Next") ?></a>
    </div>
    <div data-role="controlgroup" data-type="horizontal">
      <a href="#" id="imp-message-reply" data-role="button" data-icon="back"><?php echo _("Reply") ?></a>
      <a href="#" id="imp-message-forward" data-role="button" data-icon="forward"><?php echo _("Forward") ?></a>
    </div>
    <div data-role="controlgroup" data-type="horizontal">
      <a href="#" id="imp-message-delete" data-role="button" data-rel="dialog" data-icon="delete"><?php echo _("Delete") ?></a>
    </div>
  </div>
</div>

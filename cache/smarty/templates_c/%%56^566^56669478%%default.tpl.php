<?php /* Smarty version 2.6.31, created on 2022-11-15 12:58:04
         compiled from modules/Alerts/templates/default.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'sugar_translate', 'modules/Alerts/templates/default.tpl', 5, false),array('modifier', 'strstr', 'modules/Alerts/templates/default.tpl', 21, false),array('modifier', 'lower', 'modules/Alerts/templates/default.tpl', 26, false),array('modifier', 'replace', 'modules/Alerts/templates/default.tpl', 26, false),array('modifier', 'nl2br', 'modules/Alerts/templates/default.tpl', 36, false),)), $this); ?>
<?php echo $this->_tpl_vars['Flash']; ?>


<?php if (! $this->_tpl_vars['Flash']): ?>
<div class="clear-all-alerts-container">
    <a class="clear-all-alerts-btn btn btn-warning btn-xs"><?php echo smarty_function_sugar_translate(array('label' => 'LBL_CLEARALL'), $this);?>
</a>
    <?php echo '
    <script>
          $(\'.clear-all-alerts-btn\').unbind(\'click\').click(function (event) {
            $(\'.desktop_notifications:first .alert-dismissible .close\').each(function (i, v) {
              $(v).click();
            });
          });
    </script>
    '; ?>

</div>
<?php endif; ?>
<?php $_from = $this->_tpl_vars['Results']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['result']):
?>
    <div class="alert alert-<?php if ($this->_tpl_vars['result']->type != null): ?><?php echo $this->_tpl_vars['result']->type; ?>
<?php else: ?>info<?php endif; ?> alert-dismissible module-alert" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close" onclick="Alerts.prototype.markAsRead('<?php echo $this->_tpl_vars['result']->id; ?>
');"><span aria-hidden="true">&times;</span></button>
        <h4 class="alert-header">
        <?php if ($this->_tpl_vars['result']->url_redirect != null && ! ( ((is_array($_tmp=$this->_tpl_vars['result']->url_redirect)) ? $this->_run_mod_handler('strstr', true, $_tmp, 'fake_') : strstr($_tmp, 'fake_')) )): ?>
        <a class="alert-link text-<?php if ($this->_tpl_vars['result']->type != null): ?><?php echo $this->_tpl_vars['result']->type; ?>
<?php else: ?>info<?php endif; ?>" href="index.php?module=Alerts&action=redirect&record=<?php echo $this->_tpl_vars['result']->id; ?>
">
        <?php endif; ?>
            <?php if ($this->_tpl_vars['result']->target_module != null): ?>
                                <span class="suitepicon suitepicon-module-<?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['result']->target_module)) ? $this->_run_mod_handler('lower', true, $_tmp) : smarty_modifier_lower($_tmp)))) ? $this->_run_mod_handler('replace', true, $_tmp, '_', '-') : smarty_modifier_replace($_tmp, '_', '-')); ?>
<?php if (substr ( $this->_tpl_vars['result']->target_module , -1 ) !== 's'): ?>s<?php endif; ?>"></span>
                <strong class="text-<?php if ($this->_tpl_vars['result']->type != null): ?><?php echo $this->_tpl_vars['result']->type; ?>
<?php else: ?>info<?php endif; ?>"><?php echo $this->_tpl_vars['result']->target_module; ?>
</strong>
            <?php else: ?>
                <strong class="text-<?php if ($this->_tpl_vars['result']->type != null): ?><?php echo $this->_tpl_vars['result']->type; ?>
<?php else: ?>info<?php endif; ?>">Alert</strong>
            <?php endif; ?>
        <?php if ($this->_tpl_vars['result']->url_redirect != null): ?>
        </a>
        <?php endif; ?>
        </h4>
        <p class="alert-body">
            <?php echo ((is_array($_tmp=$this->_tpl_vars['result']->name)) ? $this->_run_mod_handler('nl2br', true, $_tmp) : smarty_modifier_nl2br($_tmp)); ?>
<br/>
            <?php echo ((is_array($_tmp=$this->_tpl_vars['result']->description)) ? $this->_run_mod_handler('nl2br', true, $_tmp) : smarty_modifier_nl2br($_tmp)); ?>

        </p>
    </div>
<?php endforeach; endif; unset($_from); ?>

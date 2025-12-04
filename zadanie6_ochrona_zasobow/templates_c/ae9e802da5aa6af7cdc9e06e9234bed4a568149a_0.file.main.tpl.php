<?php
/* Smarty version 3.1.47, created on 2025-11-27 17:34:48
  from 'C:\xampp\htdocs\zadanie5_kontroler_glowny\app\views\templates\main.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.47',
  'unifunc' => 'content_69287da83f4c92_13518033',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'ae9e802da5aa6af7cdc9e06e9234bed4a568149a' => 
    array (
      0 => 'C:\\xampp\\htdocs\\zadanie5_kontroler_glowny\\app\\views\\templates\\main.tpl',
      1 => 1764261191,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_69287da83f4c92_13518033 (Smarty_Internal_Template $_smarty_tpl) {
?><nav class="navbar navbar-expand-lg navbar-dark nav-custom">
    <div class="container">
        <a class="navbar-brand fw-bold" href="<?php echo $_smarty_tpl->tpl_vars['conf']->value->action_root;?>
simpleView">
            <i class="fas fa-calculator me-2"></i>Kalkulatory
        </a>
        <div class="navbar-nav ms-auto">
            <a class="nav-link <?php if ((isset($_smarty_tpl->tpl_vars['current_page']->value)) && $_smarty_tpl->tpl_vars['current_page']->value == 'simple') {?>active<?php }?>" href="<?php echo $_smarty_tpl->tpl_vars['conf']->value->action_root;?>
simpleView">
                <i class="fas fa-calculator me-1"></i>Prosty
            </a>
            <a class="nav-link <?php if ((isset($_smarty_tpl->tpl_vars['current_page']->value)) && $_smarty_tpl->tpl_vars['current_page']->value == 'credit') {?>active<?php }?>" href="<?php echo $_smarty_tpl->tpl_vars['conf']->value->action_root;?>
creditView">
                <i class="fas fa-home me-1"></i>Kredytowy
            </a>
            <?php if (!(isset($_smarty_tpl->tpl_vars['show_logout']->value)) || $_smarty_tpl->tpl_vars['show_logout']->value != false) {?>
            <a class="nav-link" href="<?php echo $_smarty_tpl->tpl_vars['conf']->value->action_root;?>
logout">
                <i class="fas fa-sign-out-alt me-1"></i>Wyloguj (<?php echo (($tmp = @$_smarty_tpl->tpl_vars['user']->value)===null||$tmp==='' ? "Gość" : $tmp);?>
)
            </a>
            <?php }?>
        </div>
    </div>
</nav><?php }
}

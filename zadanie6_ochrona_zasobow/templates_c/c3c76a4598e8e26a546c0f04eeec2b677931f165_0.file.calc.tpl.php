<?php
/* Smarty version 3.1.47, created on 2025-11-27 18:04:11
  from 'C:\xampp\htdocs\zadanie5_kontroler_glowny\app\views\calc.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.47',
  'unifunc' => 'content_6928848b933280_78490150',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'c3c76a4598e8e26a546c0f04eeec2b677931f165' => 
    array (
      0 => 'C:\\xampp\\htdocs\\zadanie5_kontroler_glowny\\app\\views\\calc.tpl',
      1 => 1764261209,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_6928848b933280_78490150 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, true);
?>


<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_294815936928848b91ed45_12659080', 'content');
$_smarty_tpl->inheritance->endChild($_smarty_tpl, "templates/main.tpl");
}
/* {block 'content'} */
class Block_294815936928848b91ed45_12659080 extends Smarty_Internal_Block
{
public $subBlocks = array (
  'content' => 
  array (
    0 => 'Block_294815936928848b91ed45_12659080',
  ),
);
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

<form action="<?php echo $_smarty_tpl->tpl_vars['conf']->value->action_root;?>
calcCompute" method="post">
    <div class="row g-3">
        <div class="col-md-5">
            <div class="mb-3">
                <label for="id_x" class="form-label">Liczba 1:</label>
                <input id="id_x" type="text" name="x" value="<?php echo (($tmp = @$_smarty_tpl->tpl_vars['form']->value->x)===null||$tmp==='' ? '' : $tmp);?>
" 
                       class="form-control" placeholder="Wprowadź liczbę">
            </div>
        </div>
        
        <div class="col-md-2">
            <div class="mb-3">
                <label for="id_op" class="form-label">Działanie:</label>
                <select name="op" id="id_op" class="form-select">
                    <option value="plus" <?php if ((($tmp = @$_smarty_tpl->tpl_vars['form']->value->op)===null||$tmp==='' ? '' : $tmp) == 'plus') {?>selected<?php }?>>+</option>
                    <option value="minus" <?php if ((($tmp = @$_smarty_tpl->tpl_vars['form']->value->op)===null||$tmp==='' ? '' : $tmp) == 'minus') {?>selected<?php }?>>-</option>
                    <option value="times" <?php if ((($tmp = @$_smarty_tpl->tpl_vars['form']->value->op)===null||$tmp==='' ? '' : $tmp) == 'times') {?>selected<?php }?>>×</option>
                    <option value="div" <?php if ((($tmp = @$_smarty_tpl->tpl_vars['form']->value->op)===null||$tmp==='' ? '' : $tmp) == 'div') {?>selected<?php }?>>÷</option>
                </select>
            </div>
        </div>
        
        <div class="col-md-5">
            <div class="mb-3">
                <label for="id_y" class="form-label">Liczba 2:</label>
                <input id="id_y" type="text" name="y" value="<?php echo (($tmp = @$_smarty_tpl->tpl_vars['form']->value->y)===null||$tmp==='' ? '' : $tmp);?>
" 
                       class="form-control" placeholder="Wprowadź liczbę">
            </div>
        </div>
    </div>
    
    <div class="text-center mt-4">
        <button type="submit" class="btn btn-primary">Oblicz</button>
    </div>
</form>

<?php if ($_smarty_tpl->tpl_vars['msgs']->value->isError()) {?>
    <div class="error-box">
        <h5>Wystąpiły błędy:</h5>
        <ul class="mb-0">
            <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['msgs']->value->getErrors(), 'err');
$_smarty_tpl->tpl_vars['err']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['err']->value) {
$_smarty_tpl->tpl_vars['err']->do_else = false;
?>
                <li><?php echo $_smarty_tpl->tpl_vars['err']->value;?>
</li>
            <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
        </ul>
    </div>
<?php }?>

<?php if ($_smarty_tpl->tpl_vars['msgs']->value->isInfo()) {?>
    <div class="inf-box" style="background: #d1ecf1; padding: 1rem; border-radius: 5px; margin-top: 1rem;">
        <h5>Informacje:</h5>
        <ul class="mb-0">
            <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['msgs']->value->getInfos(), 'inf');
$_smarty_tpl->tpl_vars['inf']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['inf']->value) {
$_smarty_tpl->tpl_vars['inf']->do_else = false;
?>
                <li><?php echo $_smarty_tpl->tpl_vars['inf']->value;?>
</li>
            <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
        </ul>
    </div>
<?php }?>

<?php if ((isset($_smarty_tpl->tpl_vars['res']->value->result))) {?>
    <div class="result-box">
        <h5>Wynik:</h5>
        <p class="h4 mb-0"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['form']->value->x)===null||$tmp==='' ? 0 : $tmp);?>
 <?php echo $_smarty_tpl->tpl_vars['res']->value->op_name;?>
 <?php echo (($tmp = @$_smarty_tpl->tpl_vars['form']->value->y)===null||$tmp==='' ? 0 : $tmp);?>
 = <?php echo $_smarty_tpl->tpl_vars['res']->value->result;?>
</p>
    </div>
<?php }
}
}
/* {/block 'content'} */
}

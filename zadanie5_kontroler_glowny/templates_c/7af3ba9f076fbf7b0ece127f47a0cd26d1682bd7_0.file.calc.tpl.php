<?php
/* Smarty version 3.1.47, created on 2025-11-27 14:35:54
  from 'C:\xampp\htdocs\zadanie4_obiektowość\app\calc.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.47',
  'unifunc' => 'content_692853ba428966_39074448',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '7af3ba9f076fbf7b0ece127f47a0cd26d1682bd7' => 
    array (
      0 => 'C:\\xampp\\htdocs\\zadanie4_obiektowość\\app\\calc.tpl',
      1 => 1764249695,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_692853ba428966_39074448 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, true);
?>


<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_277839513692853ba413de1_05889946', 'content');
$_smarty_tpl->inheritance->endChild($_smarty_tpl, "../templates/main.tpl");
}
/* {block 'content'} */
class Block_277839513692853ba413de1_05889946 extends Smarty_Internal_Block
{
public $subBlocks = array (
  'content' => 
  array (
    0 => 'Block_277839513692853ba413de1_05889946',
  ),
);
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

<form action="<?php echo $_smarty_tpl->tpl_vars['app_url']->value;?>
/app/calc.php" method="post">
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

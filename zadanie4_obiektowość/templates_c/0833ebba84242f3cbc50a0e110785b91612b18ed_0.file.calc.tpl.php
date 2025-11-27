<?php
/* Smarty version 3.1.47, created on 2025-11-14 20:09:32
  from 'C:\xampp\htdocs\zadanie3_szablonowanie\templates\calc.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.47',
  'unifunc' => 'content_69177e6c2222e1_26246227',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '0833ebba84242f3cbc50a0e110785b91612b18ed' => 
    array (
      0 => 'C:\\xampp\\htdocs\\zadanie3_szablonowanie\\templates\\calc.tpl',
      1 => 1763147168,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_69177e6c2222e1_26246227 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, true);
?>


<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_186723740269177e6c1d9ba6_18843436', 'content');
$_smarty_tpl->inheritance->endChild($_smarty_tpl, "main.tpl");
}
/* {block 'content'} */
class Block_186723740269177e6c1d9ba6_18843436 extends Smarty_Internal_Block
{
public $subBlocks = array (
  'content' => 
  array (
    0 => 'Block_186723740269177e6c1d9ba6_18843436',
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
                <input id="id_x" type="text" name="x" value="<?php echo (($tmp = @$_smarty_tpl->tpl_vars['x']->value)===null||$tmp==='' ? '' : $tmp);?>
" 
                       class="form-control" placeholder="Wprowadź liczbę">
            </div>
        </div>
        
        <div class="col-md-2">
            <div class="mb-3">
                <label for="id_op" class="form-label">Działanie:</label>
                <select name="op" id="id_op" class="form-select">
                    <option value="plus" <?php if ((($tmp = @$_smarty_tpl->tpl_vars['operation']->value)===null||$tmp==='' ? '' : $tmp) == 'plus') {?>selected<?php }?>>+</option>
                    <option value="minus" <?php if ((($tmp = @$_smarty_tpl->tpl_vars['operation']->value)===null||$tmp==='' ? '' : $tmp) == 'minus') {?>selected<?php }?>>-</option>
                    <option value="times" <?php if ((($tmp = @$_smarty_tpl->tpl_vars['operation']->value)===null||$tmp==='' ? '' : $tmp) == 'times') {?>selected<?php }?>>×</option>
                    <option value="div" <?php if ((($tmp = @$_smarty_tpl->tpl_vars['operation']->value)===null||$tmp==='' ? '' : $tmp) == 'div') {?>selected<?php }?>>÷</option>
                </select>
            </div>
        </div>
        
        <div class="col-md-5">
            <div class="mb-3">
                <label for="id_y" class="form-label">Liczba 2:</label>
                <input id="id_y" type="text" name="y" value="<?php echo (($tmp = @$_smarty_tpl->tpl_vars['y']->value)===null||$tmp==='' ? '' : $tmp);?>
" 
                       class="form-control" placeholder="Wprowadź liczbę">
            </div>
        </div>
    </div>
    
    <div class="text-center mt-4">
        <button type="submit" class="btn btn-primary">Oblicz</button>
    </div>
</form>

<?php if (count($_smarty_tpl->tpl_vars['messages']->value) > 0) {?>
    <div class="error-box">
        <h5>Wystąpiły błędy:</h5>
        <ul class="mb-0">
            <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['messages']->value, 'msg');
$_smarty_tpl->tpl_vars['msg']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['msg']->value) {
$_smarty_tpl->tpl_vars['msg']->do_else = false;
?>
                <li><?php echo $_smarty_tpl->tpl_vars['msg']->value;?>
</li>
            <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
        </ul>
    </div>
<?php }?>

<?php if ((isset($_smarty_tpl->tpl_vars['result']->value))) {?>
    <div class="result-box">
        <h5>Wynik:</h5>
        <p class="h4 mb-0"><?php echo $_smarty_tpl->tpl_vars['result']->value;?>
</p>
    </div>
<?php }
}
}
/* {/block 'content'} */
}

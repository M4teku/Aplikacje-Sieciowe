<?php
/* Smarty version 3.1.47, created on 2025-11-27 13:27:34
  from 'C:\xampp\htdocs\zadanie3_szablonowanie\app\credit.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.47',
  'unifunc' => 'content_692843b69a6920_94249999',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'bcfd76bf2d6957c3295379a210320065d13ffba9' => 
    array (
      0 => 'C:\\xampp\\htdocs\\zadanie3_szablonowanie\\app\\credit.tpl',
      1 => 1764243719,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_692843b69a6920_94249999 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, true);
?>


<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_1053056992692843b6928d33_09902302', 'content');
$_smarty_tpl->inheritance->endChild($_smarty_tpl, "../templates/main.tpl");
}
/* {block 'content'} */
class Block_1053056992692843b6928d33_09902302 extends Smarty_Internal_Block
{
public $subBlocks = array (
  'content' => 
  array (
    0 => 'Block_1053056992692843b6928d33_09902302',
  ),
);
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

<form action="<?php echo $_smarty_tpl->tpl_vars['app_url']->value;?>
/app/credit_calc.php" method="post">
    <div class="row g-3">
        <div class="col-md-4">
            <div class="mb-3">
                <label for="id_amount" class="form-label">Kwota kredytu (zł):</label>
                <input id="id_amount" type="text" name="amount" value="<?php echo (($tmp = @$_smarty_tpl->tpl_vars['amount']->value)===null||$tmp==='' ? '' : $tmp);?>
" 
                       class="form-control" placeholder="np. 100000">
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="mb-3">
                <label for="id_years" class="form-label">Liczba lat:</label>
                <input id="id_years" type="text" name="years" value="<?php echo (($tmp = @$_smarty_tpl->tpl_vars['years']->value)===null||$tmp==='' ? '' : $tmp);?>
" 
                       class="form-control" placeholder="np. 30">
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="mb-3">
                <label for="id_interest" class="form-label">Oprocentowanie (%):</label>
                <input id="id_interest" type="text" name="interest" value="<?php echo (($tmp = @$_smarty_tpl->tpl_vars['interest']->value)===null||$tmp==='' ? '' : $tmp);?>
" 
                       class="form-control" placeholder="np. 4.5">
            </div>
        </div>
    </div>
    
    <div class="text-center mt-4">
        <button type="submit" class="btn btn-primary">Oblicz ratę</button>
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
        <h5>Miesięczna rata:</h5>
        <p class="h4 mb-0"><?php echo sprintf("%.2f",$_smarty_tpl->tpl_vars['result']->value);?>
 zł</p>
    </div>
<?php }
}
}
/* {/block 'content'} */
}

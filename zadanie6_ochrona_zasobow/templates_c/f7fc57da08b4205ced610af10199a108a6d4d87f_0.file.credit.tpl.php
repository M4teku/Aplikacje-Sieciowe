<?php
/* Smarty version 3.1.47, created on 2025-12-04 19:42:30
  from 'C:\xampp\htdocs\zadanie6_ochrona_zasobow\app\views\credit.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.47',
  'unifunc' => 'content_6931d616e37342_36300311',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'f7fc57da08b4205ced610af10199a108a6d4d87f' => 
    array (
      0 => 'C:\\xampp\\htdocs\\zadanie6_ochrona_zasobow\\app\\views\\credit.tpl',
      1 => 1764261218,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_6931d616e37342_36300311 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, true);
?>


<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_15311032566931d616dd0361_73786013', 'content');
$_smarty_tpl->inheritance->endChild($_smarty_tpl, "templates/main.tpl");
}
/* {block 'content'} */
class Block_15311032566931d616dd0361_73786013 extends Smarty_Internal_Block
{
public $subBlocks = array (
  'content' => 
  array (
    0 => 'Block_15311032566931d616dd0361_73786013',
  ),
);
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

<form action="<?php echo $_smarty_tpl->tpl_vars['conf']->value->action_root;?>
creditCompute" method="post">
    <div class="row g-3">
        <div class="col-md-4">
            <div class="mb-3">
                <label for="id_amount" class="form-label">Kwota kredytu (zł):</label>
                <input id="id_amount" type="text" name="amount" value="<?php echo (($tmp = @$_smarty_tpl->tpl_vars['form']->value->amount)===null||$tmp==='' ? '' : $tmp);?>
" 
                       class="form-control" placeholder="np. 100000">
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="mb-3">
                <label for="id_years" class="form-label">Liczba lat:</label>
                <input id="id_years" type="text" name="years" value="<?php echo (($tmp = @$_smarty_tpl->tpl_vars['form']->value->years)===null||$tmp==='' ? '' : $tmp);?>
" 
                       class="form-control" placeholder="np. 30">
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="mb-3">
                <label for="id_interest" class="form-label">Oprocentowanie (%):</label>
                <input id="id_interest" type="text" name="interest" value="<?php echo (($tmp = @$_smarty_tpl->tpl_vars['form']->value->interest)===null||$tmp==='' ? '' : $tmp);?>
" 
                       class="form-control" placeholder="np. 4.5">
            </div>
        </div>
    </div>
    
    <div class="text-center mt-4">
        <button type="submit" class="btn btn-primary">Oblicz ratę</button>
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
        <h5>Miesięczna rata:</h5>
        <p class="h4 mb-0"><?php echo sprintf("%.2f",$_smarty_tpl->tpl_vars['res']->value->result);?>
 zł</p>
    </div>
<?php }
}
}
/* {/block 'content'} */
}

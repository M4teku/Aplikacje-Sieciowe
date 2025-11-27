<?php
/* Smarty version 3.1.47, created on 2025-11-27 14:22:00
  from 'C:\xampp\htdocs\zadanie4_obiektowość\app\login.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.47',
  'unifunc' => 'content_69285078425564_90559605',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '8bf75758c8db999521379fdfdf19439ff594668b' => 
    array (
      0 => 'C:\\xampp\\htdocs\\zadanie4_obiektowość\\app\\login.tpl',
      1 => 1764246643,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_69285078425564_90559605 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, true);
?>


<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_8767802826928507827dd13_81290962', 'content');
$_smarty_tpl->inheritance->endChild($_smarty_tpl, "../templates/main.tpl");
}
/* {block 'content'} */
class Block_8767802826928507827dd13_81290962 extends Smarty_Internal_Block
{
public $subBlocks = array (
  'content' => 
  array (
    0 => 'Block_8767802826928507827dd13_81290962',
  ),
);
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

<form action="<?php echo $_smarty_tpl->tpl_vars['app_url']->value;?>
/app/security/login.php" method="post">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="mb-3">
                <label for="id_login" class="form-label">Login:</label>
                <input id="id_login" type="text" name="login" value="<?php echo (($tmp = @$_smarty_tpl->tpl_vars['form']->value['login'])===null||$tmp==='' ? '' : $tmp);?>
" 
                       class="form-control" placeholder="Wprowadź login">
            </div>
            
            <div class="mb-3">
                <label for="id_pass" class="form-label">Hasło:</label>
                <input id="id_pass" type="password" name="pass" class="form-control" placeholder="Wprowadź hasło">
            </div>
            
            <div class="text-center mt-4">
                <button type="submit" class="btn btn-primary">Zaloguj</button>
            </div>
        </div>
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
<?php }
}
}
/* {/block 'content'} */
}

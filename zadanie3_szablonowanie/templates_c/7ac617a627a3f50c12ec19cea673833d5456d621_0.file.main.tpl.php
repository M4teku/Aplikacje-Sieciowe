<?php
/* Smarty version 3.1.47, created on 2025-11-27 14:21:43
  from 'C:\xampp\htdocs\zadanie3_szablonowanie\templates\main.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.47',
  'unifunc' => 'content_69285067e06411_78990870',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '7ac617a627a3f50c12ec19cea673833d5456d621' => 
    array (
      0 => 'C:\\xampp\\htdocs\\zadanie3_szablonowanie\\templates\\main.tpl',
      1 => 1764247909,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_69285067e06411_78990870 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, false);
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo (($tmp = @$_smarty_tpl->tpl_vars['page_title']->value)===null||$tmp==='' ? "Kalkulator" : $tmp);?>
</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #764ba2; /* Fiolet bez gradientu */
            min-height: 100vh;
        }
        .calculator-card {
            background: white;
            border-radius: 10px;
            padding: 2rem;
            margin-top: 2rem;
        }
        .result-box {
            background: #d4edda;
            padding: 1rem;
            border-radius: 5px;
            margin-top: 1rem;
        }
        .error-box {
            background: #f8d7da;
            padding: 1rem;
            border-radius: 5px;
            margin-top: 1rem;
        }
        .nav-custom {
            background: rgba(255,255,255,0.1);
            backdrop-filter: blur(10px);
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark nav-custom">
        <div class="container">
            <a class="navbar-brand fw-bold" href="<?php echo $_smarty_tpl->tpl_vars['app_url']->value;?>
/app/calc.php">
                <i class="fas fa-calculator me-2"></i>Kalkulatory
            </a>
            <div class="navbar-nav ms-auto">
                <a class="nav-link <?php if ((isset($_smarty_tpl->tpl_vars['current_page']->value)) && $_smarty_tpl->tpl_vars['current_page']->value == 'simple') {?>active<?php }?>" href="<?php echo $_smarty_tpl->tpl_vars['app_url']->value;?>
/app/calc.php">
                    <i class="fas fa-calculator me-1"></i>Prosty
                </a>
                <a class="nav-link <?php if ((isset($_smarty_tpl->tpl_vars['current_page']->value)) && $_smarty_tpl->tpl_vars['current_page']->value == 'credit') {?>active<?php }?>" href="<?php echo $_smarty_tpl->tpl_vars['app_url']->value;?>
/app/credit_calc.php">
                    <i class="fas fa-home me-1"></i>Kredytowy
                </a>
                <?php if (!(isset($_smarty_tpl->tpl_vars['show_logout']->value)) || $_smarty_tpl->tpl_vars['show_logout']->value != false) {?>
                <a class="nav-link" href="<?php echo $_smarty_tpl->tpl_vars['app_url']->value;?>
/app/security/logout.php">
                    <i class="fas fa-sign-out-alt me-1"></i>Wyloguj (<?php echo (($tmp = @$_smarty_tpl->tpl_vars['user']->value)===null||$tmp==='' ? "Gość" : $tmp);?>
)
                </a>
                <?php }?>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-10">
                <div class="calculator-card">
                    <h2 class="text-center mb-4 text-primary">
                        <i class="fas fa-calculator me-2"></i><?php echo (($tmp = @$_smarty_tpl->tpl_vars['page_title']->value)===null||$tmp==='' ? "Kalkulator" : $tmp);?>

                    </h2>
                    <?php if ((isset($_smarty_tpl->tpl_vars['page_description']->value))) {?>
                    <p class="text-center text-muted"><?php echo $_smarty_tpl->tpl_vars['page_description']->value;?>
</p>
                    <?php }?>

                    <?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_99991720369285067e058f0_09440412', 'content');
?>

                </div>
            </div>
        </div>
    </div>

    <?php echo '<script'; ?>
 src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"><?php echo '</script'; ?>
>
</body>
</html><?php }
/* {block 'content'} */
class Block_99991720369285067e058f0_09440412 extends Smarty_Internal_Block
{
public $subBlocks = array (
  'content' => 
  array (
    0 => 'Block_99991720369285067e058f0_09440412',
  ),
);
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
}
}
/* {/block 'content'} */
}

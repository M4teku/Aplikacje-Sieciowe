{extends file="templates/main.tpl"}

{block name=content}
<form action="{$conf->action_root}calcCompute" method="post">
    <div class="row g-3">
        <div class="col-md-5">
            <div class="mb-3">
                <label for="id_x" class="form-label">Liczba 1:</label>
                <input id="id_x" type="text" name="x" value="{$form->x|default:''}" 
                       class="form-control" placeholder="Wprowadź liczbę">
            </div>
        </div>
        
        <div class="col-md-2">
            <div class="mb-3">
                <label for="id_op" class="form-label">Działanie:</label>
                <select name="op" id="id_op" class="form-select">
                    <option value="plus" {if $form->op|default:'' == 'plus'}selected{/if}>+</option>
                    <option value="minus" {if $form->op|default:'' == 'minus'}selected{/if}>-</option>
                    <option value="times" {if $form->op|default:'' == 'times'}selected{/if}>×</option>
                    <option value="div" {if $form->op|default:'' == 'div'}selected{/if}>÷</option>
                </select>
            </div>
        </div>
        
        <div class="col-md-5">
            <div class="mb-3">
                <label for="id_y" class="form-label">Liczba 2:</label>
                <input id="id_y" type="text" name="y" value="{$form->y|default:''}" 
                       class="form-control" placeholder="Wprowadź liczbę">
            </div>
        </div>
    </div>
    
    <div class="text-center mt-4">
        <button type="submit" class="btn btn-primary">Oblicz</button>
    </div>
</form>

{* Wyświetlenie listy błędów, jeśli istnieją *}
{if $msgs->isError()}
    <div class="error-box">
        <h5>Wystąpiły błędy:</h5>
        <ul class="mb-0">
            {foreach $msgs->getErrors() as $err}
                <li>{$err}</li>
            {/foreach}
        </ul>
    </div>
{/if}

{* Wyświetlenie listy informacji, jeśli istnieją *}
{if $msgs->isInfo()}
    <div class="inf-box" style="background: #d1ecf1; padding: 1rem; border-radius: 5px; margin-top: 1rem;">
        <h5>Informacje:</h5>
        <ul class="mb-0">
            {foreach $msgs->getInfos() as $inf}
                <li>{$inf}</li>
            {/foreach}
        </ul>
    </div>
{/if}

{if isset($res->result)}
    <div class="result-box">
        <h5>Wynik:</h5>
        <p class="h4 mb-0">{$form->x|default:0} {$res->op_name} {$form->y|default:0} = {$res->result}</p>
    </div>
{/if}
{/block}
{extends file="main.tpl"}

{block name=content}
<form action="{$app_url}/app/calc.php" method="post">
    <div class="row g-3">
        <div class="col-md-5">
            <div class="mb-3">
                <label for="id_x" class="form-label">Liczba 1:</label>
                <input id="id_x" type="text" name="x" value="{$x|default:''}" 
                       class="form-control" placeholder="Wprowadź liczbę">
            </div>
        </div>
        
        <div class="col-md-2">
            <div class="mb-3">
                <label for="id_op" class="form-label">Działanie:</label>
                <select name="op" id="id_op" class="form-select">
                    <option value="plus" {if $operation|default:'' == 'plus'}selected{/if}>+</option>
                    <option value="minus" {if $operation|default:'' == 'minus'}selected{/if}>-</option>
                    <option value="times" {if $operation|default:'' == 'times'}selected{/if}>×</option>
                    <option value="div" {if $operation|default:'' == 'div'}selected{/if}>÷</option>
                </select>
            </div>
        </div>
        
        <div class="col-md-5">
            <div class="mb-3">
                <label for="id_y" class="form-label">Liczba 2:</label>
                <input id="id_y" type="text" name="y" value="{$y|default:''}" 
                       class="form-control" placeholder="Wprowadź liczbę">
            </div>
        </div>
    </div>
    
    <div class="text-center mt-4">
        <button type="submit" class="btn btn-primary">Oblicz</button>
    </div>
</form>

{if count($messages) > 0}
    <div class="error-box">
        <h5>Wystąpiły błędy:</h5>
        <ul class="mb-0">
            {foreach $messages as $msg}
                <li>{$msg}</li>
            {/foreach}
        </ul>
    </div>
{/if}

{if isset($result)}
    <div class="result-box">
        <h5>Wynik:</h5>
        <p class="h4 mb-0">{$result}</p>
    </div>
{/if}
{/block}
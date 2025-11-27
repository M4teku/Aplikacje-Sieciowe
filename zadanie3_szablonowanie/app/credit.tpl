{extends file="../templates/main.tpl"}

{block name=content}
<form action="{$app_url}/app/credit_calc.php" method="post">
    <div class="row g-3">
        <div class="col-md-4">
            <div class="mb-3">
                <label for="id_amount" class="form-label">Kwota kredytu (zł):</label>
                <input id="id_amount" type="text" name="amount" value="{$amount|default:''}" 
                       class="form-control" placeholder="np. 100000">
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="mb-3">
                <label for="id_years" class="form-label">Liczba lat:</label>
                <input id="id_years" type="text" name="years" value="{$years|default:''}" 
                       class="form-control" placeholder="np. 30">
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="mb-3">
                <label for="id_interest" class="form-label">Oprocentowanie (%):</label>
                <input id="id_interest" type="text" name="interest" value="{$interest|default:''}" 
                       class="form-control" placeholder="np. 4.5">
            </div>
        </div>
    </div>
    
    <div class="text-center mt-4">
        <button type="submit" class="btn btn-primary">Oblicz ratę</button>
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
        <h5>Miesięczna rata:</h5>
        <p class="h4 mb-0">{$result|string_format:"%.2f"} zł</p>
    </div>
{/if}
{/block}
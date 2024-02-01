<script>
$( document ).ready(function() {    
    var lootTable  = $('#lootTableBody');
    var lootRow = $('#lootRow').find('.loot-row');
    var itemSelect = $('#lootRowData').find('.item-select');
    var currencySelect = $('#lootRowData').find('.currency-select');
    var petSelect = $('#lootRowData').find('.pet-select');
    var awardSelect = $('#lootRowData').find('.award-select');
    var recipeSelect = $('#lootRowData').find('.recipe-select');
    var raffleSelect = $('#lootRowData').find('.raffle-select');

    $('#lootTableBody .selectize').selectize();

    $('.reward-type').on('change', function(e) {
        var val = $(this).val();
        var cell = $(this).parent().parent().find('.loot-row-select');
        var clone = null;
        if(val == 'Item') clone = itemSelect.clone();
        else if (val == 'Currency') clone = currencySelect.clone();
        else if (val == 'Pet') clone = petSelect.clone();
        else if (val == 'Award') clone = awardSelect.clone();
        else if (val == 'Recipe') clone = recipeSelect.clone();
        else if (val == 'Raffle') clone = raffleSelect.clone();
        console.log("REWARD CHANGED")
        cell.html('');
        cell.append(clone);
    });

});
    
</script>
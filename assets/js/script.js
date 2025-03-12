var isSelected = false;

function toggleSelect() {

    if (isSelected == false) {

        $('.form-check-value').each(function(){
            var c = $(this).attr("class");
            $("."+c).attr("checked",true);
        })

        isSelected = true;

        $('#selectButton').find('i'   ).removeClass('fa-square-check').addClass('fa-square-minus');
        $('#selectButton').find('span').text('Deselecionar Todos');

    }

    else {

        $('.form-check-value').each(function(){
            var c = $(this).attr("class");
            $("."+c).attr("checked",false);
        })

        isSelected = false;

        $('#selectButton').find('i'   ).removeClass('fa-square-minus').addClass('fa-square-check');
        $('#selectButton').find('span').text('Selecionar Todos');

    }

}

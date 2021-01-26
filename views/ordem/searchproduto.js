function getValores() {
    var x = document.getElementById("saidaqte_p");
    var y = document.getElementById("valor_un_c");
    var p = document.getElementById("produtoid");
    var dados = $.getJSON("../../back/response/compra/requestajax/searchreqprod.php?produtoid="+p.value, function (dados) {
        console.log("success");
        $.each(dados, function(i, obj){
            y.value = obj.valor_un_e;
        })
    })
        .done(function () {
            console.log("second success");
        })
        .fail(function () {
            console.log("error");
        })
        .always(function () {
            console.log("complete");
        });


}
function getValores() {
    var y = document.getElementById("valor_un_c");
    var p = document.getElementById("selectprodid");
    var dados = $.getJSON("../../back/response/compra/requestajax/searchreqprod.php?produtoid=" + p.value, function (dados) {
        console.log("success");
        $.each(dados, function (i, obj) {
            y.value = obj.valor_un_e;
        })
    })
        .done(function () {
            console.log("reinaldo");
        })
        .fail(function () {
            console.log("error");
        })
        .always(function () {
            console.log("complete");
        });
}
function getInEstoque() {
    var y = document.getElementById("produtoid");
    var p = document.getElementById("estoque");
    var dados = $.getJSON("../../back/response/compra/requestajax/searchreqprod.php?produtoid=" + y.value, function (dados) {
        console.log("success");
        $.each(dados, function (i, obj) {
            p.value = obj.quantidade_e;
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
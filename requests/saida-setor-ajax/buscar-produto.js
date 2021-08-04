function getInEstoque() {
    var y = document.getElementById("produtoid");
    var p = document.getElementById("estoque");


    var dados = $.getJSON("../../back/model/ordem-compra/request-ajax-response/buscar-produto.php?produtoid=" + y.value, function (dados) {
        console.log("success");
        $.each(dados, function (i, obj) {
            p.value = obj.quantidade_e;
            document.getElementById('qtdesolicitada').removeAttribute('disabled');
            /*if(parseInt(obj.quantidade_e) <= parseInt(obj.estoque_minimo_e)){
                p.classList.add('bg-red')
                Swal.fire(
                    'Atenção!',
                    'O produto selecionado encontra-se no ponto de compra, por favor informe o setor responsável.',
                    'info'
                )
            }else{
                p.classList.remove('bg-red')
            }*/
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
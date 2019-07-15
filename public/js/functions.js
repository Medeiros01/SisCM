


/**
* Funções para formulaário cadastro de íten
*/

 
/**
* 
* Funções para gerenciar filtros de listagem de férias
* 
*/


jQuery(function($){
    $("#st_telefoneresidencial").mask("(99) 9999-9999");
    $("#st_telefonecelular").mask("(99) 99999-9999");
    $("#st_cep").mask("99999-999");
    $("#st_cpf").mask("999.999.999-99");
 });
 $(function() {
    $('[type=money]').maskMoney({
      thousands: '.',
      decimal: ','
    });
  })
  function consultaprodutos(id){
      var id = id;
      var url = '../../buscaprodutosparaadicionarcompra/'+id
     var dadosForm = $('#buscaprodutocompra').serialize();
   
      jQuery.ajax({
        //Enviando via ajax
        url:  url,
        data: dadosForm,
        method: 'POST',
        //Verificando se cadastrou
    }).done(function(data){
        if(data == 0){
            alert('Produto não encontrado para o fonecedor desta compra!')
        }else{

            $("#tabelabuscaproduto").append("<tr><td>"+data.st_nome+"</td></tr>") 
            $("#st_codigo").val(data.st_codigo); 
            $("#st_nome").val(data.st_nome); 
            $("#st_descricao").val(data.st_descricao); 
           
        }
      
    }).fail(function(){
        alert('falha a enviar dados');
        
    })
    return false;

     /*  var dadosform  = $("#buscaprodutocompra").serialize(); */
     
   
  }
  function consultaprodutosparavenda(id){
      var id = id;
      var url = '../../buscaprodutosparaadicionarnavenda/'+id
     var dadosForm = $('#buscaprodutovenda').serialize();
   
      jQuery.ajax({
        //Enviando via ajax
        url:  url,
        data: dadosForm,
        method: 'POST',
        //Verificando se cadastrou
    }).done(function(data){
        if(data == 0){
            alert('Produto não encontrado para o fonecedor desta compra!')
        }else{

            $("#tabelabuscaproduto").append("<tr><td>"+data.st_nome+"</td></tr>") 
            $("#st_codigo").val(data.st_codigo); 
            $("#st_nome").val(data.st_nome); 
            $("#st_descricao").val(data.st_descricao); 
           
        }
      
    }).fail(function(){
        alert('falha a enviar dados');
        
    })
    return false;

     /*  var dadosform  = $("#buscaprodutocompra").serialize(); */
     
   
  }

/**
 * 
 */

function liberaedicaoprodutovenda(id){
    $('#'+id).show()
    $('.'+id).show()
    $('#save'+id).show()
    $('#edita'+id).hide()
   
};
function salvaedicaoprodutovenda(id){
   
        $("#form_edita_produto_venda_"+id).attr("action","../../venda/editaprodutovenda/"+id);
        $("#form_edita_produto_venda_"+id).submit();

}


 //$('#reservation').daterangepicker();
 /* $(function() {
    //$( "#datetimepicker" ).datepicker();
    $('#periodo').daterangepicker();
  });

 $(function() {
    $( "#dt_inicio" ).datepicker();
  });

 $(function() {
    $( "#dt_final" ).datepicker();
  }); */

 // ao alterar o campo altera status do servidor na hora do cadastro da Cr, exibe o campo
 // status para selecionar o proximo status
 function alterarstatusservidor(){
    var valor = $('#st_alterastatus').val();
    if(valor == 'Sim'){
        $('#status').show()
        $("#st_status").removeAttr("disabled");
        $("#st_status").attr("required", true);
      
    }else{
        $('#status').hide()
        //$("#st_status").attr("disabled");
        $('#st_status').prop('disabled', true);
        $("#st_status").attr("required", false);
        $("#st_status").val(null);
    }

     
};
     




function selectFilterFuncionarios(){
    var valor = $("#filterlist").val();
    if(valor == 'ce_setor'){
        document.getElementById("divSetorFilter").style.display = "block";
        $("#st_sigla").removeAttr("disabled");
    }
    else{
        document.getElementById("divSetorFilter").style.display = "none";
        $("#st_sigla").attr("disabled", "true");
    }
    if(valor == 'ce_orgao'){
        document.getElementById("divOrgaoFilter").style.display = "block";
        $("#st_orgao").removeAttr("disabled");
    }
    else{
        document.getElementById("divOrgaoFilter").style.display = "none";
        $("#st_orgao").attr("disabled", "true");
    }
};
//Função para Habilitar os formulário de edição de outras entradas. Acionada
//ao Clicar no botão editar da tela detalhecaixa
function habilitaform(id){
  
        $("."+id).show();
        $("#salvar").show();
        $("#editar").hide();
};
//Função para submeter o formulário de edição de entrada de outros valores
function submitform(id){
    var form = $('form[id="'+id+'"]');
      form.submit();  
       
};


$( "#st_campo" ).change(function() {
    var valorcampo = $('#st_campo').val();
    if(valorcampo == 'dt_periodo'){

        $('.fornecedor').hide();
        $('.valor').hide();
        $('.periodo').show();
       // $('#dt_compra_inicio"').prop("disabled", false)
       // $('#dt_compra_fim"').prop("disabled", false)
        $('#st_valor').prop("disabled", true)
        $('#ce_fornecedor').prop("disabled", true)
        
    }else if(valorcampo == 'ce_fornecedor'){
        
        $('.fornecedor').show();
        $('.valor').hide();
        $('.periodo').hide();
        $('#dt_compra_inicio"').prop("disabled", true);
        $('#dt_compra_fim"').prop("disabled", true);
        $('#st_valor').prop("disabled", false);
       
        $('#ce_fornecedor').prop("disabled", false);
    }else{
        $('.fornecedor').hide();
        $('.valor').show();
        $('.periodo').hide();
       // $('#dt_compra_inicio"').prop("disabled", true)
       // $('#dt_compra_fim"').prop("disabled", true)
        $('#st_valor').prop("disabled", false)
        $('#ce_fornecedor').prop("disabled", true)

    }
  });
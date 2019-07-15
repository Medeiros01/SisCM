@extends('adminlte::page')

@section('title', 'compras')

@section('content')
    <div class="content">
            <div class="row">
                @if(isset($Msg))                        
                    <div class="col-md-12 alert alert-danger" role="alert">
                        {{$Msg}}
                    </div>
                @endif
             

               {{--  Começa a exibição do compras --}}
        
                <div class="col-md-12">
                    <table class=" table table-bordered table-hover">
                        <thead>
                            @if($compra->bo_atualizouestoque != 1)
                                <tr class="bg-primary">
                                    <th colspan="2">DETALHES DA COMPRA</th>
                                    <th colspan="2">
                                        
                                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalExemplo">
                                                    Adicionar Produto a compra
                                            </button>
                                            <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#AtualizaEstoque">
                                                   Finalizar Compra e Atualizar Estoque
                                            </button>
                                    </th>
                                </tr>
                            @else
                                <tr class="bg-primary">
                                    <th colspan="4">DETALHES DA COMPRA</th>
                                </tr>
                            @endif
                            <tr>
                                <th >Nata Fiscal</th>
                                <th >Data da Compra</th>
                                <th >Fornecedor</th>
                                <th >Valor da compra</th>
                                
                            </tr>
                        </thead>
                        <tbody>
                            @if(isset($compra) && !empty($compra))
                            <tr style="font-size:12px" >
                                <th>{{$compra->st_notafiscal}}</th>
                                <th>{{date('d/m/Y', strtotime($compra->dt_compra))}}</th>
                                <th>{{$compra->st_nome_fornecedor}}</th>
                                <th>{{str_replace(".",",", $compra->st_valor_compra)}}</th>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                   

                    @if(isset($produtoscomprados) && count($produtoscomprados)> 0)
                        <table class=" table table-bordered table-hover">
                            <thead>
                                <tr class="bg-primary">
                                    <th colspan="6">PRODUTOS DA COMPRA</th>
                                    
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th>CÓDIGO</th>
                                    <th>NOME</th>
                                    <th>QUANTIDADE</th>
                                    <th>VALOR DE CUSTO</th>
                                    <th>VALOR DE VENDA</th>
                                    @if($compra->bo_atualizouestoque != 1)
                                    <th>AÇÃO</th>
                                    @endif
                                </tr>
                                @foreach($produtoscomprados as $p)
                                <tr>
                                    <th>{{$p->st_codigo}}</th>
                                    <th>{{$p->st_nome}}</th>
                                    <th>{{$p->nu_quantidade}}</th>
                                    <th>{{str_replace(".",",",$p->st_preco_custo)}}</th>
                                    <th>{{str_replace(".",",",$p->st_preco_venda)}}</th>
                                    @if($compra->bo_atualizouestoque != 1)
                                    <th><a href="{{url('datalhe/remove/'.$p->id)}}" title="Remover"> <i class="fa fa-pencil"></i> Remover</a></th>
                                    @endif
                                </tr>
                                @endforeach
                            </tbody>
                        <table>
                    @endif
                </div>
            </div>
    </div>




    <!-- Adicionar produto -->
<div class="modal fade" id="modalExemplo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">ADICIONAR PRODUTO</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-header">
                <form id="buscaprodutocompra" class="form-inline pull-left"  role="form" method="POST" >
                    {{csrf_field()}}
                    <div class="input-group">
                            <input type="text" required="required" name="st_produto" id="st_produto" class="form-control" placeholder="NOME OU CÓDIGO DO PRODUTO">
                            <span class="input-group-btn">
                                <div onclick="consultaprodutos({{$compra->id}})" id="search-btn" class="btn btn-primary">
                                    <i class="fa fa-search">Buscar</i>
                                </div>
                            </span>
                    </div>
                </form>
            </div>

            <div class="modal-body">
                   

                        <form class="form-inline" role="form"  method="post" action="{{ url('/compra/addproduto/'.$compra->id) }}">
                            {{ csrf_field() }}
                                <div class="col-md-6 form-inline{{ $errors->has('st_codigo') ? ' has-error' : '' }}">
                                        <label for="st_codigo" class="control-label"> Código do Produto</label>
                                        <div>
                                            <input id="st_codigo" type="text" required="required" class="form-control-required"  name="st_codigo">
                                        </div>
                                </div>
                                <div class="col-md-6 form-inline{{ $errors->has('st_nome') ? ' has-error' : '' }}">
                                        <label for="st_nome" class="control-label"> Nome</label>
                
                                        <div>
                                            <input id="st_nome" type="text" required="required" class="form-control-required" name="st_nome">
                
                                        </div>
                                </div>
                                <div class="col-md-12 form-inline{{ $errors->has('st_descricao') ? ' has-error' : '' }}">
                                        <label for="st_descricao" class="control-label"> Descrição</label>
                
                                        <div>
                                            <input id="st_descricao" type="text" required="required" class="form-control-required" name="st_descricao">
                
                                        </div>
                                </div>
                                <div class="col-md-6 form-inline{{ $errors->has('st_nome_fornecedor') ? ' has-error' : '' }}">
                                        <label for="st_nome_fornecedor" class="control-label"> Fornnecedor</label>
                
                                        <div>
                                            <input id="st_nome_fornecedor" type="text" class="form-control-required" name="st_nome_fornecedor">
                
                                        </div>
                                </div>
                                <div class="col-md-6 form-inline{{ $errors->has('nu_quantidade') ? ' has-error' : '' }}">
                                        <label for="nu_quantidade" class="control-label"> Quantidade</label>
                
                                        <div>
                                            <input id="nu_quantidade" type="text" required="required" class="form-control-required" placeholder="Informe a Quantidade" name="nu_quantidade" >
                
                                        </div>
                                </div>
                                <div class="col-md-6 form-inline{{ $errors->has('st_preco_custo') ? ' has-error' : '' }}">
                                        <label for="st_preco_custo" class="control-label"> VALOR DE CUSTO</label>
                                        <div>
                                            <input id="st_preco_custo" type="money" required="required" class="form-control-required" placeholder="valor de custo da unidade" name="st_preco_custo">
                                        </div>
                                </div>
                                <div class="col-md-6 form-inline{{ $errors->has('st_preco_venda') ? ' has-error' : '' }}">
                                        <label for="st_preco_venda" class="control-label"> VALOR DE VENDA</label>
                
                                        <div>
                                            <input id="st_preco_venda" type="money" required="required" class="form-control-required" placeholder="Informe preço de venda" name="st_preco_venda">
                                        </div>
                                </div>
                                
                                
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                                    <button type="submit"  class="btn btn-primary">Salvar mudanças</button>
                                </div>
                        </form>
            </div>
          </div>
        </div>
</div>
 
    <!-- Atualiza Estoque -->
<div class="modal fade" id="AtualizaEstoque" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Atualizar Estoque</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>


            <div class="modal-body">
                   
                    Após Finalizar a compra não será mais possível adicionar produtos a esta nota. Deseja Continuar?              
                    <form class="form-inline" role="form"  method="post" action="{{ url('/compra/concluir_compra/'.$compra->id) }}">
                        {{ csrf_field() }}
                           
                        <input id="id_compra" type="hidden" name="id_compra">
                                  
                            
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                            <button type="submit"  class="btn btn-primary">Concluir Compra</button>
                        </div>
                    </form
            </div>
          </div>
        </div>
</div>
 
@stop
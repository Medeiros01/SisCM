@extends('adminlte::page')
@php 
$total= 0;
$ordem = 0;
@endphp
@section('title', 'Detalhamento')

@section('content')
    <div class="content">
            <div class="row">
                @if(isset($Msg))                        
                    <div class="col-md-12 alert alert-danger" role="alert">
                        {{$Msg}}
                    </div>
                @endif
             

               {{--  Começa a exibição do vendas --}}
        
                <div class="col-md-12">
                    <table class=" table table-bordered table-hover">
                        <thead>
                            @if($venda->st_status != 'Fechado' && $venda->st_status != 'Cancelado')
                                <tr class="bg-primary">
                                    <th colspan="8">
                                        
                                        @if($venda->st_status == 'Aberto')
                                            <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#modalExemplo">
                                                    Adicionar Produto 
                                            </button>
                                        @endif
                                        @if($venda->st_tipo == 'Orçamento')
                                            <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#converte_orcamento_venda">
                                                   Converter em venda
                                            </button>
                                            <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#concluir">
                                                    Concluir Orçamento
                                            </button>
                                            
                                            <a href="{{url('imprimir/venda/'.$venda->id)}}" title="Imprimir" class="btn btn-primary lg"> <i class="fa fa-print"> IMPRMIMIR</i> </a>
                                        @elseif($venda->st_tipo == 'Venda')
                                            @if($venda->st_status == 'Aberto')
                                                <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#concluir">
                                                        Concluir venda 
                                                </button>
                                                <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#cancelamento">
                                                        Cancelar venda 
                                                </button>
                                            @elseif($venda->st_status == 'Concluído')
                                                <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#reabrir_venda">
                                                        Reabrir Venda 
                                                </button>
                                                <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#fechar">
                                                    Fechar Venda
                                                </button>
                                                <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#cancelamento">
                                                    Cancelar venda 
                                                </button>
                                            @endif
                                        <a href="{{url('imprimir/venda/'.$venda->id)}}" title="Imprimir" class="btn btn-primary lg"> <i class="fa fa-print"> IMPRMIMIR</i> </a>
                                        @endif

                                    </th>
                                </tr>
                            @else
                                <tr >
                                    <th colspan="7" class="bg-primary">
                                    </th>
                                    <th colspan="1" class="bg-primary">
                                        <a href="{{url('imprimir/venda/'.$venda->id)}}" title="Imprimir" class="btn btn-primary lg"> <i class="fa fa-print"> IMPRMIMIR</i> </a> 
                                    </th>
                                </tr>
                            @endif
                            <tr>
                                <th >Tipo</th>
                                <th >Data</th>
                                <th >Código</th>
                                <th >Vendedor</th>
                                <th >Cliente</th>
                                <th >Situação</th>
                                <th >Valor</th>
                                <th >Tipo Pagamento</th>
                               
                                
                            </tr>
                        </thead>
                        <tbody>
                            @if(isset($venda) && !empty($venda))
                            <tr style="font-size:12px" >
                                <th class="btn btn-primary btn-block">{{strtoupper($venda->st_tipo)}}</th>
                                <th>{{date('d/m/Y', strtotime($venda->dt_venda))}}</th>
                                <th>{{$venda->nu_codigo}}{{date('dmY', strtotime($venda->dt_cadastro))}}</th>
                                <th>{{$venda->st_nome_vendedor}}</th>
                                <th>{{$venda->st_nome_cliente}}</th>
                                @if($venda->st_status =='Cancelado')
                                <th class="bg-danger">{{$venda->st_status}}</th>
                                @else
                                <th >{{$venda->st_status}}</th>
                                @endif
                                <th>R$ {{str_replace(".",",",$venda->st_valor)}}</th>
                                <th >{{$venda->st_forma_pagamento}}</th>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                   

                    @if(isset($produtosvendidos) && count($produtosvendidos)> 0)
                        <table class=" table table-bordered table-hover">
                            <thead>
                                <tr class="bg-primary">
                                    <th colspan="8">Descrição</th>
                                    
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th>Ord</th>
                                    <th>Código</th>
                                    <th>Produto</th>
                                    <th>Valor Unidade</th>
                                    <th>Qtd</th>
                                    <th>Desconto</th>
                                    <th>Valor Total</th>
                                    @if($venda->st_status == 'Aberto')
                                    <th>AÇÃO</th>
                                    @endif
                                </tr>
                                
                                @foreach($produtosvendidos as $p)
                                @php $ordem = $ordem+1;@endphp
                                <tr>
                                <form method="post" id="form_edita_produto_venda_{{$p->id}}" >
                                                    {{csrf_field()}}
                                        <th>{{$ordem}}</th>
                                        <th>{{$p->st_codigo}}</th>
                                        <th>{{$p->st_descricao}}</th>
                                        <th>{{str_replace(".",",",$p->st_preco_venda)}}</th>
                                        <th>{{$p->nu_quantidade}}
                                            <div id="{{$p->id}}" style="display: none">
                                                <input type="text"  name="nu_quantidade" value="{{$p->nu_quantidade}}">
                                            </div>
                                        </th>
                                        <th>{{str_replace(".",",",($p->st_desconto))}}
                                            <div class="{{$p->id}}" style="display: none">
                                                <input type="money"  name="st_desconto" value="{{$p->st_desconto}}">
                                            </div>
                                        </th>
                                        <th>{{str_replace(".",",",($p->nu_quantidade * $p->st_preco_venda)-$p->st_desconto) }}</th>
                                        @if($venda->st_status == 'Aberto')
                                            <th>
                                                <a href="{{url('detalhevenda/remove/'.$p->id)}}" title="Remover" class="btn btn-danger"> <i class="fa fa-close"></i> </a> | 
                                                <div onclick="liberaedicaoprodutovenda({{$p->id}})" title="Editar" class="btn btn-primary" id="edita{{$p->id}}">
                                                    <i class="fa fa-pencil"></i>
                                            </div>
                                            <div style="display: none" onclick="salvaedicaoprodutovenda({{$p->id}})" class="btn btn-primary" id="save{{$p->id}}">
                                                <button title="Salvar"><i class="fa fa-save"></i></button>
                                                </div>
                                            </th>
                                        @endif
                                    </form>
                                </tr>
                               @php $total = $total +($p->nu_quantidade * $p->st_preco_venda) -$p->st_desconto; @endphp
                             
                               @endforeach
                                <tr style="background-color: grey;">
                                    <td colspan="7" style="text-align: right">TOTAL</td>
                                    <td colspan="1">{{str_replace(".",",",$total)}}</td>
                                </tr>
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
                <form id="buscaprodutovenda" class="form-inline pull-left"  role="form" method="POST" >
                    {{csrf_field()}}
                    <div class="input-group">
                            <input type="text" required="required" name="st_produto" id="st_produto" class="form-control" placeholder="CÓDIGO DO PRODUTO">
                            <span class="input-group-btn">
                                <div onclick="consultaprodutosparavenda({{$venda->id}})" id="search-btn" class="btn btn-primary">
                                    <i class="fa fa-search">Buscar</i>
                                </div>
                            </span>
                    </div>
                </form>
            </div>

            <div class="modal-body">
                   

                        <form class="form-inline" role="form"  method="post" action="{{ url('/venda/addproduto/'.$venda->id) }}">
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
                                <div class="col-md-6 form-inline{{ $errors->has('nu_quantidade') ? ' has-error' : '' }}">
                                        <label for="nu_quantidade" class="control-label"> Quantidade</label>
                
                                        <div>
                                            <input id="nu_quantidade" type="text" required="required" class="form-control-required" placeholder="Informe a Quantidade" name="nu_quantidade" >
                
                                        </div>
                                </div>
                                
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                                    <button type="submit"  class="btn btn-primary">Adicionar</button>
                                </div>
                        </form>
            </div>
          </div>
        </div>
</div> 
    <!-- Modal converter Orçamento em venda -->
 <div class="modal fade" id="converte_orcamento_venda" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="converte_orcamento_venda">TRANSFORMAR ORÇAMENTO EM VENDA</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-header">
                Deseja Realmente transformar este Orçamento em Venda?
            </div>

            <div class="modal-body">
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                <a href="{{ url('/venda/converte_orcamento_venda/'.$venda->id) }}"  class="btn btn-primary">Sim</a>
                </div>  
            </div>
          </div>
        </div>
</div> 

 
    <!-- Finalizar Venda/Orçamento -->
<div class="modal fade" id="concluir" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Concluir {{$venda->st_tipo}} </h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>


            <div class="modal-body">
                   
                    Após Concluir 
                    @if($venda->st_tipo == 'Venda')a venda
                    @elseif($venda->st_tipo == 'Orçamento')o orçamento
                    @endif
                     Não será mais possível adiconar produtos. Deseja Continuar?              
                    <form class="form-inline" role="form"  method="post" action="{{ url('/venda/concluir_venda/'.$venda->id) }}">
                        {{ csrf_field() }}
                           
                        <input id="id_venda" type="hidden" name="id_venda">
                                  
                            
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                            <button type="submit"  class="btn btn-primary">Concluir venda</button>
                        </div>
                    </form>
            </div>
          </div>
        </div>
</div>
<div class="modal fade" id="reabrir_venda" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Reabrir {{$venda->st_tipo}} </h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>


            <div class="modal-body">
                   
                   Deseja realmente reabrir
                    @if($venda->st_tipo == 'Venda')a venda
                    @elseif($venda->st_tipo == 'Orçamento')o orçamento
                    @endif
                     para Edição?
                    <form class="form-inline" role="form"  method="post" action="{{ url('/venda/reabrir_venda/'.$venda->id) }}">
                        {{ csrf_field() }}
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                            <button type="submit"  class="btn btn-primary">Reabrir venda</button>
                        </div>
                    </form>
            </div>
          </div>
        </div>
</div>
    <!-- Fechar Venda/Orçamento -->
<div class="modal fade" id="fechar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Fechar {{$venda->st_tipo}} </h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>


            <div class="modal-body">
                   
                    <form class="form-inline" role="form"  method="post" action="{{ url('/venda/fechar_venda/'.$venda->id) }}">
                        {{ csrf_field() }}
                        <div class="col-md-6 form-inline{{ $errors->has('st_codigo') ? ' has-error' : '' }}">
                                <label for="st_codigo" class="control-label"> Forma de Pagamento</label>
                                <div>
                                    <select name="st_forma_pagamento" required="REQUIRED" class="form-control">
                                        <option value="">Selecione um forma de Pagamento</option>
                                        <option value="Dinheiro">Dinheiro</option>
                                        <option value="Cheque">Cheque</option>
                                        <option value="Cartão">Cartão</option>
                                        <option value="Carnê">Carnê</option>
                                       
                                    </select>
                                </div>
                        </div>
                    <input type="hidden" value="{{$total}}", name="st_valor">
                        
                           
                            
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                            <button type="submit"  class="btn btn-primary">Concluir venda</button>
                        </div>
                    </form>
            </div>
          </div>
        </div>
</div>
 
    <!-- Finalizar Venda/Orçamento -->
<div class="modal fade" id="cancelamento" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Cancelar {{$venda->st_tipo}} </h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>


            <div class="modal-body">
                   
                   Deseja Realmente cancelar
                    @if($venda->st_tipo == 'Venda')a venda?
                    @elseif($venda->st_tipo == 'Orçamento')o orçamento?
                    @endif
                    <form class="form-inline" role="form"  method="get" action="{{ url('/venda/cancelar_venda/'.$venda->id) }}">
                      
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">NÃO</button>
                            <button type="submit"  class="btn btn-primary">SIM</button>
                        </div>
                    </form>
            </div>
          </div>
        </div>
</div>


 
@stop
@extends('adminlte::page')

@section('title', 'caixas')
@php $totalvendas = 0;
    $totalvendascartao = 0;
    $totalvendascarne = 0;
    $totalvendascheque = 0;
    $outrosdinheiro = 0;
    $outroscheque = 0;
    $outroscartao = 0;
    $outroscarne = 0;
    $saidadinheiro = 0;
    $saidacheque = 0;
    $saidacartao = 0;
    $saidacarne = 0;

@endphp
@section('content')
    <div class="content">
            <div class="row">
                @if(isset($Msg))                        
                    <div class="col-md-12 alert alert-danger" role="alert">
                        {{$Msg}}
                    </div>
                @endif
             

               {{--  Começa a exibição do caixas --}}
        
                <div class="col-md-12">
                    <table class=" table table-bordered table-hover">
                        <thead>
                           
                                <tr class="bg-primary">
                                    <th colspan="2">DETALHES DO CAIXA</th>
                                    <th colspan="2">
                                        @if($caixa->st_status != 'Fechado')
                                        
                                            <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#fecharcaixa">
                                                  Fechar Caixa
                                            </button>
                                        @endif
                                    </th>
                                </tr>
                           
                            <tr>
                                <th >Data de abertura do Caixa</th>
                                <th >Responsável</th>
                                <th >Situação</th>
                                
                            </tr>
                        </thead>
                        <tbody>
                           
                            @if(isset($caixa) && !empty($caixa))
                            <tr style="font-size:12px" >
                                <th>{{date('d/m/Y', strtotime($caixa->dt_abertura))}}</th>
                                <th>{{$caixa->nomedoresponsavel}}</th>
                                <th>{{$caixa->st_status}}</th>
                               
                            </tr>
                            @endif
                        </tbody>
                    </table>
                   

                    @if(isset($vendasdinheiro) && count($vendasdinheiro)> 0)
                        <table class="table table-responsive bg-primary"  >
                           
                                <tr>
                                    <th colspan="6" style="text-align: center;">VENDAS EM DINHEIRO</th>
                                    
                                </tr>
                         
                           
                                <tr>
                                    <th>CÓDIGO VENDA</th>
                                    <th>VENDEDOR</th>
                                    <th>VALOR DA VANDA </th>
                                   
                                </tr>
                                @foreach($vendasdinheiro as $d)
                                <tr style="font-size: 12px;">
                                        <th>{{$d->nu_codigo}}{{date('dmY', strtotime($d->dt_cadastrovenda))}}</th>
                                    <th>{{$d->nomevendedor}}</th>
                                    <th>{{str_replace(".",",",$d->st_valor)}}</th>
                                </tr>
                                    @php $totalvendas = $totalvendas + $d->st_valor;@endphp
                                @endforeach
                                <tr style="background-color: gray">
                                    <th colspan="2">TOTAL</th>
                                    <th >{{$totalvendas}}</th>
                                </tr>
                           
                        <table>
                    @endif

                   {{--  Exibindo vendas em cartão --}}
                    @if(isset($vendascartao) && count($vendascartao)> 0)
                        <table class=" table table-responsive bg-primary">
                            <thead>
                                <tr class="bg-primary">
                                    <th colspan="6" style="text-align: center;">VENDAS EM CARTÃO</th>
                                    
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th>CÓDIGO VENDA</th>
                                    <th>VENDEDOR</th>
                                    <th>VALOR DA VENDA </th>
                                   
                                </tr>
                                @foreach($vendascartao as $d)
                                <tr>
                                        <th>{{$d->nu_codigo}}{{date('dmY', strtotime($d->dt_cadastrovenda))}}</th>
                                    <th>{{$d->nomevendedor}}</th>
                                    <th>{{str_replace(".",",",$d->st_valor)}}</th>
                                </tr>
                                    @php $totalvendascartao = $totalvendascartao + $d->st_valor;@endphp
                                @endforeach
                                <tr style="background-color: gray">
                                    <th colspan="2">TOTAL</th>
                                    <th >{{$totalvendascartao}}</th>
                                </tr>
                            </tbody>
                        <table>
                    @endif
                   {{--  Exibindo vendas em Cheuqe--}}
                    @if(isset($vendascheque) && count($vendascheque) > 0)
                        <table class="table table-responsive bg-primary">
                            <thead>
                                <tr class="bg-primary">
                                    <th colspan="6" style="text-align: center;">VENDAS EM CHEQUE</th>
                                    
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th>CÓDIGO VENDA</th>
                                    <th>VENDEDOR</th>
                                    <th>VALOR DA VENDA </th>
                                   
                                </tr>
                                @foreach($vendascheque as $d)
                                <tr>
                                        <th>{{$d->nu_codigo}}{{date('dmY', strtotime($d->dt_cadastrovenda))}}</th>
                                    <th>{{$d->nomevendedor}}</th>
                                    <th>{{str_replace(".",",",$d->st_valor)}}</th>
                                </tr>
                                    @php $totalvendascheque = $totalvendascheque + $d->st_valor;@endphp
                                @endforeach
                                <tr style="background-color: gray">
                                    <th colspan="2">TOTAL</th>
                                    <th >{{$totalvendascheque}}</th>
                                </tr>
                            </tbody>
                        <table>
                    @endif
                   {{--  Exibindo vendas em Carnê --}}
                    @if(isset($vendascarne) && count($vendascarne) > 0)
                        <table class="table table-responsive bg-primary">
                            <thead>
                                <tr class="bg-primary">
                                    <th colspan="6" style="text-align: center;">VENDAS EM CARNÊ</th>
                                    
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th>CÓDIGO VENDA</th>
                                    <th>VENDEDOR</th>
                                    <th>VALOR DA VENDA </th>
                                   
                                </tr>
                                @foreach($vendascarne as $d)
                                <tr>
                                        <th>{{$d->nu_codigo}}{{date('dmY', strtotime($d->dt_cadastrovenda))}}</th>
                                    <th>{{$d->nomevendedor}}</th>
                                    <th>{{str_replace(".",",",$d->st_valor)}}</th>
                                </tr>
                                    @php $totalvendascarne = $totalvendascarne + $d->st_valor;@endphp
                                @endforeach
                                <tr style="background-color: gray">
                                    <th colspan="2">TOTAL</th>
                                    <th >{{$totalvendascarne}}</th>
                                </tr>
                            </tbody>
                        <table>
                    @endif
                   {{--  Exibindo Outros tipos de entradas --}}
                    @if(isset($outrasentradas) && count($outrasentradas) > 0)
                        <table class="table table-responsive bg-primary">
                            <thead>
                                <tr class="bg-primary">
                                    <th colspan="4" style="text-align: center;">OUTRAS ENTRADAS</th>
                                    
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th >DESCRIÇÃO</th>
                                    <th>VALOR</th>
                                    <th>TIPO </th>
                                    @if($caixa->st_status != 'Fechado')
                                    <th>AÇÃO </th>
                                   @endif
                                </tr>
                            
                                @foreach($outrasentradas as $O)
                               
                                <form method="get" id="{{$O->id}}" action="{{url('editaoutrasentradas/'.$O->id)}}">
                                        {{ csrf_field() }}
                                <tr>
                                        <th >{{$O->st_descricao}}
                                            <div class= "{{$O->id}}" style="display: none">
                                                <input style="color:#000;" name="st_descricao" type="text" value="{{$O->st_descricao}}">
                                            </div>
                                        </th>
                                        <th>{{str_replace(".",",", $O->st_valor)}}
                                            <div class="{{$O->id}}" style="display: none">
                                                <input style="color:#000;" name="st_valor" type="money" value="{{$O->st_valor}}">
                                            </div>
                                        </th>
                                        <th>{{$O->st_forma_pagamento}}
                                            <div class= "{{$O->id}}" style="display: none">
                                                <select name="st_forma_pagamento" style="color:#000;" >
                                                    <option value="{{$O->st_forma_pagamento}}">{{$O->st_forma_pagamento}}</option>
                                                    <option  value="Dinheiro">Dinheiro</option>
                                                    <option  value="Cartão">Cartão</option>
                                                    <option  value="Carnê">Carnê</option>
                                                    <option  value="Cheque">Cheque</option>
                                                </select>
                                            </div>
                                        </th>
                                        <th>
                                            @if($caixa->st_status != 'Fechado')
                                                <div id="editar">
                                                <button type="button" class="btn btn-danger"  onclick="habilitaform({{$O->id}})">
                                                        Editar
                                                  </button>
                                                </div>
                                                <div id="salvar" style="display: none">
                                                <button  type="button" class="btn btn-sucess"  onclick="submitform({{$O->id}})">
                                                        Salvar
                                                </button>
                                                </div>
                                            @endif
                                        </th>
                                </tr>
                                    @if($O->st_forma_pagamento == "Dinheiro")
                                    @php $outrosdinheiro = $outrosdinheiro + $O->st_valor;@endphp
                                    @elseif($O->st_forma_pagamento == "Cartão")
                                    @php $outroscartao = $outroscartao + $O->st_valor;@endphp
                                    @elseif($O->st_forma_pagamento == "Cheque")
                                    @php $outroscheque = $outroscheque + $O->st_valor;@endphp
                                    @elseif($O->st_forma_pagamento == "Carne")
                                    @php $outroscarne = $outroscarne + $O->st_valor;@endphp
                                    @endif
                                    
                                </form>           
                                @endforeach

                                <tr style="background-color: gray">
                                    <th>Dinheiro</th>
                                    <th>Cartão</th>
                                    <th>Cheque</th>
                                    <th>Carnê</th>
                                </tr>
                                <tr style="background-color: gray">
                                <th>{{$outrosdinheiro}}</th>
                                <th>{{$outroscartao}}</th>
                                <th>{{$outroscheque}}</th>
                                <th>{{$outroscarne}}</th>
                                </tr>
                            </tbody>
                        <table>
                    @endif
                   {{--  Exibindo Saídas de valores --}}
                    @if(isset($saidas) && count($saidas) > 0)
                        <table class="table table-responsive bg-primary">
                            <thead>
                                <tr class="bg-primary">
                                    <th colspan="4" style="text-align: center;">SAÍDAS</th>
                                    
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th >DESCRIÇÃO</th>
                                    <th>VALOR</th>
                                    <th>TIPO </th>
                                    @if($caixa->st_status != 'Fechado')
                                    <th>AÇÃO </th>
                                   @endif
                                </tr>
                            
                                @foreach($saidas as $s)
                               
                                <form method="get" id="{{$s->id}}" action="{{url('editaoutrasentradas/'.$s->id)}}">
                                        {{ csrf_field() }}
                                <tr>
                                        <th >{{$s->st_descricao}}
                                            <div class= "{{$s->id}}" style="display: none">
                                                <input style="color:#000;" name="st_descricao" type="text" value="{{$s->st_descricao}}">
                                            </div>
                                        </th>
                                        <th>{{str_replace(".",",", $s->st_valor)}}
                                            <div class="{{$s->id}}" style="display: none">
                                                <input style="color:#000;" name="st_valor" type="money" value="{{$s->st_valor}}">
                                            </div>
                                        </th>
                                        <th>{{$s->st_forma_pagamento}}
                                            <div class= "{{$s->id}}" style="display: none">
                                                <select name="st_forma_pagamento" style="color:#000;" >
                                                    <option value="{{$s->st_forma_pagamento}}">{{$s->st_forma_pagamento}}</option>
                                                    <option  value="Dinheiro">Dinheiro</option>
                                                    <option  value="Cartão">Cartão</option>
                                                    <option  value="Carnê">Carnê</option>
                                                    <option  value="Cheque">Cheque</option>
                                                </select>
                                            </div>
                                        </th>
                                        <th>
                                            @if($caixa->st_status != 'Fechado')
                                                <div id="editar">
                                                <button type="button" class="btn btn-danger"  onclick="habilitaform({{$s->id}})">
                                                        Editar
                                                  </button>
                                                </div>
                                                <div id="salvar" style="display: none">
                                                <button  type="button" class="btn btn-sucess"  onclick="submitform({{$s->id}})">
                                                        Salvar
                                                </button>
                                                </div>
                                            @endif
                                        </th>
                                </tr>
                                    @if($s->st_forma_pagamento == "Dinheiro")
                                    @php $saidadinheiro = $saidadinheiro + $s->st_valor;@endphp
                                    @elseif($s->st_forma_pagamento == "Cartão")
                                    @php $saidacartao = $saidacartao + $s->st_valor;@endphp
                                    @elseif($s->st_forma_pagamento == "Cheque")
                                    @php $saidacheque = $saidacheque + $s->st_valor;@endphp
                                    @elseif($s->st_forma_pagamento == "Carne")
                                    @php $saidacarne = $saidacarne + $s->st_valor;@endphp
                                    @endif
                                    
                                </form>           
                                @endforeach

                                <tr style="background-color: gray">
                                    <th>Dinheiro</th>
                                    <th>Cartão</th>
                                    <th>Cheque</th>
                                    <th>Carnê</th>
                                </tr>
                                <tr style="background-color: gray">
                                <th>{{$saidadinheiro}}</th>
                                <th>{{$saidacartao}}</th>
                                <th>{{$saidacheque}}</th>
                                <th>{{$saidacarne}}</th>
                                </tr>
                            </tbody>
                        <table>
                    @endif

                    <table class="table table-responsive">
                        <tr>
                            <th colspan="5" style="text-align: center;">  RESUMO DO  CAÍXA</th>
                        </tr>
                        <tr>
                            <th>  MOVIMENTAÇÕES</th>
                       
                            <th> DINHEIRO</th>

                            <th> CARTÃO</th>

                            <th> CHEQUE</th>
                            <th> CARNÊ</th>
                            <th> TOTAL</th>
                        </tr>
                        <tr>
                            <th> VENDAS</th>
                            <th> {{$totalvendas}}</th>
                            <th> {{$totalvendascartao}}</th>
                      
                            <th> {{$totalvendascheque}}</th>
                    
                            <th> {{$totalvendascarne}}</th>
                            <th> {{$totalvendas + $totalvendascartao + $totalvendascheque + $totalvendascarne}}</th>
                        </tr>
                        <tr>
                            <th> OUTRAS ENTRADAS</th>
                            <th> {{$outrosdinheiro}}</th>
                            <th> {{$outroscartao}}</th>
                      
                            <th> {{$outroscheque}}</th>
                    
                            <th> {{$outroscarne}}</th>
                            <th> {{$outrosdinheiro + $outroscartao + $outroscheque + $outroscarne}}</th>
                        </tr>
                        <tr>
                            <th> SAÍDAS</th>
                            <th> {{$saidadinheiro}}</th>
                            <th> {{$saidacartao}}</th>
                      
                            <th> {{$saidacheque}}</th>
                    
                            <th> {{$saidacarne}}</th>
                            <th> {{$saidadinheiro + $saidacartao + $saidacheque + $saidacarne}}</th>
                        </tr>
                        <tr style="background: gray">
                            <th> TOTAL</th>
                            <th> {{ ($outrosdinheiro + $totalvendas) -($saidadinheiro) }}</th>
                            <th> {{($outroscartao + $totalvendascartao) -($saidacartao)}}</th>
                            <th> {{($outroscheque + $totalvendascheque) -($saidacheque)}}</th>
                            <th> {{($outroscarne + $totalvendascarne) -($saidacarne)}}</th>
                      
                           </tr>
                    </table>
                </div>
            </div>
    </div>

 
    <!-- Modal Fechar caixa -->
<div class="modal fade" id="fecharcaixa" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Fechar Caixa</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>


            <div class="modal-body">
                   
                    Após fechar o caixa , não será mais possível fazer alteração alguma. Deseja Continuar?              
                    <form class="form-inline" role="form"  method="post" action="{{ url('/caixa/fachar_caixa/'.$caixa->id) }}">
                        {{ csrf_field() }}
                           
                        <input id="id_caixa" type="hidden" name="id_caixa">
                                  
                            
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                            <button type="submit"  class="btn btn-primary">Fechar Caixa</button>
                        </div>
                    </form>
            </div>
          </div>
        </div>
</div>

 
@stop
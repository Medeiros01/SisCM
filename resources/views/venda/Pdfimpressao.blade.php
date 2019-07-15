
@php 
    $total= 0;
    $ordem = 0;
@endphp
<link href="{{ asset('css/pdf.css') }}" rel="stylesheet">

            
                
             

               {{--  Começa a exibição do vendas --}}
        
                <div >
                        @include('header')
                    <table >
                        <thead>

                                <tr >
                                    <th colspan="5">DETALHES
                                        @if($venda->st_tipo == 'Venda')
                                            DA VENDA
                                        @elseif ($venda->st_tipo == 'Orçamento')
                                        DO ORÇAMENTO
                                        @endif
                                    </th>
                                </tr>
                           
                            <tr>
                                <th >Data</th>
                                <th >Código</th>
                                <th >Vendedor</th>
                                @if(isset($venda) && !empty($venda) && $venda->st_tipo == 'Venda')
                                <th>Cliente</th>
                                <th >Forma de Pagamento</th>
                                @else
                                <th colspan="2">Cliente</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @if(isset($venda) && !empty($venda))
                            <tr style="font-size:12px" >
                                <th>{{date('d/m/Y', strtotime($venda->dt_venda))}}</th>
                                <th>{{$venda->nu_codigo}}{{date('dmY', strtotime($venda->dt_venda))}}</th>
                                <th>{{$venda->st_nome_vendedor}}</th>
                                @if( $venda->st_tipo == 'Venda')
                                <th>{{$venda->st_nome_cliente}}</th>
                                <th>{{$venda->st_forma_pagamento ? null : "-"}}</th>
                                @else
                                <th colspan="2">{{$venda->st_nome_cliente}}</th>
                                @endif
                            </tr>
                            @endif
                        </tbody>
                    </table>
                   

                    @if(isset($produtosvendidos) && count($produtosvendidos)> 0)
                     <hr/>
                        <table>
                            <thead>
                                <tr >
                                    <th colspan="7">Descrição</th>
                                    
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th>Ord.</th>
                                    <th>Código</th>
                                    <th class="col1">Produto</th>
                                    <th>Valor Unidade</th>
                                    <th>Qtd</th>
                                    <th>Desconto</th>
                                    <th style="text-align:right; padding-right: 5px;">Valor Total</th>
                                    
                                </tr>
                                
                                @foreach($produtosvendidos as $p)
                                <tr>
                                        @php $ordem = $ordem+1;@endphp
                                        <th>{{$ordem}}</th>
                                        <th>{{$p->st_codigo}}</th>
                                        <th>{{$p->st_descricao}}</th>
                                        <th>{{str_replace(".",",",$p->st_preco_venda)}}</th>
                                        <th>{{$p->nu_quantidade}}</th>
                                        <th>{{str_replace(".",",",($p->st_desconto))}}</th>
                                        <th style="text-align:right; padding-right: 5px;">{{str_replace(".",",",($p->nu_quantidade * $p->st_preco_venda)-$p->st_desconto) }}</th>
                               
                                </tr>
                               @php $total = $total +($p->nu_quantidade * $p->st_preco_venda) -$p->st_desconto; @endphp
                             
                               @endforeach
                                <tr style="background-color: grey;">
                                    <td colspan="6" style="text-align: right; padding-right: 5px;">TOTAL</td>
                                    <td colspan="1" style="text-align: right; padding-right: 5px;">R$.{{str_replace(".",",",$total)}}</td>
                                </tr>
                            </tbody>
                        <table>
                    @endif
                </div>


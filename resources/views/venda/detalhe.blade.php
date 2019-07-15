
@php $total= 0;@endphp


            
                
             

               {{--  Começa a exibição do vendas --}}
        
                <div >
                        
                    <table >
                        <thead>
                            <tr>
                                    <th colspan="5" ><h1>
                                        @if($venda->st_tipo == 'Orçamento')
                                         <div class="col-md-3 bg-primary">      
                                        ORÇAMENTO
                                         </div>
                                        @else 
                                        <div >      
                                           VENDA 
                                        </div>      
                                        @endif
                                    <h1></th>
                            </tr>
                          
                                <tr >
                                    <th colspan="5">DETALHES DA VENDA</th>
                                </tr>
                           
                            <tr>
                                <th >Data</th>
                                <th >Vendedor</th>
                                <th >Cliente</th>
                                <th >Tipo</th>
                                <th >Situação</th>
                                
                            </tr>
                        </thead>
                        <tbody>
                            @if(isset($venda) && !empty($venda))
                            <tr style="font-size:12px" >
                                <th>{{date('d/m/Y', strtotime($venda->dt_venda))}}</th>
                                <th>{{$venda->st_nome_vendedor}}</th>
                                <th>{{$venda->st_nome_cliente}}</th>
                                <th>{{$venda->st_tipo}}</th>
                                <th>{{$venda->st_status}}</th>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                   

                    @if(isset($produtosvendidos) && count($produtosvendidos)> 0)
                        <table>
                            <thead>
                                <tr >
                                    <th colspan="7">Descrição</th>
                                    
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th>Código</th>
                                    <th>Produto</th>
                                    <th>Valor Unidade</th>
                                    <th>Qtd</th>
                                    <th>Desconto</th>
                                    <th>Valor Total</th>
                                    
                                </tr>
                                
                                @foreach($produtosvendidos as $p)
                                <tr>
                               
                                        <th>{{$p->st_codigo}}</th>
                                        <th>{{$p->st_nome}}</th>
                                        <th>{{str_replace(".",",",$p->st_preco_venda)}}</th>
                                        <th>{{$p->nu_quantidade}}
                                            
                                        </th>
                                        <th>{{str_replace(".",",",($p->st_desconto))}}
                                           
                                        </th>
                                        <th>{{str_replace(".",",",($p->nu_quantidade * $p->st_preco_venda)-$p->st_desconto) }}</th>
                               
                                </tr>
                               @php $total = $total +($p->nu_quantidade * $p->st_preco_venda) -$p->st_desconto; @endphp
                             
                               @endforeach
                                <tr style="background-color: grey;">
                                    <td colspan="6" style="text-align: right">TOTAL</td>
                                    <td colspan="1">{{str_replace(".",",",$total)}}</td>
                                </tr>
                            </tbody>
                        <table>
                    @endif
                </div>
           
    


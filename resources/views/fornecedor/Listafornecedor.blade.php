@extends('adminlte::page')

@section('title', 'fornecedores')

@section('content')
    <div class="content">
            <div class="row">
                @if(isset($Msg))                        
                    <div class="col-md-12 alert alert-danger" role="alert">
                        {{$Msg}}
                    </div>
                @endif
                <div class="caixa">
                    <div class="col-md-4">
                            <a href="{{url("fornecedor/create")}}" class="btn btn-primary">NOVO FORNECEDOR</a>
                
                    </div>
                    <div class="col-md-8">
                
                            <form id="buscafornecedor" class="form-inline pull-left"  role="form" method="POST" action='{{ url("fornecedores") }}'>
                                {{csrf_field()}}
                                <div class="input-group">
                                        <input type="text" required="required" name="st_fornecedor" id="st_fornecedor" class="form-control" placeholder="NOME ou CNPJ/CPF">
                                        <span class="input-group-btn">
                                            <button type="submit" id="search-btn" class="btn btn-primary">
                                                <i class="fa fa-search"></i>
                                            </button>
                                        </span>
                                    </div>
                            
                            </form>

                    </div>
                </div>

               {{--  Começa a exibição do clientes --}}
        
                <div class="col-md-12">
                    

                    <table class=" table table-bordered table-striped">
                        <thead>
                            <tr class="bg-primary">
                                <th colspan="4">LISTAGEM DE FORNECEDORES</th>
                                <th colspan="1">
                                    @if(isset($fornecedores) && count($fornecedores)> 0)
                                    Total de fornecedores ativos: {{count($fornecedores)}}
                                    @endif
                                </th>
                            </tr>
                            <tr>
                                <th class="col-md-3">NOME</th>
                                <th class="col-md-1">CNPJ/CPF</th>
                                <th class="col-md-4">ENDEREÇO</th>
                                <th class="col-md-2">CONTATO</th>
                                
                                <th class="col-md-2">AÇÕES</th>
                           
                            </tr>
                        </thead>
                        <tbody>
                        @if(isset($fornecedores))
                            @foreach($fornecedores as $f)
                        <tr style="font-size:12px">
                            <th>{{$f->st_nome}}</th>
                            <th>{{$f->st_cnpj_cpf}}</th>
                        <th>{{$f->st_endereco}}, {{$f->st_municipio}}/{{$f->st_estado}}</th>
                        <th>{{$f->st_contato}}</th>
                            <th><a href="{{url('fornecedor/edita/'.$f->id)}}" title="Editar"> <i class="fa fa-pencil"></i></a> 
                            </th>
                        </tr>
                        @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>

 
@stop
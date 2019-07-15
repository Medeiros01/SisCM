@extends('adminlte::page')

@section('title', 'Categorias')

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
                            <a href="{{url("categoria/create")}}" class="btn btn-primary">NOVA CATEGORIA</a>
                
                    </div>
                    <div class="col-md-8">
                
                            <form id="buscacategoria" class="form-inline pull-left"  role="form" method="POST" action='{{ url("categorias") }}'>
                                {{csrf_field()}}
                                <div class="input-group">
                                        <input type="text" required="required" name="st_categoria" id="st_categoria" class="form-control" placeholder="NOME">
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
                                <th colspan="2">LISTAGEM DE CATEGORIAS</th>
                                <th colspan="1">
                                    @if(isset($categorias) && count($categorias)> 0)
                                    Total de categorias ativas: {{count($categorias)}}
                                    @endif
                                </th>
                            </tr>
                            <tr>
                                <th class="col-md-3">NOME</th>
                                <th class="col-md-7">DESCRIÇÃO</th>
                                
                                <th class="col-md-2">AÇÕES</th>
                           
                            </tr>
                        </thead>
                        <tbody>
                        @if(isset($categorias))
                            @foreach($categorias as $c)
                        <tr style="font-size:12px">
                            <th>{{$c->st_nome}}</th>
                            <th>{{$c->st_descricao}}</th>
                            <th><a href="{{url('categoria/edita/'.$c->id)}}" title="Editar"> <i class="fa fa-pencil"></i></a> 
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
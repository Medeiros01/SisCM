@extends('adminlte::page')

@section('title', 'Cadastro de produtos')

@section('content')
<div class="row">
        <div class="col-md-12">
            
                @if(session('sucessoMsg'))
                <div class="container">
                    <div class="alert alert-success alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <strong>Sucesso!</strong> {{ session('sucessoMsg')}}
                    </div>
                </div>
                @endif
                @if(session('erroMsg'))
                <div class="container">
                    <div class="alert alert-danger alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <strong>Atenção!</strong> {{ session('erroMsg')}}
                    </div>
                </div>
                @endif
        </div>
    </div>

<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <div class="panel panel-primary">
            <div class="panel-heading">Cadastro de produto</div>
            <div class="panel-body">
                <form class="form-horizontal" role="form" method="POST" action="{{ url('produto/edita/'.$produto->id) }}">
                    {{ csrf_field() }}
                        
                    <div class="form-group{{ $errors->has('st_codigo') ? ' has-error' : '' }}">
                        <label for="st_codigo" class="col-md-4 control-label">Código</label>

                        <div class="col-md-6">
                            <input id="st_codigo" type="text" class="form-control" required="true" placeholder="Insira o código do produto" name="st_codigo" value="{{ $produto->st_codigo }}"> 
                            @if ($errors->has('st_codigo'))
                            <span class="help-block">
                                <strong>{{ $errors->first('st_codigo') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group{{ $errors->has('st_nome') ? ' has-error' : '' }}">
                        <label for="st_nome" class="col-md-4 control-label">Nome</label>

                        <div class="col-md-6">
                            <input id="st_nome" type="text" class="form-control" required="true" placeholder="Insira o Nome do produto" name="st_nome" value="{{ $produto->st_nome }}"> 
                            @if ($errors->has('st_nome'))
                            <span class="help-block">
                                <strong>{{ $errors->first('st_nome') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>
                    
                    <div class="form-group{{ $errors->has('st_descricao') ? ' has-error' : '' }}">
                        <label for="st_descricao" class="col-md-4 control-label">Descrição</label>

                        <div class="col-md-6">
                            <input id="st_descricao" type="text" class="form-control"  placeholder="Insira uma descrição parao produto" name="st_descricao" value="{{ $produto->st_descricao }}"> 
                            @if ($errors->has('st_descricao'))
                            <span class="help-block">
                                <strong>{{ $errors->first('st_descricao') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>
 
                 

                    <div class="form-group{{ $errors->has('ce_categoria') ? ' has-error' : '' }}">
                        <label for="ce_categoria" class="col-md-4 control-label">Categoria</label>
                        <div class="col-md-6">
                            <select id="ce_categoria" name="ce_categoria" class="form-control" required="required">
                                <option value="">Selecione</option>
                                @if(isset($categorias) && count($categorias)>0 )
                                    @foreach($categorias as $c)
                                        @if($produto->ce_categoria == $c->id )
                                        <option selected="true" value="{{$c->id}}">{{$c->st_nome}}</option>
                                        @else
                                        <option value="{{$c->id}}">{{$c->st_nome}}</option>
                                        @endif
                                    @endforeach
                                @endif
                            </select>
                            @if ($errors->has('ce_categoria'))
                            <span class="help-block">
                                <strong>{{ $errors->first('ce_categoria') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>

         
                    <div class="form-group{{ $errors->has('ce_fornecedor') ? ' has-error' : '' }}">
                        <label for="ce_fornecedor" class="col-md-4 control-label">Fornecedor</label>
                        <div class="col-md-6">
                            <select id="ce_fornecedor" name="ce_fornecedor" class="form-control" required="required">
                                <option value="">Selecione</option>
                                @if(isset($fornecedores) && count($fornecedores)>0 )
                                    @foreach($fornecedores as $f)
                                    @if($produto->ce_fornecedor == $f->id )
                                        <option selected="true" value="{{$f->id}}">{{$f->st_nome}}</option>
                                    @else    
                                        <option value="{{$f->id}}">{{$f->st_nome}}</option>
                                    @endif    
                                    @endforeach
                                @endif
                            </select>
                            @if ($errors->has('ce_fornecedor'))
                            <span class="help-block">
                                <strong>{{ $errors->first('ce_fornecedor') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('nu_disponivel') ? ' has-error' : '' }}">
                        <label for="st_nome" class="col-md-4 control-label">Quantidade</label>

                        <div class="col-md-6">
                            <input id="nu_disponivel" type="text" class="form-control" required="true"  name="nu_disponivel" value="{{ $produto->nu_disponivel }}"> 
                            @if ($errors->has('nu_disponivel'))
                            <span class="help-block">
                                <strong>{{ $errors->first('nu_disponivel') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>
                    
                    <div class="form-group{{ $errors->has('st_preco_custo') ? ' has-error' : '' }}">
                        <label for="st_nome" class="col-md-4 control-label">Preço de Custo</label>

                        <div class="col-md-6">
                            <input id="st_preco_custo" type="money" class="form-control" required="true"  name="st_preco_custo" value="{{ $produto->st_preco_custo }}"> 
                            @if ($errors->has('st_preco_custo'))
                            <span class="help-block">
                                <strong>{{ $errors->first('st_preco_custo') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>
                
                    <div class="form-group{{ $errors->has('st_preco_venda') ? ' has-error' : '' }}">
                        <label for="st_preco_venda" class="col-md-4 control-label">Preço de Venda</label>

                        <div class="col-md-6">
                            <input id="st_preco_venda" type="money" min="0.00" max="10000.00" step="0.01" class="form-control" required="true"  name="st_preco_venda" value="{{ $produto->st_preco_venda }}"> 
                            @if ($errors->has('st_preco_venda'))
                            <span class="help-block">
                                <strong>{{ $errors->first('st_preco_venda') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>
                

                    <div class="form-group ">
                        <div class="col-md-2  col-md-offset-4">
                            <a href='{{ url("produtos")}}' class=" btn btn-danger"  title="Voltar">
                                <span class="glyphicon glyphicon-arrow-left"></span> Voltar
                            </a>
                        </div>
                        <button type="submit" class="col-md-2 btn btn-primary">
                            <i class="fa fa-check"> </i> Salvar
                        </button>
                    </div>


                </form>
                
                
            </div>
        </div>
</div>
<script>

</script>
@stop
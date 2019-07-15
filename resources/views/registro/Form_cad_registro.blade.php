@extends('adminlte::page')

@section('title', 'Cadastro de Caderneta de Regsitro')
<?php
use App\utis\Funcoes;
$select = 2;
?>

@section('content')

<div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-primary">
                    <div class="panel-heading">Cadastro de Publicação</div>
                    <div class="panel-body">
                        <form class="form-horizontal" role="form" method="POST" action="{{ url('/registro/'.$funcionario->id.'/'.$tiporegistro) }}">
                            {{ csrf_field() }}
                            
                            <!-- <input type="hidden" name="st_regional" value="{{ Auth::user()->st_regional}}"> -->
    
                            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                <label for="name" class="col-md-4 control-label">Funcionário</label>
    
                                <div class="col-md-6">
                                    <input  type="text" disabled class="form-control" required="true"  value="{{$funcionario->st_nome}}"> 
                                    @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            @if(isset( $itens) && count( $itens)>0)
                              @foreach($itens as $item)
                                @if($item->st_nomeitem == 'Texto Curto')
                                <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                    <label for="name" class="col-md-4 control-label">{{$item->st_nome}}</label>
    
                                        <div class="col-md-6">
                                            <input  type="text" name="{{$item->id}}" required="true" class="form-control"  value=""> 
                                            @if ($errors->has('name'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('name') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                </div>
                                @elseif($item->st_nomeitem == 'data')
                                <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                    <label for="name" class="col-md-4 control-label">{{$item->st_nome}}</label>
    
                                        <div class="col-md-6">
                                            <input  type="date" name="{{$item->id}}" required="true" class="form-control" > 
                                            @if ($errors->has('name'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('name') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                </div>
                               
                                @elseif($item->st_nomeitem == 'Texto longo')
                                <div class="form-group{{ $errors->has('st_descricao') ? ' has-error' : '' }}">
                                <label for="st_descricao" class="col-md-4 control-label">{{$item->st_nome}}</label>

                                    <div class="col-md-6 ">
                                        <textarea  name="{{$item->id}}" cols="120" rows="4" class="form-control" placeholder="{{$item->st_nome}}" value="{{ old('st_descricao') }}"></textarea>

                                        @if ($errors->has('st_descricao'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('st_descricao') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                              
                                
                                @endif    

                              @endforeach
                              

                                <div class="col-md-6 col-md-offset-4 form-group{{ $errors->has('st_tipo') ? ' has-error' : '' }}" >
                                <label for="st_tipo" class="control-label"> Altera Status?</label>

                                    <div>
                                
                                        <select id="st_alterastatus"  onclick="alterarstatusservidor()" name= "st_alterastatus" require="true" class="form-control-required" required="required">
                                        <option value="">Selecione</option>
                                        <option value="Não">Não</option>
                                        <option value="Sim">Sim</option>
                                        </select>
                                        
                                        @if ($errors->has('st_alterastatus'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('st_alterastatus') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>


                                 <div id='status' style="display: none;" class="col-md-6 form-inline{{ $errors->has('st_status') ? ' has-error' : '' }}" >
                                <label for="st_status" class="control-label"> Status Funcioário</label>

                                    <div>
                                        <select id="st_status" name= "st_status" desabled class="form-control-required" disabled >
                                        <option value="">Selecione</option>
                                        @if(isset($status) && count($status)>0)
                                            @foreach($status as $s)
                                            <option value="{{$s->id}}">{{$s->st_status}}</option>
                                            @endforeach
                                        @endif
                                        </select>
                                        @if ($errors->has('st_status'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('st_status') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>


                            @endif
                            
                            
                                <div class="col-md-12  form-group{{ $errors->has('st_tipo') ? ' has-error' : '' }}" >
                                    <div class="col-md-6  form-group{{ $errors->has('st_tipo') ? ' has-error' : '' }}" >
                                    <label for="st_tipo" class="control-label"> Dasativa funcionários</label>

                                        <div>
                                    
                                            <select id="st_desativafuncionario"  onclick="desativafuncionario()" name= "st_desativafuncionario" require="true" class="form-control-required" required="required">
                                            <option value="">Selecione</option>
                                            <option value="Não">Não</option>
                                            <option value="Sim">Sim</option>
                                            </select>
                                            
                                            @if ($errors->has('st_desativafuncionario'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('st_desativafuncionario') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>


                                    <div id='motivo' style="display: none;" class="col-md-6 form-inline{{ $errors->has('st_status') ? ' has-error' : '' }}" >
                                    <label for="st_motivo" class="control-label"> Tipo da inatividade</label>

                                        <div>
                                            <select id="st_motivo" name= "st_motivo" desabled class="form-control-required" disabled >
                                            <option value="">Selecione</option>
                                                <option value=""></option>
                                                <option value="Abandono de Cargo">Abandono de Cargo</option>
                                                <option value="Aposentado">Aposentado</option>
                                                <option value="Devolvido">Devolvido</option>
                                                <option value="Demitido">Demitido</option>
                                                <option value="Exonerado">Exonerado</option>
                                                <option value="Falecido">Falecido</option>
                                                <option value="Relotado">Relotado</option>
                                                <option value="Outros">Outros</option>
                                            </select>
                                            @if ($errors->has('st_motivo'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('st_motivo') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                            
                            
                            
                            <div class="form-group col-md-12">
                                <div class="col-md-2">
                                    <a href="javascript:history.back()" class=" btn btn-danger"  title="Voltar">
                                        <span class="glyphicon glyphicon-arrow-left"></span> Voltar
                                    </a>
                                </div>
                                <button type="submit" class="col-md-2 btn btn-primary">
                                    <i class="fa fa-btn fa-user"></i> Cadastrar
                                </button>
                            </div>
    
    
                        </form>
                       
                        
                    </div>
                </div>
            </div>
        </div>
    
@stop
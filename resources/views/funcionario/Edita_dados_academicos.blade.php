@extends('funcionario.Form_edita_funcionario')

@section('tabcontent')
<div class="tab-pane active" id="dados_academicos">
    <h4 class="tab-title">Dados Acadêmicos - {{ strtoupper($servidor->st_nome) }}</h4>
    <hr class="separador">
    <form role="form" method="POST" action="{{ url('/servidor/edita/'.$servidor->id) }}">
        {{ csrf_field() }}
        <div class="form-group col-md-offset-2 col-md-1">
            <label for="ce_escolaridade" class="control-label">Escolaridade</label>
        </div>
        <div class="form-group{{ $errors->has('ce_escolaridade') ? ' has-error' : '' }} col-md-5">
            <select id="ce_escolaridade" name="ce_escolaridade" class="form-control">
                <option value="">Selecione</option>
                @forelse($escolaridades as $e)
                
                    <option value="{{$e->id}}" {{( $e->id == $servidor->ce_escolaridade) ? 'selected': '' }}>{{$e->st_escolaridade}}</option>
                @empty
                    <option>Não há escolaridades cadastrados.</option>
                @endforelse
            </select>
            @if ($errors->has('ce_escolaridade'))
            <span class="help-block">
                <strong>{{ $errors->first('ce_escolaridade') }}</strong>
            </span>
            @endif
        </div>
        <div class="form-group col-md-1">
            <button type="submit" class=" btn btn-primary">
                <i class="fa fa-fw fa-save"></i> Salvar
            </button>
        </div>
      
    </form>
    
</div>

<div class="content">
    <div class="row">
        <div class="col-md-10">

            <table class="table table-bordered">
                <thead>
                    <tr class="bg-primary">
                        <th colspan="3">Cursos</th>
                        <th>
                            @can('Edita')
                                <a href='{{url("curso/create/{$servidor->id}")}}' class="btn btn-primary">Novo Curso</a>
                            @endcan
                        </th>
                    </tr>
                    
                    <tr>
                        <th class="col-md-3">Nome</th>
                        <th class="col-md-2">Escolaridade</th>
                        <th class="col-md-1">Conclusão</th>
                        @can('Edita')
                            <th class="col-md-2">Ações</th>
                        @endcan
                    </tr>

                </thead>
                <tbody>
                        @if(isset($cursos))
                        @foreach($cursos as $c)
                    <tr>
                        <th>{{$c->st_nome}}</th>
                        <th>{{$c->st_cursoescolaridade}}</th>
                        <th>{{\Carbon\Carbon::parse($c->dt_conclusao)->format('d/m/Y')}}</th>      
                        @can('Edita')
                        <th><a class="btn btn-primary" href="{{url('curso/edita/' .$servidor->id. '/'  .$c->id)}}">Editar</a> | 
                            <a onclick="modalDesativa({{$c->id}})" data-toggle="modal" data-placement="top" title="Excluir" class="btn btn-danger">
                            <i class="fa fa-trash"></i></a> 
                        </th>
                        @endcan
                    </tr>
                    @endforeach
                    @endif
                </tbody>
                
            </table>
        </div>
    </div>
</div>

<div class="modal fade-lg" id="Modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog  modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Excluir Curso</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body bg-danger">

                <h4 class="modal-title" id="exampleModalLabel">
                    <b>DESEJA REALMENTE EXCLUIR O CURSO?</b>
                </h4>
                <form class="form-inline" id="modalDesativa" method="post" > {{csrf_field()}}

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-primary">Excluir</button>
            </div>
            </form>
        </div>
    </div>
</div>
<script>

        function modalDesativa(id){
           
           $("#modalDesativa").attr("action", "{{ url('curso/deleta')}}/"+id);
                $('#Modal').modal();        
            };
        </script>

<!-- /.tab-pane -->
@endsection
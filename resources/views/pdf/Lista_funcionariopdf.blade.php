<html lang="pt-BR">

<head>
    <meta http-equiv="Content-Language" content="pt-br">
    <meta http-equiv="Content-type" content="text/html;charset=utf-8">
    <meta charset="utf-8">
    <link rel="icon" type="image/PNG" href="{{url('imgs/sesed.PNG')}}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="{{url('/imgs/logo2.png')}}">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <title>{{$titulo or 'SESED'}}</title>
    
    <link rel='stylesheet' href="{{url('/assets/css/pdf.css')}}">
</head>

    
<body>
    
    <table class="table table-responsive">
        <thead>
            <tr>
                <th colspan="5">LISTA DE {{$nome_tabela}}</th>
            </tr>
            <tr>
                <th >NOME</th>
                <th >MATRÍCULA</th>
                <th>CPF</th>
                <th >ORGÃO</th>
                <th>SETOR</th>
                
            </tr>
        </thead>
        <tbody>
            @if(isset($servidores))
                @forelse($servidores as $s)
                <tr>
                    <th>{{$s->st_nome}}</th>
                    <th>{{$s->st_matricula}}</th>
                    <th>{{$s->st_cpf}}</th>
                    <th>{{$s->st_siglaorgao}}</th>
                    <th>{{$s->st_siglasetor}}</th>
                    
                </tr>
                @empty
                <tr>
                    <td colspan="4" style="text-align: center;">Nenhum servidor cadastrado</td>
                </tr>
                @endforelse
            @endif
        </tbody>
    </table>
               
</body>
   </html>


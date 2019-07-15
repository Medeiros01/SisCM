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
                <th  colspan="5"> {{$titulo}} </th>
            </tr>
            <tr>
                <th >POSTO/GRAD.</th>
                <th >NOME</th>
                <th>SETOR</th>
                <th >DIA</th>
                <th >MÊS</th>
            </tr>
            </thead>
            <tbody>
                @if(isset($an))
                    @foreach($an as $a)
                    <tr>
                        <th>{{$a->st_postograduacao}}</th>
                        <th>{{$a->st_nome}}</th>
                        <th>{{$a->st_sigla}}</th>
                        <th>{{$a->dia}}</th>
                        <th>{{$a->mes}}</th>
                    </tr>
                    @endforeach
                    @endif
                </tbody>
            </table>
    </body>
</html>

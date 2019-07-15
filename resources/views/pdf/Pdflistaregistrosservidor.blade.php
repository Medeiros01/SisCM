

@section('title', 'Férias')
@php $contador = 0;
    $id_crs  = null;
    $caderneta  =NULL;
    $id_crs = 1; 
@endphp


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
@if(isset($registros))
                                Lista de {{$registros[0]->st_tiporegistro}} - {{$servidor->st_nome}}
                                @endif
<!-- RESPONSIVE TABLE -->
<table class="table table-responsive">
                        <thead>
                           
                            <tr>
                            @if(isset($registros))
                               
                                    @php   $nomesdositens =$registros[0]->registros;
                                       
                                    @endphp
                                    @foreach($nomesdositens  as  $item)
                                    <th >{{$item->st_nomedoitem}}</th>

                                    @endforeach 
                           

                              
                            @endif   
                            </tr>
                        </thead>
                        <tbody>
                        @if(isset($registros))
                       
                                      
                        @foreach($registros as $r)
                       
                   
                          
                                <tr>

                                    @php $caderneta = $r->registros;
                                         $id_crs =  $r->id;
                                     
                                  
                                     @endphp
                                    @foreach($caderneta  as  $valor)
                                   
                                    
                                        @if($valor->tipoitem == 'data')
                                        <th>{{date('d/m/Y',strtotime($valor->st_valor))}}
                                        </th>
                                        @elseif($valor->tipoitem == "Texto longo")
                                        <th>{{$valor->st_valor}} </th>
                                        @else
                                        <th>{{$valor->st_valor}} </th>

                                        @endif
                                    @endforeach
                                   
                                   
                                </tr>
                        @endforeach
                        @endif
                    </tbody>
                </table>

</body>

</html>
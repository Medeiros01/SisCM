

@section('title', 'Ficha')


<html lang="pt-BR">

<head>
  
    
    <link rel='stylesheet' href="{{url('/assets/css/fichapdf.css')}}">
    

</head>

    
<body>
@include('pdf.cabecalho')

<footer>

           Impresso por {{Auth::user()->name}} aos {{date('d/m/Y - H:m:s')}}
            
     
        </footer>

    <!-- RESPONSIVE TABLE -->
 
            <table class="table">

                    
                    <tr >
                        <th  class="legandatitulo" colspan='4'> DADOS PESSOAIS</th>
                    
                    </tr>
         
                @if(isset($servidor))
     
                    <tr>
                        <th colspan='2'><span class='title'>Nome:</span><br/>{{$servidor->st_nome}} </th>
                        <th><span class='title'>Data Nascimento:</span><br/> @if(!empty($servidor->dt_nascimento)){{date('d/m/Y', strtotime($servidor->dt_nascimento))}} @endif</th>
                        <th><span class='title'>Sexo:</span><br/>{{$servidor->st_sexo}}</th>
                        
                    </tr>
                    <tr>
                        <th><span class='title'>Tipo Saguineo/Fator RH:</span><br/>{{$servidor->st_tiposanguineo}}/ {{$servidor->st_fatorh}}</th>
                        <th><span class='title'>Nacionalidade:</span><br/>{{$servidor->st_nacionalidade}}</th>
                        <th><span class='title'>Naturalidade:</span><br/>{{$servidor->st_naturalidade}}</th>
                        <th><span class='title'>UF Naturalidade:</span><br/>{{$servidor->st_naturalidade}}/{{$servidor->st_ufnaturalidade}}</th>
                    </tr>
                    <tr>
                        <th colspan='2'><span class='title'>Filiação - Nome do pai:</span><br/>{{$servidor->st_pai}}</th>
                        <th colspan='2'><span class='title'>Filiação - Nome da mãe:</span><br/>{{$servidor->st_mae}}</th>
                      
                    </tr>
                    <tr>
                        <th colspan='2'><span class='title'>Endereço:</span><br/>{{$servidor->st_logradouro}}</th>
                        <th><span class='title'>Número:</span><br/>{{$servidor->st_numeroresidencia}}</th>
                        <th><span class='title'>Complemento:</span><br/>{{$servidor->st_complemento}}</th>
                      
                    </tr>
                    <tr>
                        <th><span class='title'>Bairro:</span><br/>{{$servidor->st_bairro}}</th>
                        <th><span class='title'>CEP:</span><br/>{{$servidor->st_cep}}</th>
                        <th><span class='title'>Cidade:</span><br/>{{$servidor->st_cidade}}</th>
                        <th><span class='title'>UF:</span><br/>{{$servidor->st_uf}}</th>
                      
                    </tr>
                    <tr>
                        <th><span class='title'>Telefone Residencial:</span><br/>{{$servidor->st_telefoneresidencial}}</th>
                        <th><span class='title'>Telefone Celular:</span><br/>{{$servidor->st_telefonecelular}}</th>
                        <th  colspan='2'><span class='title'>E-mail:</span><br/>{{$servidor->st_email}}</th>
                      
                    </tr>
                    <tr>
                        <th><span class='title'>cpf:</span><br/>{{$servidor->st_cpf}}</th>
                        <th><span class='title'>Registro Geral:</span><br/>{{$servidor->st_rg}}</th>
                        <th><span class='title'>Órgão Emissor:</span><br/>{{$servidor->st_orgaorg}}</th>
                        <th><span class='title'>Data de Emissão:</span><br/> @if(!empty($servidor->dt_emissaorg)){{date('d/m/Y', strtotime($servidor->dt_emissaorg))}} @endif</th>
                    </tr>
                    <tr>
                        <th colspan='2'><span class='title'>Estado Civil:</span><br/>{{$servidor->st_estadocivil}}</th>
                        <th colspan='2'><span class='title'> Cônjuge:</span><br/>{{$servidor->st_conjuge}}</th>
                    </tr>
                    <tr>
                        <th colspan='2'><span class='title'>Título Eleitoral:</span><br/>{{$servidor->nu_titulo}}</th>
                        <th ><span class='title'> Zona:</span><br/>{{$servidor->nu_zonatitulo}}</th>
                        <th ><span class='title'> Sessão:</span><br/>{{$servidor->nu_secaotitulo}}</th>
                    </tr>
                    <tr>
                        <th colspan='2'><span class='title'>Cidade:</span><br/>{{$servidor->st_municipiotitulo}}</th>
                        <th><span class='title'> UF:</span><br/>{{$servidor->st_uftitulo}}</th>
                        <th><span class='title'> Data de Emissão:</span><br/>@if(!empty($servidor->dt_emissaotitulo)){{date('d/m/Y', strtotime($servidor->dt_emissaotitulo))}} @endif</th>
                    </tr>
                    <tr>
                        <th colspan='2'><span class='title'>CNH:</span><br/>{{$servidor->st_municipiotitulo}}</th>
                        <th ><span class='title'>Categoria:</span><br/>{{$servidor->st_categoriacnh}}</th>
                        <th><span class='title'> Data de Emissão:</span><br/>@if(!empty($servidor->dt_emissaocnh)){{date('d/m/Y', strtotime($servidor->dt_emissaocnh))}} @endif</th>
                    </tr>
                    <tr>
                        <th><span class='title'> Data de Validade:</span><br/>@if(!empty($servidor->dt_vencimentocnh)){{date('d/m/Y', strtotime($servidor->dt_vencimentocnh))}} @endif</th>
                        <th><span class='title'>UF:</span><br/>{{$servidor->st_ufcnh}}</th>
                        <th colspan='2'><span class='title'>PIS/PASEP:</span><br/>{{$servidor->nu_pis_pasep}}</th>
                    </tr>
                
              
                    
                    <tr>
                        <th class="legandatitulo" colspan='4'>DADOS FUNCIONAIS</th>
                    
                    </tr>
            
            
           
                    <tr>
                        <th><span class='title'>Matricula:</span><br/>{{$servidor->st_matricula}} </th>
                        <th><span class='title'>Órgão:</span><br/>{{$servidor->st_siglaorgao}} </th>
                        <th colspan='2'><span class='title'>Cargo/posto/Graduação:</span><br/>{{$servidor->st_postograduacao}} </th>
                       
                    </tr>
                    <tr>
                        <th><span class='title'>Nomeação:</span><br/> @if(!empty($servidor->dt_nomeacao)){{date('d/m/Y', strtotime($servidor->dt_nomeacao))}} @endif </th>
                        <th><span class='title'>Posse:</span><br/> @if(!empty($servidor->dt_posse)){{date('d/m/Y', strtotime($servidor->dt_posse))}} @endif</th>
                        <th><span class='title'>Exercício:</span><br/> @if(!empty($servidor->dt_exercissio)){{date('d/m/Y', strtotime($servidor->dt_exercissio))}} @endif</th>
                        <th><span class='title'>Data inclusão (SESED):</span><br/>@if(!empty($servidor->dt_inclusao)){{date('d/m/Y', strtotime($servidor->dt_inclusao))}} @endif</th>
                       
                    </tr>
                    <tr>
                        <th  colspan='2'><span class='title'>Local de Trabalho:</span><br/>{{$servidor->st_setor}} </th>
                        <th  colspan='2'><span class='title'>Função:</span><br/>{{$servidor->st_funcao}} </th>
                       
                    </tr>
                    
             
                    
                    <tr>
                        <th class="legandatitulo" colspan='4'>DADOS ACADÊMICOS</th>
                    
                    </tr>
               
            
                    <tr>
                        <th colspan='2'><span class='title'>Curso:</span><br/> </th>
                        <th ><span class='title'>Nível:</span><br/>{{$servidor->ce_escolaridade}} </th>
                        <th><span class='title'>Data de conclusao:</span><br/></th>
                       
                    </tr>
                   
            
                    
                    <tr>
                        <th class="legandatitulo" colspan='4'>FÉRIAS</th>
                    
                    </tr>
              
            
               
                    <tr>
                        <th>INÍCIO: </th>
                        <th>Fim: </th>
                        <th >Ano Referente:</th>
                        <th >Observação: </th>
                       
                       
                    </tr>
                        @if(isset($ferias) && count($ferias)>0)
                            @foreach($ferias as $f)
                   
                    <tr>
                           
                           
                            <th>
                           @if(!empty($f['1']->st_valor))
                            {{date('d/m/Y', strtotime($f['1']->st_valor))}}
                            @endif
                           </th>
                            <th>
                             @if(!empty($f['1']->st_valor))
                            {{date('d/m/Y', strtotime($f['1']->st_valor))}}
                            @endif
                            </th>
                            <th >{{$f['3']->st_valor}}</th>
                            <th >{{$f['4']->st_valor}}</th>
                           
                    </tr>
                             @endforeach
                        @endif

                    
                    <tr>
                        <th class="legandatitulo" colspan='4'>LICENÇAS</th>
                    
                    </tr>
               
                    <tr>
                        <th>Tipo: </th>
                        <th>Documento:<br/> </th>
                        <th >Início: </th>
                        <th >Fim: </th>
                    </tr>
                    @if(isset($licencas) && count($licencas)>0)
                            @foreach($licencas as $l)
                    <tr>
                   
                       
                                    
                                    <th >{{$l['4']->st_valor}}</th>
                                    <th>{{$l['3']->st_valor}}</th>
                                    
                                    <th > 
                                        @if(!empty($l['1']->st_valor))
                                        {{date('d/m/Y', strtotime($l['1']->st_valor))}}
                                        @endif
                                    </th>
                                    <th >
                                            @if(!empty($l['2']->st_valor))
                                        {{date('d/m/Y', strtotime($l['2']->st_valor))}}
                                        @endif
                                    </th>
                                    
                         

                    </tr>
                            @endforeach
                        @endif
                       
                   
                
              
                    
                    <tr>
                        <th class="legandatitulo" colspan='4'>PUBLICAÇÕES</th>
                    
                    </tr>
                
                    <tr>
                        <th>DAta/Publicação </th>
                        <th>Tipo: </th>
                        <th >Documento: </th>
                        <th >N° e data:</th>
                    </tr>
                    @if(isset($publicacoes) && count($publicacoes)>0)
                            @foreach($publicacoes as $p)
                    <tr>

                           
                                    
                                    <th>
                                    @if(!empty($p['4']->st_valor))
                                        {{date('d/m/Y', strtotime($p['4']->st_valor))}}
                                    @endif
                                    </th>
                                    <th>{{$p['0']->st_valor}}</th>
                                    <th>{{$p['2']->st_valor}}</th>
                                    <th>{{$p['3']->st_valor}}</th>
                                    
                                   
                    </tr>
                            @endforeach
                        
                    @endif
                   
                
                          
                @endif
            </table>
           

       
       
    
    </body>

</html>
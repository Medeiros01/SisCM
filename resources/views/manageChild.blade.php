<ul >
@php
$nome = "";
@endphp
@foreach($childs as $child)

	<li >
  

      
      <a href = "#">{{$child->st_nome}}</a>
	@if(count($child->filhos))
            @include('manageChild',['childs' => $child->filhos])
        @endif
	</li>
@endforeach
</ul>
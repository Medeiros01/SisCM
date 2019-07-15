
 <div >
                                            
<div class="panel-body">
    
            
            <ul id="tree1" >
            <?php
                $nome = "";
            ?>
            @if(isset($regiarvore)&& count($regiarvore)>0)
          
                @foreach($regiarvore as $category)
                
                    
                    
                    <li class="glyphicon glyphicon-tree-conifer">
                    <a href = '#'> 
                    {{$category->st_nome}}</a>
                    
                        @if(count($category->filhos))
                            @include('manageChild',['childs' => $category->filhos])

                        @endif
                    </li>
                @endforeach
            @endif
            </ul>
        </div>
        
    </div>

    
</div>

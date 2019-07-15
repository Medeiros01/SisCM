<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\User;
use App\Permission;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();


        
        
       
        $permissoions = Permission::with('roles')->get();
        
          /* Retornando todas a permissões do banco de dados, jantamente com todas a funções das permissões
         através do método roles() na Model Permission.
       
          ex: cadastra => atendente, adm
                Libera_DO => Medico Legista
           *    Reconhece => atendente, adm, papiloscopista
           *    Identifica => adm, papiloscopista
           *    Entrega_Corpo => atendente
         */
        foreach ($permissoions as $permission)
        {
            gate::define($permission->st_nome,  function(User $user)use($permission){
                return $user->hasPermission($permission);
            });
        }
        //definindo usuario administrador - tem poder de realizar qualquer ação no sistema
        gate::before(function (User $user, $ability){
           if($user->hasAnyRoles('Admin')){
              return true; 
           }
            
        });
        //
    }
}

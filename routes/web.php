<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();


//    Rota para o crud de usuários
//rotas para gestão de usuarios
Route::get('usuarios', 'UsuarioController@index')->name('usuarios');
Route::get('usuario/create', 'UsuarioController@form_usuario');
Route::get('usuario/edita/{id}', 'UsuarioController@fom_edita');
Route::post('usuario/edita/{id}', 'UsuarioController@update');
Route::post('usuario/desativa/{id}', 'UsuarioController@desativa');
Route::post('usuarios', 'UsuarioController@cad_usuario');
Route::get('usuario/alterasenha/{id}', 'UsuarioController@formularioalterasenha');
Route::post('usuario/alterasenha/{id}', 'UsuarioController@alterasenha');


Route::get('/home', 'ProdutoController@index')->name('home');
Route::get('/', 'ProdutoController@index')->name('home');
Route::get('/getfilhos', 'ProdutoController@getfilhos')->name('getfilhos');

Route::get('produtos', 'ProdutoController@index')->name('produto');
Route::post('produtos', 'ProdutoController@index')->name('produto');
Route::get('produto/create', 'ProdutoController@create')->name('produtocreate');
Route::get('produto/edita/{id}', 'ProdutoController@edit')->name('produtoedit');
Route::post('produto', 'ProdutoController@store')->name('produtostore');
Route::post('produto/edita/{id}', 'ProdutoController@update')->name('produtoupdate');

Route::get('compras', 'CompraController@index')->name('compra');
Route::post('compras', 'CompraController@index')->name('compra');
Route::get('compra/create', 'CompraController@create')->name('compracreate');
Route::get('compra/edita/{id}', 'CompraController@edit')->name('compraedit');
Route::get('compra/detalhe/{id}', 'CompraController@buscaprodutosparaadicionarnacompra')->name('comprashow');
Route::post('compra/addproduto/{id}', 'CompraController@add_produto')->name('addproduto');
Route::post('compra/concluir_compra/{id}', 'CompraController@concluir_compra')->name('concluir_compra');
Route::any('buscaprodutosparaadicionarnacompra/{idcompra}', 'CompraController@buscaprodutosparaadicionarnacompra')->name('buscaprodutosparaadicionarnacompra');
Route::post('compra', 'CompraController@store')->name('comprastore');
Route::post('compra/edita/{id}', 'CompraController@update')->name('compraupdate');
Route::get('datalhe/remove/{id}', 'CompraController@remove_detalhe')->name('remove_detalhe');


Route::get('caixas', 'CaixaController@index')->name('caixas');
Route::get('caixasabertos', 'CaixaController@caixasabertos')->name('caixasabertos');
Route::get('caixa/create', 'CaixaController@create')->name('caixacreate');
//Route::get('compra/edita/{id}', 'CompraController@edit')->name('compraedit');
Route::get('caixa/detalhe/{id}', 'CaixaController@detalhe')->name('caixashow');
Route::post('caixa/cad_entrada_valores', 'CaixaController@cad_entrada_valores')->name('cad_entrada_valores');
Route::post('caixa/cad_saida_valores', 'CaixaController@cad_saida_valores')->name('cad_saida_valores');
Route::post('caixa/fachar_caixa/{id}', 'CaixaController@fachar_caixa')->name('fecharcaixa');
Route::get('caixa/Form_cad_entrada_valores', 'CaixaController@Form_cad_entrada_valores')->name('Form_cad_entrada_valores');
Route::get('caixa/Form_cad_saida_valores', 'CaixaController@Form_cad_saida_valores')->name('Form_cad_saida_valores');
Route::get('editaoutrasentradas/{idcompra}', 'CaixaController@editaoutrasentradas')->name('editaoutrasentradas');
Route::post('compra', 'CompraController@store')->name('comprastore');
Route::post('compra/edita/{id}', 'CompraController@update')->name('compraupdate');
Route::get('datalhe/remove/{id}', 'CompraController@remove_detalhe')->name('remove_detalhe');


//rotas para vendas
Route::get('vendas/{tipo}', 'vendaController@index')->name('venda');
Route::get('venda/create/{tipo}', 'vendaController@store')->name('vendacreate');
Route::get('venda/edita/{id}', 'VendaController@edit')->name('vendaedit');
Route::get('venda/detalhe/{id}', 'VendaController@show')->name('vendashow');
Route::post('venda/addproduto/{id}', 'VendaController@add_produto')->name('vendaaddproduto');
Route::post('venda/editaprodutovenda/{id}', 'VendaController@editaprodutovenda')->name('editaproduto');
Route::post('venda/concluir_venda/{id}', 'VendaController@concluir_venda')->name('concluir_venda');
Route::post('buscaprodutosparaadicionarnavenda/{idvenda}', 'VendaController@buscaprodutosparaadicionarnavenda')->name('buscaprodutosparaadicionarnavenda');
Route::post('venda/edita/{id}', 'VendaController@update')->name('compraupdate');
Route::get('detalhevenda/remove/{id}', 'vendaController@remove_detalhe')->name('remove_detalhevenha');
Route::get('venda/converte_orcamento_venda/{id}', 'vendaController@converte_orcamento_venda')->name('converte_orcamento_venda');
Route::get('vendas/abertas/{tipo}', 'vendaController@vendasabertas')->name('vendasabertas');
Route::get('imprimir/venda/{id}', 'vendaController@imprmivenda_orcamento')->name('imprimirvenda');
Route::get('venda/cancelar_venda/{id}', 'vendaController@cancelar_venda')->name('cancelar_venda');
Route::post('venda/fechar_venda/{id}', 'vendaController@fechar_venda')->name('fechar_venda');
Route::post('venda/reabrir_venda/{id}', 'vendaController@reabrir_venda')->name('reabrir_venda');


//rotas para clientes
Route::get('clientes', 'ClienteController@index')->name('clientes');
Route::post('clientes', 'ClienteController@index')->name('clientes');
Route::get('cliente/create', 'ClienteController@create')->name('cliente');
Route::post('cliente', 'ClienteController@store')->name('cliente');
Route::get('cliente/edita/{id}', 'ClienteController@edit')->name('clienteedit');
Route::post('cliente/edita/{id}', 'ClienteController@update')->name('clienteupdate');
Route::post('cliente/busca', 'ClienteController@busca')->name('clientebusca');

//rotas para categorias
Route::get('categorias', 'CategoriaController@index')->name('categorias');
Route::post('categorias', 'CategoriaController@index')->name('categorias');
Route::get('categoria/create', 'CategoriaController@create')->name('categoria');
Route::post('categoria', 'CategoriaController@store')->name('categoria');
Route::get('categoria/edita/{id}', 'CategoriaController@edit')->name('categoriaedit');
Route::post('categoria/edita/{id}', 'CategoriaController@update')->name('categoriaupdate');
Route::post('categoria/busca', 'CategoriaController@busca')->name('categoriabusca');


//rotas para fornecedores
Route::get('fornecedores', 'FornecedorController@index')->name('fornecedores');
Route::post('fornecedores', 'FornecedorController@index')->name('fornecedores');
Route::get('fornecedor/create', 'FornecedorController@create')->name('fornecedor');
Route::post('fornecedor', 'FornecedorController@store')->name('fornecedor');
Route::get('fornecedor/edita/{id}', 'FornecedorController@edit')->name('fornecedoredit');
Route::post('fornecedor/edita/{id}', 'FornecedorController@update')->name('fornecedorupdate');
Route::post('fornecedor/busca', 'FornecedorController@busca')->name('fornecedorbusca');

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CountryRequest;
class CountryController extends Controller
{
  /**
   * Retorna uma lista de países de acordo com os parâmetros.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
  }

  /**
   * Cria um novo país no banco de dados.
   *
   * @param  \App\Http\Requests\CountryRequest  $request
   * @return \Illuminate\Http\Response
   */
  public function store(CountryRequest $request)
  {
  }

  /**
   * Retorna um país pelo ID.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function show($id)
  {
  }

  /**
   * Atualiza um país existente no banco de dados através do ID.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, $id)
  {
    //
  }

  /**
   * Faz o soft delete de um país ou remove completamente ao utilizar o
   * parâmetro "$force" como verdadeiro.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
    //
  }
}

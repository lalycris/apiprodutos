<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use App\Produto;

class ProdutoController extends Controller
{
    public function __construct()
    {
        header('Acess-Control-Allow-Origin: *');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $produto = Produto::all();
        return response()->json(['data' => $produto], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $dados = $request->all();
        $produto = Produto::create($dados);
        try {
            $this->validate($request, ['descricao' => 'required']);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'O campo descricao é obrigatório.', 'status' => 500
            ]);
        }
        return response()->json($produto, 201);
    }

    /** Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        try {
            return Produto::findOrFail($id);
            // return response()->json($produto, 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([               
                'message' => 'O produto nao foi encontrado', 'status' => 404]);
        }
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        
        try {           
            $produto = Produto::find($id);
          
            $produto->fill($request->all());
            $produto->save();
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'O campo descricao é obrigatório.', 'status' => 500
            ]);
        }
       // 

        return response()->json(['message' => 'atualizado com sucesso!', 'status' => 200]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // quer tentar fazer esse ? 
        // vc precisa so retornar esse $produto 
        // return Produto::find($id);
        // e valida ro cath()
        // refaz as messagem que falta acento etc..

        try {
            //code...
            $produto = Produto::find($id);
            $produto->delete();
        } catch ( \Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            //throw $th;
            return response()->json(['message' => 'O'.$id.'nao existe!', 'status' => 404]);
        }
        return response()->json(['message'=> 'Produto removido com sucesso', 'status' => 200]);
      
    }
}

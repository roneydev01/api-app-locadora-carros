<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credenciais = $request->all(['email', 'password']);

        //Autenticação (emaile senha)
        $token = auth('api')->attempt($credenciais);

        if ($token) {//usuário autenticado com sucesso
            return response()->json(['token'=> $token]);
        } else {
            //401 = Unauthorized -> não autorizado
            //403 = forbidden -> proibido (login invalido)
            return response()->json(['erro'=>'Usuário e/ou senha inválido'], 403);
        }

    }

    public function me()
    {
        return response()->json(auth()->user());
    }

    public function refresh()
    {
        //O cliente precisar encaminhar um jwt válido
        $token = auth('api')->refresh();
        return response()->json(['token' => $token]);
    }

    public function logout()
    {
        //O cliente precisar encaminhar um jwt válido
        auth('api')->logout();
        return response()->json(['msg' => 'Logout realizado com sucesso.']);
    }
}

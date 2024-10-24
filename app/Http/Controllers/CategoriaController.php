<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Http\Request;
use App\Http\Resources\CtgCollection;

class CategoriaController extends Controller
{
    public function index()
    {
        //return response()->json(['categoria' => Categoria::all()])

        return new CtgCollection(Categoria::all());
    }
}

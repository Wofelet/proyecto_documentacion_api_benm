<?php

namespace App\Http\Controllers;
use OpenApi\Attributes as OA;


#[
    OA\Info(version:"1.0.0",description: "API Desarrollada por Briam Ernesto Navarro Menjivar, para la UFG", title:"Documentacion de API de Briam Ernesto Navarro Menjivar"),
    OA\Server(url:"http://localhost:8000",description:"Servidor Local de Desarrollo"),
    OA\Server(url:"http://localhost:8000",description:"Servidor para pruebas"),
    OA\Server(url:"http://localhost:8000",description:"Servidor de Producción"),
    OA\SecurityScheme(securityScheme:"bearerAuth",type:"http",name:"Authorization", in:"header",scheme:"bearer")

]
abstract class Controller
{
    //
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use OpenApi\Attributes as OA;
use App\Models\Persona;
use Exception;

class PersonaController extends Controller
{
    //
    /**
     * @OA\Get(
     *          path="/api/obtenerpersona/{id},
     *          tags={"Persona"},
     *          summary="Obtener un registro de persona",
     *          description="Con este EndPoint puede obtener los detalles de un registro de persona",
     *          security={
     *              {"bearer_token":{}}
     *          },
     *          @OA\Parameter(
     *              name="id",
     *              in="path",
     *              description="Buscar por ID de persona",
     *              required=true
     *          ),
     *          @OA\Parameter(
     *              name=Accept-Language",
     *              in="header",
     *              description="Parámetro de idioma, aplicar RFC2616",
     *              @OA\scheme(
     *                  type="string"
     *                  )
     *              ),
     *              @OA\Response(response="200",description="No hay error, se devolvieron los datos correctamente",
     *                  @OA\JsonContent(type="object",
     *                      @OA\Property(
     *                          property="id_persona",
     *                          type="integer",
     *                          example="1"
     *                  ),
     *                  @OA\Property(
     *                          property="nombres",
     *                          type="string",
     *                          example="Briam Ernesto"
     *                  ),
     *                  @OA\Property(
     *                  property="apellidos",
     *                  type="string",
     *                  example="Navarro Menjivar"
     *              ),
     *              @OA\Property(
     *                  property="fechanacimiento",
     *                  type="string",
     *                  example="2002-05-13"
     *              ),
     *              @OA\Property(
     *                  property="direccion",
     *                  type="string",
     *                  example="San Salvador, El Salvador"
     *              ),
     *          )
     *      ),
     *      @OA\Response(response="404", description="No se encontró la ruta del EndPoint",
     *          @OA\JsonContent(type="object",
     *              @OA\Property(
     *                  property="success",
     *                  type="boolean",
     *                  example="false"
     *              ),
     *              @OA\Property(
     *                  property="msg",
     *                  type="string",
     *                  example=""
     *              ),
     *              @OA\Property(
     *                  property="error",
     *                  type="string",
     *                  example="No se encontraron datos"
     *              ),
     *              @OA\Property(
     *                  property="cant",
     *                  type="integer",
     *                  example="0"
     *              )
     *          )
     *      )
     * )
     */


    public function obtener($id){
        $datos = Persona::where("id_persona",$id)->get();
        if($datos->isNotEmpty()){
           return response()->json($datos);
        }else{
           return response()->json(["success"=>false,"msg"=>"","error"=>"no se encontraron datos","cant"=>0],404);
        } 
    }

    /**
 * @OA\Post(
 *     path="/api/crearpersona",
 *     tags={"Persona"},
 *     summary="Crear una nueva persona",
 *     description="Crear una persona de acuerdo a parámetros específicos",
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"nom","ape","fnac","direcc"},
 *             @OA\Property(property="nom", type="string", example="Jaime Jeovanny"),
 *             @OA\Property(property="ape", type="string", example="Cortez Flores"),
 *			   @OA\Property(property="fnac", type="string", example="1985-09-02"),
 *			   @OA\Property(property="direcc", type="string", example="San Salvador, El Salvador")
 *         ),
 *     ),
  *     @OA\Response(response="200", description="No hay error, se han guardado los datos correctamente",
 *          @OA\JsonContent(type="object",
 *               @OA\Property(
 *                    property="success",
 *                    type="boolean",
 *                    example="true"
 *               ),
 *               @OA\Property(
 *                    property="msg",
 *                    type="string",
 *                    example="Datos guardados satisfactoriamente"
 *               ),
 *               @OA\Property(
 *                    property="error",
 *                    type="string",
 *                    example=""
 *               ),
  *               @OA\Property(
 *                    property="cant",
 *                    type="integer",
 *                    example="1"
 *               )
 *          )
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Error en la petición"
 *     )
 * )
 */


    public function guardar(Request $request){
		$Persona = new Persona();
		$Persona->nombres = $request["nom"];
		$Persona->apellidos = $request["ape"];
		$Persona->fecha_nacimiento = $request["fnac"];
		$Persona->direccion = $request["direcc"];
		$guardado = $Persona->save();
		if($guardado){
			return response()->json(["success"=>true,"msg"=>"Guardado satisfactoriamente","error"=>"","cant"=>1]);
		}else{
			return response()->json(["success"=>false,"msg"=>"","error"=>"No se pudo guardar la información","cant"=>0],500);
		}
	}


    public function actualizar(Request $request){
        $Persona = new Persona();
        $actualizados = $Persona::where('id_persona',$request->idper)->update(['direccion'=>$request->direcc]);
        if($actualizados){
            return response()->json(["success"=>true,"msg"=>"Actualizado correctamente","error"=>"","cant"=>1]);
        }else{
            return response()->json(["success"=>false,"msg"=>"","error"=>"No se pudo actualizar el registro","cant"=>0]);
        }
    }

    public function eliminar(Request $request){
        $Persona = new Persona();
        try{
            $eliminados = $Persona::where('id_persona',$request->idper)->delete();
            if($eliminados){
                return response()->json(["success"=>true,"msg"=>"Eliminado correctamente","error"=>"","cant"=>1]);
            }else{
                return response()->json(["success"=>false,"msg"=>"","error"=>"No se pudo eliminar el registro","cant"=>0]);
            }
        }catch(Exception $e){
            return response()->json(["success"=>false,"msg"=>"","error"=>"No se pudo eliminar el registro por la siguiente razón: ".$e->getMessage(),"cant"=>0]);
        }
    }
}

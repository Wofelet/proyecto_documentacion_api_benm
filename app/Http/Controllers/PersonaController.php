<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Persona;
use Exception;

class PersonaController extends Controller
{
    //
    public function obtener($id){
        $datos = Persona::where("id_persona",$id)->get();
        if($datos->isNotEmpty()){
           return response()->json($datos);
        }else{
           return response()->json(["success"=>false,"msg"=>"","error"=>"no se encontraron datos","cant"=>0],404);
        } 
    }


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

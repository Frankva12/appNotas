<?php
//Incluyendo parametros de conexion
include ("parametros.php");

//Iniciando la clase de conexion
class conexion{
    //Atributo
    private $con;

    //Metodo de conexion
    public function pdo(){
        try{
            //Procesos de conexion
            #Declaracion de variable objeto
            $connPDO = new PDO('mysql:host='.server.';dbname='.database,user,password);
        }catch(PDOException $e){
            //Captura de error de conexion
            echo "Se produjo un error: ".$e->getMessage();
            die();
        }finally{
            //Ejecucion de procesos al finalizar el programa
            $this->con = $connPDO;
            return $connPDO;
        }
    } //fin de pdo

    //Metodo para funciones de INSERT, UPDATE y DELETE
    public function EjecutarSQL($sql){
        $rs = $this->pdo()->exec($sql);
        return $rs; //Devuelve un int
    }

    //Funcion para consultas SELECT
    public function MostrarSQL($sql){
        $rs = $this->pdo()->query($sql);
        return $rs; //Devuelve una matriz de resultados
    }
} //Fin de clase conexion

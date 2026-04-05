<?php
    namespace Mgj\ProyectoBlog2025\Helpers;
    use Mgj\ProyectoBlog2025\Config\Parameters;

	class GoRoute{

        public static function save($controller, $action, $data=NULL){
            $_SESSION["lastPage"]["controller"] = $controller;
            $_SESSION["lastPage"]["action"] = $action;
            if ($data!=NULL) $_SESSION["lastPage"]["data"] = $data;            
        }

        public static function go(): void{
            $ruta = Parameters::$BASE_URL.$_SESSION["lastPage"]["controller"]."/".$_SESSION["lastPage"]["action"];
            
            if (isset($_SESSION["lastPage"]["data"])){
                $getParams = "?";
                foreach($_SESSION["lastPage"]["data"] as $key=>$value){
                    $getParams .= $key."=".$value."&";
                }
                $ruta .= $getParams;
            }

            header("location: $ruta");
        }
    }
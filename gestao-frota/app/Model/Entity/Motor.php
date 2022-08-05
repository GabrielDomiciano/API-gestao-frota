<?php

namespace App\Model\Entity;
use \WilliamCosta\DatabaseManager\Database;

/**
 * Classe responsável por gerenciar os models do motor
 */
class Motor{
    //ID DO MOTOR
    public $id;
    //DESC DO MOTOR
    public $descricaoMotor;
    //VALOR DO Motor
    public $tipoMotor;
    //DETALHE DO Motor
    public $potenciaMotor;
 
    /**
     * Método responsável por buscar todos os motores
     *
     */
    public static function getMotors($where = null, $order = null, $limit = null, $fields = '*'){
        return (new Database('motor'))->select($where, $order, $limit, $fields);
    }

    /**
     * Método responsável por cadastrar um motor
     */
    public function cadastrar(){
        $this->id = (new Database('motor'))->insert([
            'descricaoMotor' => $this->descricaoMotor,
            'tipoMotor' => $this->tipoMotor,
            'potenciaMotor' => $this->potenciaMotor     
        ]);
        return true;
    }

    /**
     * Método responsável por atualizar as informações do motor
     */
    public function atualizar(){
        return (new Database('motor'))->update('id = '.$this->id,[
            'descricaoMotor' => $this->descricaoMotor,
            'tipoMotor' => $this->tipoMotor,
            'potenciaMotor' => $this->potenciaMotor    
        ]);
    }

    /**
     * Método responsável por excluir um motor
     *
     */
    public function excluir(){
        return (new Database('motor'))->delete('id = '.$this->id);
    }

    /**
     * Método responsável por buscar um motor através do ID
     *
     * 
     */
    public static function getMotorById($id){
        return self::getMotors('id = '.$id)->fetchObject(self::class);
    }

}
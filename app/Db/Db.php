<?php

/**
 * Classe responsavel para conexão com o banco de dados
 */
class Db{
    private $table;
    private $connection;

    public function __construct($table = null){

			$this->table = $table;
			$this->setConnection();
		}

		/**
		 * Método responsavel para criar uma conexão com o banco de dados
		 */
		private function setConnection(){
			try{
				$this->connection = new PDO('mysql:host=localhost;dbname=pacientewdev', 'root', '');
				$this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			}catch(PDOException $e){
				die('ERROR' . $e->getMessage());
			}
		}

		public function execute($query, $params = []){
			try{
				$statement = $this->connection->prepare($query);
				$statement->execute($params);
				return $statement;
			} catch(PDOException $e){
				die('ERROR' . $e->getMessage());
			}
		}


		public function insert($values){
			// daddos da query
			$fields = array_keys($values);
			$binds = array_pad([], count($fields), '?');

			// monta a query
			// implde Junta os itens de um array e coloca em uma simples string

			$query = 'INSERT INTO '.$this->table.'('.implode(',', $fields).') VALUES ('.implode(',',$binds).')';

			// executa o insert
			$this->execute($query, array_values($values));

			// retorna o id inserido
			return $this->connection->lastInsertId();

		}

		public function select($where = null, $order = null, $limit = null, $fields = '*'){
			// dados da query
			$where = strlen($where) ? 'WHERE '.$where : '';
    		$order = strlen($order) ? 'ORDER BY '.$order : '';
    		$limit = strlen($limit) ? 'LIMIT '.$limit : '';

			// monta
			$query = 'SELECT '.$fields.' FROM '.$this->table.' '.$where.' '.$order.' '.$limit;
			//executa
			return $this->execute($query);
		}

		public function update($where,$values){
		    //DADOS DA QUERY
		    $fields = array_keys($values);

		    //MONTA A QUERY
		    $query = 'UPDATE '.$this->table.' SET '.implode('=?,',$fields).'=? WHERE '.$where;

		    //EXECUTAR A QUERY
		    $this->execute($query,array_values($values));

		    //RETORNA SUCESSO
		    return true;
  		}

  		public function delete($where){
  			// monta a query
  			$query = 'DELETE FROM '. $this->table. ' WHERE '.$where;

  			// excetuta a query
  			$this->execute($query);

  			// retorna sucesso
  			return true;

  		}

}

?>

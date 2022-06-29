<?php

class MySQLDC
{
	
	var $host = 'p:127.0.0.1';
	var $usr = 'root';
	var $pw = '';
	var $db = 'db_urua';
	var $sql; //Query
	var $conn; // Conexão ao banco
	var $resultado; // Resultado de uma consulta
	
	function MySQLDC(){}

	// Esta função conecta-se ao banco de dados e o seleciona.
	
	function connMySQL()
	
	{
		$this->conn = mysqli_connect($this->host, $this->usr, $this->pw, $this->db);
		
		mysqli_set_charset($this->conn, "utf8");
		
		if (! $this->conn) {
			
			echo "<p>Não foi possivel conectar-se ao servidor MySQL.</p>\n" .  "<p><strong>Erro MySQL: " . mysqli_connect_error() . "</strong></p>\n";
			exit();
		} elseif (! mysqli_select_db($this->conn, $this->db)){
			echo "<p>Não foi possivel selecionar o Banco de Dados desejado.</p>\n" . "</p><strong>Erro MySQL: " . mysqli_error($this->conn) . "</strong></p>\n" ;
			exit();
		}	
	}
	
		// Função para executar as Stored Procedures. Utiliza-se a Função mysqli_multi_query()
		//porque as SPs retornam mais de um conjunto de resultados e a Funlção mysqli_query() não consegue
		//trabalhar com respostas múltiplas, ocasionando eventuais erros.
		
		public function execSPForInsUpd($sql)
		
		{			
			$this->connMySQL();
			$this->sql = $sql;
			
			if (mysqli_multi_query($this->conn, $this->sql)) {
				
				$this->resultado = mysqli_store_result($this->conn);
				
				$row = mysqli_fetch_row($this->resultado);
				
				mysqli_free_result($this->resultado);
				
				while($this->conn->more_results() && $this->conn->next_result())
				{
					$extraResult = $this->conn ->use_result();
					if($extraResult instanceof mysqli_result){
						$extraResult->free();
					}
				}
				
				$this->closeConnMySQL();
				
				return $row[0];
				
			}else {
				echo"<p>Não foi possivel executar a seguinte instrução. SQL:</p><p><strong>$sql</p>\n" . "<p>Erro MySQL: " . mysqli_error ($this->conn) . "</p>";
				exit();
				$this->closeConnMySQL();
			}
		}
		// Função para executar as Stored Procedures. Utiliza-se a Função mysqli_multi_query()
		//porque as SPs retornam mais de um conjunto de resultados e a Funlção mysqli_query() não consegue
		//trabalhar com respostas múltiplas, ocasionando eventuais erros.
		public function execSPForDataSet($sql)
		{
			$this->connMySQL();
			
			$this->sql = $sql;
			
			$table_result=null;
			
			if(mysqli_multi_query($this->conn, $this->sql)){
				
				$this->resultado = mysqli_store_result($this->conn);
				
				while ($row = mysqli_fetch_assoc($this->resultado)){
					
					IF ($row)
						$table_result[] = $row;
				}
				mysqli_free_result($this->resultado);
				
				while($this->conn->more_results() && $this->conn->next_result())
				{
					$extraResult = $this->conn->use_result();
					if($extraResult instanceof mysqli_result){
						$extraResult->free();
					}
				}
				
				$this->closeConnMySQL();
				if(! $table_result)
					return null;
				else
					return $table_result;
			} else {
				echo "<p>Não foi possivel executar a seguinte instrução. SQL:</p><p><strong>$sql</p>\n" . "<p>Erro MySQL: " . mysqli_error ($this->conn) . "</p>";
				exit();
				$this->closeConnMySQL();
			}
		}
		
		//Função para encerramento da conexão com banco de dados.
		
		function closeConnMySQL()
		{
			$thread_id = mysqli_thread_id($this->conn);
			mysqli_kill($this->conn, $thread_id);
			return mysqli_close($this->conn);
		}
}

			//Finaliza a classe MySQL
			
?>
			
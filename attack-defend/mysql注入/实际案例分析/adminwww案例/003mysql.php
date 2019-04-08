<?php


	public function query($type, $sql, $as_object)
	{
		//根据是否为Select决定是调用主服务器，还是从服务器
		if ($type === Database::SELECT)
		{
			$name = $this->select_slave();
		}
		else
		{
			$name = Database::$default;
		}

		if ($this->_instance != $name)
		{
			$this->_connection = NULL;
			$this->_instance = $name;
			$this->_config = Difeye::config('database')->$name;
		}
		
		
		// Make sure the database is connected
		$this->_connection or $this->connect();

		if ( ! empty($this->_config['profiling']))
		{
			// Benchmark this query for the current instance
			$benchmark = Profiler::start("Database ({$this->_instance})", $sql);
		}

		if ( ! empty($this->_config['connection']['persistent']) AND $this->_config['connection']['database'] !== Database_MySQL::$_current_databases[$this->_connection_id])
		{
			// Select database on persistent connections
			$this->_select_db($this->_config['connection']['database']);
		}		
		// Execute the query
		if (($result = mysqli_query($this->_connection, $sql)) === FALSE)
		{
			if (isset($benchmark))
			{
				// This benchmark is worthless
				Profiler::delete($benchmark);
			}

			throw new Database_Exception(':error [ :query ]',
				array(':error' => mysqli_error($this->_connection), ':query' => $sql),
				mysqli_errno($this->_connection));
		}

		if (isset($benchmark))
		{
			Profiler::stop($benchmark);
		}

		// Set the last query
		$this->last_query = $sql;

		if ($type === Database::SELECT)
		{
			// Return an iterator of results
			return new Database_MySQL_Result($result, $sql, $as_object);
		}
		elseif ($type === Database::INSERT)
		{
			$this->sql_log($sql);
			// Return a list of insert id and rows created
			return array(
				mysqli_insert_id($this->_connection),
				mysqli_affected_rows($this->_connection),
			);
		}
		else
		{
			$this->sql_log($sql);
			// Return the number of rows affected
			return mysqli_affected_rows($this->_connection);
		}
	}

?>
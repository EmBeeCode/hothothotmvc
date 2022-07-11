<?php

abstract class Model
{
    private ?PDO $connection = null;
    protected string $table;

    public function __construct()
    {
        $this->table = get_called_class() . 's';
    }
    /**
     * init or return PDO instance
     * 
     * @return PDO
     */
    private function getPDO(): PDO
    {
        if (!$this->connection) {
            $config = $this->parseConfig(Constants::SERVER_CONFIG);
            extract($config);

            try {
                $this->connection = new PDO($dsn, $user, $pass);
                $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $PDOError) {
                $PDOError->getMessage('La connexion à la base de données a échoué');
            }
        }
        return $this->connection;
    }

    /**
     * parse server config file
     *  
     * @param string $filepath
     * @return array contains $dsn, $user, $pass parsed from ini file
     */
    private function parseConfig(string $filepath): array
    {
        $server_config = parse_ini_file($filepath);
        $dsn = $server_config['type'] . ":host=" . $server_config['host'] . ";dbname=" . $server_config['database'] . ';charset=UTF8';
        $user = $server_config['user'];
        $pass = $server_config['password'];

        return compact('dsn', 'user', 'pass');
    }

    /**
     * prepare and execute an SQL query
     * 
     * @param string $sql 
     * @param array $params associative array of parameters
     * @return PDOStatement 
     */
    protected function executeQuery(string $sql, array $params = null): PDOStatement
    {
        $statement = $this->getPDO()->prepare($sql);
        $statement->execute($params);

        return $statement;
    }

    /**
     * return last inserted id
     * 
     * 
     */
    public function returnLastId(): string|false
    {
        return $this->getPDO()->lastInsertId();
    }

    /**
     * fetch web API from url
     * 
     * @param string $url url of the API
     * @return array wraped json 
     */
    protected function fetchWebAPI(string $url): array|bool
    {
        /* stream context options */
        $options = array(
            'http' => array(
                'header'     => 'Connection: close',
                'user_agent' => "Mozilla/5.0 (Windows; U; Windows NT 6.0; en-GB; rv:1.9.0.3) Gecko/2008092417 Firefox/3.0.3",
                'method'     => "GET",
                'timeout'    =>  10,
            ),
        );
        $context = stream_context_create($options);
        $json    = file_get_contents($url, false, $context);

        if ($json === false) {
            return false;
        } else {
            $json    = json_decode($json, true);
            return $json;
        }
    }
}

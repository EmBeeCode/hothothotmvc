<?php

class Sensor extends Model
{
    /**
     * wrap all sensors data 
     * 
     * 
     * @return array sensors data 
     */
    public function wrapAll(): array
    {
        $statement = $this->selectAll();
        $sensors   = array();
        while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
            $url      = $row['url'];
            $api_data = $this->fetchAllAPIData($url);

            $sensor   = array(
                'db_data' => $row,
                'api_data' => $api_data
            );
            array_push($sensors, $sensor);
        }
        return $sensors;
    }

    /**
     * wrap specified sensor data
     * 
     * 
     * @return array sensor data
     */
    public function wrap(string $id): array
    {
        $statement  = $this->select($id);
        $db_data    = $statement->fetch(PDO::FETCH_ASSOC);
        $url        = $db_data['url'];
        $api_data   = $this->fetchAllAPIData($url);

        return compact('db_data', 'api_data');
    }

    /**
     * fetch sensors web API
     * 
     * @param string $url 
     * @return array data
     */
    public function fetchAllAPIData(string $url): array
    {
        $json = $this->fetchWebAPI($url);
        if ($json === false) {
            return false;
        }
        return $json['capteurs'][0];
    }

    /**
     * query all sensors data
     * 
     * 
     * @return PDOStatement
     */
    private function selectAll(): PDOStatement
    {
        $sql = "SELECT * FROM $this->table";

        $statement = $this->executeQuery($sql);
        return $statement;
    }

    /**
     * query data of one sensor
     * 
     * @param string $id
     * @return PDOStatement
     */
    private function select(string $id): PDOStatement
    {
        $sql = "SELECT * FROM $this->table
                WHERE id = :id";

        $data = array('id' => $id);

        $statement = $this->executeQuery($sql, $data);
        return $statement;
    }

    /**
     * update database with given URL in $_POST
     * 
     * @return bool return false when url is wrong
     */
    public function update(): bool
    {
        $sql = "UPDATE $this->table 
                SET 
                    name = :name,
                    type = :type,
                    url =  :url
                WHERE id = :id";

        $url = $_POST['url'];
        $sensor = $this->fetchAllAPIData($url);

        if (!$sensor || !$sensor['Nom']) {
            return false;
        }

        switch ($sensor['Nom']) {
            case 'interieur':
                $sensor['Nom'] = 'Intérieur';
                break;
            case 'exterieur':
                $sensor['Nom'] = 'Extérieur';
                break;
            default:
                break;
        }

        $data = array(
            'name' => $sensor['Nom'],
            'type' => $sensor['type'],
            'url'  => $_POST['url'],
            'id'   => $_GET['id'],
        );

        $this->executeQuery($sql, $data);
        return true;
    }

    /**
     * create a sensor
     * 
     * @return bool return false when url is wrong
     */
    public function create(): bool
    {
        $sql = "INSERT INTO $this->table (name, type, url)
                    VALUES
                        (:name, :type, :url)";

        $url = $_POST['url'];

        $sensor = $this->fetchAllAPIData($url);

        if (!$sensor || !$sensor['Nom']) {
            return false;
        }

        switch ($sensor['Nom']) {
            case 'interieur':
                $sensor['Nom'] = 'Intérieur';
                break;
            case 'exterieur':
                $sensor['Nom'] = 'Extérieur';
                break;
            default:
                break;
        }
        $data = array(
            'name' => $sensor['Nom'],
            'type' => $sensor['type'],
            'url'  => $_POST['url']
        );

        $this->executeQuery($sql, $data);
        return true;
    }

    /**
     * delete a sensor
     * 
     * @param string $id 
     */
    public function delete(string $id): void
    {
        $sql = "DELETE FROM $this->table
                WHERE id = :id";

        $data = array(':id' => $_GET['id']);

        $this->executeQuery($sql, $data);
    }

    /**
     * wrap and store data in sensor_data table
     * 
     * 
     */
    public function storeData(): void
    {
        $sql = "INSERT INTO data_sensor (value, timestamp, sensor_id)
                    VALUES 
                        (:value, :timestamp, :id)";

        $sensors = $this->wrapAll();

        foreach ($sensors as $sensor) {

            $value     = $sensor['api_data']['Valeur'];
            $value     = floatval($value);

            $timestamp = $sensor['api_data']['Timestamp'];
            $timestamp = date("Y-m-d H:i:s", $timestamp);

            $id        = $sensor['db_data']['id'];
            $id        = intval($id);

            $data      = compact('value', 'timestamp', 'id');

            $this->executeQuery($sql, $data);
        }
    }


    public function fetchAll($url)
    {
        $name      = $this->fetchName($url);
        $type      = $this->fetchType($url);
        $timestamp = $this->fetchTimestamp($url);
    }

    public function fetchValue(string $url)
    {
        $json = $this->fetchWebAPI($url);
        return $json['capteurs'][0]['Valeur'];
    }

    public function fetchTimestamp(string $url)
    {
        $json = $this->fetchWebAPI($url);
        return $json['capteurs'][0]['Timestamp'];
    }

    public function fetchType(string $url)
    {
        $json = $this->fetchWebAPI($url);
        return $json['capteurs'][0]['Type'];
    }

    public function fetchName(string $url)
    {
        $sensor = $this->fetchWebAPI($url);

        $name = $sensor['capteurs'][0]['Nom'];

        switch ($name) {
            case 'interieur':
                $name = 'Intérieur';
                break;
            case 'exterieur':
                $name = 'Extérieur';
                break;
            default:
                break;
        }
        return $name;
    }

    // public function create()
    // {
    //     $sql = "INSERT INTO $this->table (name, type, url)
    //                 VALUES
    //                     (:name, :type, :url)";

    //     $url = $_POST['url'];

    //     if ($this->controlURL($url)); {
    //         $data = array(
    //             'name' => $this->fetchName(),
    //             'type' => $this->fetchType(),
    //             'url'  => $_POST['url']
    //         );
    //         $this->executeQuery($sql, $data);
    //     } else {
    //         return false;
    //     }
        
    // }
}

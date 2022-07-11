<?php 

class Chart extends Model 
{
    /**
     * retrieve data_sensors data
     * 
     * 
     * 
     */
    public function getDbHistory()
    {
        $sql = "SELECT sensors.name, data_sensor.value, data_sensor.timestamp FROM sensors
        INNER JOIN data_sensor ON data_sensor.sensor_id = sensors.id";
        

        $statement = $this->executeQuery($sql);
        $sensors_history = $statement->fetchAll(PDO::FETCH_ASSOC);
        
        return $sensors_history;
    }

}
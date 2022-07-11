<?php

class ControllerSensors extends Controller
{
    private Sensor $sensor_model;

    public function __construct()
    {
        $this->sensor_model = new Sensor();
    }

    /**
     * insert sensor data in database
     * 
     * 
     */
    public function createAction(): void
    {
        $sensor = $this->sensor_model->create();

        if ($sensor === false) {
            $message = 'URL invalide';
        } else {
            $id = $this->sensor_model->returnLastId();
            $sensor = $this->sensor_model->wrap($id);
            $message = "Capteur {$sensor['db_data']['name']} créé";
        }

        $data = array(
            'head_title' => 'Création',
            'message' => $message
        );
        $this->render('template', 'standard/message', $data);
    }

    /**
     * update sensor in database
     * 
     * 
     * 
     */
    public function updateAction(string $id): void
    {
        $sensor = $this->sensor_model->update($id);
        if ($sensor === false) {
            $message = 'URL invalide';
        } else {
            $message = 'Modification prise en compte';
        }

        $data = array(
            'head_title' => 'Modification',
            'message' => $message
        );

        $this->render('template', 'standard/message', $data);
    }

    /**
     * delete sensor from database
     * 
     * 
     * 
     */
    public function deleteAction(string $id): void
    {
        $sensor = $this->sensor_model->wrap($id);
        $data = array(
            'head_title' => 'Suppression',
            'message' => 'Capteur ' . $sensor['db_data']['name'] . ' supprimé'
        );

        $this->render('template', 'standard/message', $data);
        $this->sensor_model->delete($id);
    }

    /**
     * store values data from sensors API in database 
     * 
     * 
     * 
     */
    public function storeAction(): void
    {
        $this->sensor_model->storeData();
        $data = array(
            'head_title' => 'Sauvegarde',
            'message' => 'Sauvegarde effectuée'
        );
        $this->render('template', 'standard/message', $data);
    }
}

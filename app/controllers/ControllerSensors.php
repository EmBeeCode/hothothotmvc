<?php

final class ControllerSensors extends Controller
{
    private Sensor $sensor_model;

    public function __construct()
    {
        $this->sensor_model = new Sensor();
    }

    /**
     * render home page
     * 
     * 
     * 
     */
    public function defaultAction(): void
    {
        $sensor_model = new Sensor();
        $chart_model = new Chart();

        $sensors = $sensor_model->wrapAll();
        $sensors_history = $chart_model->getDbHistory();

        $data = array(
            'head_title' => "Vos Capteurs",
            'sensors' => $sensors,
            'sensors_history' => $sensors_history
        );

        $this->render('template', 'sensor/home', $data);
    }

    /**
     * render edit page
     * 
     * 
     * 
     */
    public function editAction(string $id): void
    {
        $sensor_model = new Sensor();

        $data = array(
            'head_title' => "Edition capteur",
            'sensor' => $sensor_model->wrap($id),
            'action' => 'update'
        );

        $this->render('template', 'sensor/edit', $data);
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

    /**
     * render creation page
     * 
     * 
     * 
     */
    public function creationAction(): void
    {
        $data = array(
            'head_title' => "Creation capteur",
            'action' => 'create'
        );

        $this->render('template', 'sensor/edit', $data);
    }

}

<?php

final class ControllerPage extends Controller
{
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

    /**
     * render login page
     * 
     * 
     * 
     */
    public function loginAction()
    {
        $data = array(
            'head_title' => 'Login'
        );
        $this->render('login', '', $data);
    }
}

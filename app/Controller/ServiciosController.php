<?php
/**
 * Controlador de la Clase Servicio
 *
 * @author alfonso_fer
 */
 class ServiciosController extends AppController {
     // Opciones de paginación por defecto:
    public $paginate = array(
        'limit' => 30,
        'order' => array('Servicio.descripcion' => 'asc')
    );

    // Autorización de servicios
    public function isAuthorized($user) {
        // Comprobamos el rol del usuario
        if (isset($user['role'])) {
            $rol = $user['role'];
            // Acciones por defecto
            $accPerm = array();
            if ($rol == 'colab') {
                $accPerm = array(
                    'index', 'importar',
                );
            }
            elseif ($rol == 'consum') {
                $accPerm = array('index');
            }
            if (in_array($this->action, $accPerm)) {
                return true;
            }
            else{
                return parent::isAuthorized($user);
            }
        }
    }

    public function importar(){
        // Fijamos el título de la vista
        $this->set('title_for_layout', __('Importar Servicios de Telecomunicaciones'));
        // Buscamos los emplazamientos
        $this->Servicio->Emplazamiento->recursive = -1;
        $emplazamientos = $this->Servicio->Emplazamiento->find('all', array('order' => 'Emplazamiento.centro'));
        $servicios = array();
        $tiposerv = array(1 => 'comdes', 2 => 'tdt-gva', 4 => 'rtvv');
        foreach ($emplazamientos as $emplazamiento) {
            $centro = $emplazamiento['Emplazamiento']['centro'];
            foreach ($tiposerv as $servindex => $servnom) {
                $servicio = array();
                if ($emplazamiento['Emplazamiento'][$servnom] == 'SI'){
                    $servicio ['servtipo_id'] = $servindex;
                    $servicio ['descripcion'] = 'Servicio' . ' ' . strtoupper($servnom) . ' de ' . $centro;
                    $servicio ['emplazamiento_id'] = $emplazamiento['Emplazamiento']['id'];
                    $servicios[] = $servicio;
                }
            }
        }
        $this->set('servicios', $servicios);
        if ($this->request->is('post') || $this->request->is('put')) {
            $nserv = count($servicios);
            $this->Servicio->create();
            if ($this->Servicio->saveAll($servicios)){
                $this->Flash->exito(__('Importados correctamente') . ' ' . $nserv . ' ' . __('Servicios') . '.');
                $this->redirect(array('controller' => 'servicios', 'action' => 'importar'));
            }
            else{
                $this->Flash->error(__('Error al guardar los servicios'));
                $this->redirect(array('controller' => 'servicios', 'action' => 'importar'));
            }
        }
    }
 }
 ?>

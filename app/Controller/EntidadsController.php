<?php
/**
* Controlador de la Clase Entidad
*
* @author alfonso_fer
*/
class EntidadsController extends AppController {
    // Opciones de paginación por defecto:
    public $paginate = array(
        'limit' => 30,
        'order' => array('Entidad.enttipo_id' => 'asc', 'Entidad.nombre' => 'asc')
    );

    // Autorización:
    public function isAuthorized($user) {
        // Comprobamos el rol del usuario
        if (isset($user['role'])) {
            $rol = $user['role'];
            // Acciones por defecto
            $accPerm = array();
            if ($rol == 'colab') {
                $accPerm = array(
                    'index', 'detalle', 'editar', 'xlsexportar', 'agregar', 'borrar'
                );
            }
            elseif ($rol == 'consum') {
                $accPerm = array('index', 'detalle',);
            }
            if (in_array($this->action, $accPerm)) {
                return true;
            }
            else{
                return parent::isAuthorized($user);
            }
        }
    }

    public function index() {
        // Fijamos el título de la vista
        $this->set('title_for_layout', __('Entidades de Telecomunicaciones'));

        // Select de Tipos de entidad:
        $this->Entidad->Enttipo->recursive = -1;
        $opciones = array(
            'fields' => array('Enttipo.id', 'Enttipo.tipo'),
            'order' => 'Enttipo.id'
        );
        $this->set('enttipos', $this->Entidad->Enttipo->find('list', $opciones));

        // Select de Provincias:
        $opciones = array(
            'fields' => array('Entidad.provincia', 'Entidad.provincia'),
            'order' => 'Entidad.provincia',
            'group' => 'Entidad.provincia'
        );
        $this->set('provincias', $this->Entidad->find('list', $opciones));

        // Comprobamos si hemos recibido datos del formulario:
        $condiciones = array();
        if ($this->request->is('post')){
            // Select de tipo de entidad
            if (!empty($this->request->data['Entidad']['enttipo_id'])){
                $addcond = array('Entidad.enttipo_id'  => $this->request->data['Entidad']['enttipo_id']);
                $condiciones = array_merge($addcond, $condiciones);
            }
            // Input de Nombre
            if (!empty($this->request->data['Entidad']['nombre'])){
                $addcond = array('Entidad.nombre LIKE'  => '%' . $this->request->data['Entidad']['nombre'] . '%');
                $condiciones = array_merge($addcond, $condiciones);
            }
            // Select de Provincia
            if (!empty($this->request->data['Entidad']['provincia'])){
                $addcond = array('Entidad.provincia'  => $this->request->data['Entidad']['provincia']);
                $condiciones = array_merge($addcond, $condiciones);
            }
            // Cambio de página
            if (!empty($this->request->data['Entidad']['irapag'])&&($this->request->data['Entidad']['irapag'] > 0)){
                $this->paginate['page'] = $this->request->data['Entidad']['irapag'];
            }
            // Tamaño de página
            if (!empty($this->request->data['Entidad']['tampag'])&&($this->request->data['Entidad']['tampag'] > 0)){
                $this->paginate['limit'] = $this->request->data['Entidad']['tampag'];
            }
        }
        $this->paginate['conditions'] = $condiciones;
        $entidades = $this->paginate();
        $this->set('entidades', $entidades);
    }

    public function detalle ($id = null){
        // Fijamos el título de la vista
        $this->set('title_for_layout', __('Entidad de Telecomunicaciones'));
        $this->Entidad->id = $id;
        if (!$this->Entidad->exists()) {
            throw new NotFoundException(__('Error: la entidad seleccionada no existe'));
        }
        $entidad = $this->Entidad->read(null, $id);
        $this->set('entidad', $entidad);
    }

    public function editar ($id = null){
        // Fijamos el título de la vista
        $this->set('title_for_layout', __('Modifcar Entidad'));
        $this->Entidad->id = $id;
        if (!$this->Entidad->exists()) {
            throw new NotFoundException(__('Error: la entidad seleccionada no existe'));
        }
        // Lista de Provincias:
        $provcv = array('03' => 'Alicante/Alacant', '12' => 'Castellón/Castelló', '46' => 'Valencia/València');
        if ($this->request->is('post') || $this->request->is('put')) {
            // Comprobamos el municipio:
            if (!empty($this->request->data['Entidad']['municipio_id'])){
                $indprov = substr($this->request->data['Entidad']['municipio_id'], 0, 2);
                $this->request->data['Entidad']['provincia'] = $provcv[$indprov];
                $this->request->data['Entidad']['municipio'] = '';
            }
            else{
                $this->request->data['Entidad']['municipio_id'] = '';
            }
            // Guardamos los datos:
            if ($this->Entidad->save($this->request->data)) {
                $this->Flash->exito(__('Entidad modificada correctamente'));
                $this->redirect(array('controller' => 'entidads', 'action' => 'detalle', $id));
            }
        }
        else{
            // Select de Tipos de entidad:
            $this->Entidad->Enttipo->recursive = -1;
            $opciones = array(
                'fields' => array('Enttipo.id', 'Enttipo.tipo'),
                'order' => 'Enttipo.id'
            );
            $this->set('enttipos', $this->Entidad->Enttipo->find('list', $opciones));

            // Select de Municipio:
            $this->Entidad->Municipio->recursive = -1;
            $opciones = array(
                'fields' => array('Municipio.id', 'Municipio.nombre'),
                'order' => 'Municipio.nombre',
                'conditions' => array('Municipio.cpro' => array('03', '12', '46'))
            );
            $this->set('selmuni', $this->Entidad->Municipio->find('list', $opciones));
            // Lista de Provincias:
            $this->set('provcv', $provcv);
            // Datos de la entidad
            $this->request->data = $this->Entidad->read(null, $id);
        }
    }

    public function agregar (){
        // Fijamos el título de la vista
        $this->set('title_for_layout', __('Agregar Entidad'));
        // Lista de Provincias:
        $provcv = array('03' => 'Alicante/Alacant', '12' => 'Castellón/Castelló', '46' => 'Valencia/València');
        if ($this->request->is('post') || $this->request->is('put')) {
            $this->Entidad->create();
            // Comprobamos el municipio:
            if (!empty($this->request->data['Entidad']['municipio_id'])){
                $indprov = substr($this->request->data['Entidad']['municipio_id'], 0, 2);
                $this->request->data['Entidad']['provincia'] = $provcv[$indprov];
                $this->request->data['Entidad']['municipio'] = '';
            }
            else{
                $this->request->data['Entidad']['municipio_id'] = '';
            }
            // Guardamos los datos:
            if ($this->Entidad->save($this->request->data)) {
                $this->Flash->exito(__('Entidad modificada correctamente'));
                $this->redirect(array('controller' => 'entidads', 'action' => 'detalle', $this->Entidad->id));
            }
        }
        else{
            // Select de Tipos de entidad:
            $this->Entidad->Enttipo->recursive = -1;
            $opciones = array(
                'fields' => array('Enttipo.id', 'Enttipo.tipo'),
                'order' => 'Enttipo.id'
            );
            $this->set('enttipos', $this->Entidad->Enttipo->find('list', $opciones));

            // Select de Municipio:
            $this->Entidad->Municipio->recursive = -1;
            $opciones = array(
                'fields' => array('Municipio.id', 'Municipio.nombre'),
                'order' => 'Municipio.nombre',
                'conditions' => array('Municipio.cpro' => array('03', '12', '46'))
            );
            $this->set('selmuni', $this->Entidad->Municipio->find('list', $opciones));
            // Lista de Provincias:
            $this->set('provcv', $provcv);
        }
    }

    public function borrar($id = null){
        if ($this->request->is('post') || $this->request->is('put')) {
            $this->Entidad->id = $id;
            if (!$this->Entidad->exists()) {
                throw new NotFoundException(__('Error: la entidad seleccionada no existe'));
            }
            // Buscamos los datos del Múltiple:
            if ($this->Entidad->delete()) {
                $this->Flash->exito(__('Entidad eliminada correctamente'));
                $this->redirect(array('controller' => 'entidads', 'action' => 'index'));
            }
            else{
                $this->Flash->error(__('Error al eliminar la entidad'));
            }
        }
        else{
            // Error
            throw new MethodNotAllowedException();
        }
   }

   public function xlsexportar () {
       // Buscamos los emplazamientos
       $entidades = $this->Entidad->find('all', array('order' => array('Entidad.enttipo_id' => 'asc', 'Entidad.nombre' => 'asc')));
       $this->set('entidades', $entidades);

       // Definimos la vista
       $this->render('xlsexportar', 'xls');
   }
}
?>

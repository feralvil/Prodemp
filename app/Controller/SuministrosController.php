<?php
/**
 * Controlador de la Clase Suministro
 *
 * @author alfonso_fer
 */

 class SuministrosController extends AppController {
     // Opciones de paginación por defecto:
     public $paginate = array(
         'limit' => 30,
         'order' => array('Suministro.emplazamiento_id' => 'asc')
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
                 $accPerm = array('index', 'detalle');
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
         $this->set('title_for_layout', __('Suministros de Emplazamientos de Telecomunicaciones'));

         // Select de Emplazamientos:
         $opciones = array(
             'fields' => array('Emplazamiento.id', 'Emplazamiento.centro'),
             'order' => 'Emplazamiento.centro',
         );
         $emplazamientos = $this->Suministro->Emplazamiento->find('list', $opciones);
         $this->set('emplazamientos', $emplazamientos);

         // Select de Titulares y proveedores:
         $this->loadModel('Entidad');
         $opciones = array(
             'fields' => array('Suministro.titular'),
             'order' => 'Suministro.titular',
             'group' => 'Suministro.titular'
         );
         $titbbdd = $this->Suministro->find('list', $opciones);
         $titulares = array();
         foreach ($titbbdd as $idtitular) {
             $opciones = array('fields' => array('Entidad.nombre'));
             $entidad = $this->Entidad->read(null, $idtitular);
             $titulares[$idtitular] = $entidad['Entidad']['nombre'];
         }
         $this->set('titulares', $titulares);
         $opciones = array(
             'fields' => array('Suministro.proveedor'),
             'order' => 'Suministro.proveedor',
             'group' => 'Suministro.proveedor'
         );
         $provbbdd = $this->Suministro->find('list', $opciones);
         $proveedores = array();
         foreach ($provbbdd as $idprov) {
             if ($idprov > 0){
                 $opciones = array('fields' => array('Entidad.nombre'));
                 $entidad = $this->Entidad->read(null, $idprov);
                 $proveedores[$idprov] = $entidad['Entidad']['nombre'];
             }
         }
         $this->set('proveedores', $proveedores);

         // Comprobamos si hemos recibido datos del formulario:
         $condiciones = array();
         if ($this->request->is('post')){
             // Select de Emplazamiento
             if (!empty($this->request->data['Suministro']['emplazamiento_id'])){
                 $addcond = array('Suministro.emplazamiento_id'  => $this->request->data['Suministro']['emplazamiento_id']);
                 $condiciones = array_merge($addcond, $condiciones);
             }
             // Select de Titular
             if (!empty($this->request->data['Suministro']['titular'])){
                 $addcond = array('Suministro.titular'  => $this->request->data['Suministro']['titular']);
                 $condiciones = array_merge($addcond, $condiciones);
             }
             // Select de Proveedor
             if (!empty($this->request->data['Suministro']['proveedor'])){
                 $addcond = array('Suministro.proveedor'  => $this->request->data['Suministro']['proveedor']);
                 $condiciones = array_merge($addcond, $condiciones);
             }
             // Cambio de página
             if (!empty($this->request->data['Suministro']['irapag'])&&($this->request->data['Suministro']['irapag'] > 0)){
                 $this->paginate['page'] = $this->request->data['Suministro']['irapag'];
             }
             // Tamaño de página
             if (!empty($this->request->data['Suministro']['regPag'])&&($this->request->data['Suministro']['regPag'] > 0)){
                 $this->paginate['limit'] = $this->request->data['Suministro']['regPag'];
             }
         }
         $this->paginate['conditions'] = $condiciones;
         $suministros = $this->paginate();
         $this->set('suministros', $suministros);
     }

     public function detalle ($id = null){
         // Fijamos el título de la vista
         $this->set('title_for_layout', __('Suministro de Emplazamiento de Telecomunicaciones'));
         $this->Suministro->id = $id;
         if (!$this->Suministro->exists()) {
             throw new NotFoundException(__('Error: el suministro seleccionado no existe'));
         }
         $suministro = $this->Suministro->read(null, $id);
         $this->set('suministro', $suministro);
     }

     public function agregar($idemp = null){
         if ($this->request->is('post') || $this->request->is('put')) {
             // Guardamos los datos:
             $this->Suministro->create();
             if ($this->Suministro->save($this->request->data)) {
                 $this->Flash->exito(__('Suministro creado correctamente'));
                 $this->redirect(array('controller' => 'suministros', 'action' => 'index'));
             }
             else {
                 $menserror = __('Error al crear el suministro');
                 if (!empty($this->Suministro->validationErrors)){
                     if (!empty($this->Suministro->validationErrors['emplazamiento_id'])){
                         foreach ($this->Suministro->validationErrors['emplazamiento_id'] as $error) {
                             $menserror .= '. ' . $error;
                         }
                     }
                 }
                 $menserror .= '.';
                 $this->Flash->error($menserror);
                 $this->redirect($this->referer());
             }
         }
         else{
             $this->set('title_for_layout', __('Nuevo Suministro de Emplazamiento de Telecomunicaciones'));
             $this->set('idemp', $idemp);
             // Select de Emplazamientos:
             $opciones = array(
                 'fields' => array('Emplazamiento.id', 'Emplazamiento.centro'),
                 'order' => 'Emplazamiento.centro',
             );
             $emplazamientos = $this->Suministro->Emplazamiento->find('list', $opciones);
             $this->set('emplazamientos', $emplazamientos);
             // Select de Titulares y proveedores:
             $this->loadModel('Entidad');
             $opciones = array(
                 'fields' => array('Entidad.id', 'Entidad.nombre'),
                 'order' => 'Entidad.nombre',
             );
             $titulares = $this->Entidad->find('list', $opciones);
             $this->set('titulares', $titulares);
             $opciones = array(
                 'fields' => array('Entidad.id', 'Entidad.nombre'),
                 'order' => 'Entidad.nombre',
                 'conditions' => array('Entidad.enttipo_id' => 6),
             );
             $proveedores = $this->Entidad->find('list', $opciones);
             $this->set('proveedores', $proveedores);
         }
     }

     public function editar($id = null){
         $this->Suministro->id = $id;
         if (!$this->Suministro->exists()) {
             throw new NotFoundException(__('Error: el suministro seleccionado no existe'));
         }
         if ($this->request->is('post') || $this->request->is('put')) {
             // Guardamos los datos:
             if ($this->Suministro->save($this->request->data)) {
                 $this->Flash->exito(__('Suministro modificado correctamente'));
                 $this->redirect(array('controller' => 'suministros', 'action' => 'detalle', $id));
             }
             else {
                 $menserror = __('Error al crear el suministro');
                 if (!empty($this->Suministro->validationErrors)){
                     if (!empty($this->Suministro->validationErrors['emplazamiento_id'])){
                         foreach ($this->Suministro->validationErrors['emplazamiento_id'] as $error) {
                             $menserror .= '. ' . $error;
                         }
                     }
                 }
                 $menserror .= '.';
                 $this->Flash->error($menserror);
                 $this->redirect($this->referer());
             }
         }
         else{
             $this->set('title_for_layout', __('Nuevo Suministro de Emplazamiento de Telecomunicaciones'));
             // Select de Emplazamientos:
             $opciones = array(
                 'fields' => array('Emplazamiento.id', 'Emplazamiento.centro'),
                 'order' => 'Emplazamiento.centro',
             );
             $emplazamientos = $this->Suministro->Emplazamiento->find('list', $opciones);
             $this->set('emplazamientos', $emplazamientos);
             // Select de Titulares y proveedores:
             $this->loadModel('Entidad');
             $opciones = array(
                 'fields' => array('Entidad.id', 'Entidad.nombre'),
                 'order' => 'Entidad.nombre',
             );
             $titulares = $this->Entidad->find('list', $opciones);
             $this->set('titulares', $titulares);
             $opciones = array(
                 'fields' => array('Entidad.id', 'Entidad.nombre'),
                 'order' => 'Entidad.nombre',
                 'conditions' => array('Entidad.enttipo_id' => 6),
             );
             $proveedores = $this->Entidad->find('list', $opciones);
             $this->set('proveedores', $proveedores);
             $this->request->data = $this->Suministro->read(null, $id);
         }
     }

     public function borrar($id = null){
         if ($this->request->is('post') || $this->request->is('put')) {
             $this->Suministro->id = $id;
             if (!$this->Suministro->exists()) {
                 throw new NotFoundException(__('Error: el suministro seleccionado no existe'));
             }
             // Buscamos los datos del Múltiple:
             if ($this->Suministro->delete()) {
                 $this->Flash->exito(__('Suministro eliminado correctamente'));
                 $this->redirect(array('controller' => 'suministros', 'action' => 'index'));
             }
             else{
                 $this->Flash->error(__('Error al eliminar el suministro'));
             }
         }
         else{
             // Error
             throw new MethodNotAllowedException();
         }
    }

    public function xlsexportar () {
        // Buscamos los emplazamientos
        $suministros = $this->Suministro->find('all', array('order' => 'Suministro.emplazamiento_id'));
        $this->set('suministros', $suministros);

        // Definimos la vista
        $this->render('xlsexportar', 'xls');
    }


 }
?>

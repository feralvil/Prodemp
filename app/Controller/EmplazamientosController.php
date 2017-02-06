<?php
/**
 * Controlador de la Clase Emplazamiento
 *
 * @author alfonso_fer
 */
class EmplazamientosController extends AppController {
    // Opciones de paginación por defecto:
    public $paginate = array(
        'limit' => 30,
        'order' => array('Emplazamiento.centro' => 'asc')
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
                    'index', 'detalle', 'editar', 'xlsexportar',
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
        $this->set('title_for_layout', __('Emplazamientos de Telecomunicaciones de la Comunitat'));

        // Select de Provincias:
        $this->Emplazamiento->Municipio->recursive = -1;
        $opciones = array(
            'fields' => array('Municipio.cpro', 'Municipio.provincia'),
            'order' => 'Municipio.provincia'
        );
        $this->set('provincias', $this->Emplazamiento->Municipio->find('list', $opciones));

        // Select de Comarcas:
        $this->Emplazamiento->Comarca->recursive = -1;
        $opciones = array(
            'fields' => array('Comarca.id', 'Comarca.comarca'),
            'order' => 'Comarca.comarca'
        );
        if (!empty($this->request->data['Emplazamiento']['provincia'])){
            $opciones['conditions'] = array('Comarca.provincia' => $this->request->data['Emplazamiento']['provincia']);
        }
        $this->set('comarcas', $this->Emplazamiento->Comarca->find('list', $opciones));

        // Select de Titulares:
        $opciones = array(
            'fields' => array('Emplazamiento.entidad_id'),
            'order' => 'Emplazamiento.entidad_id',
            'group' => 'Emplazamiento.entidad_id'
        );
        $titulares = $this->Emplazamiento->find('list', $opciones);
        $titsel = array();
        foreach ($titulares as $titular){
            $this->Emplazamiento->Entidad->recursive = -1;
            $entidad = $this->Emplazamiento->Entidad->read(null, $titular);
            $nomentidad = $entidad['Entidad']['nombre'];
            $vectent = explode(' ', $nomentidad);
            $entidad = $vectent[0];
            $indice = $titular;
            switch ($entidad) {
                case 'Generalitat':
                    $entidad = 'GVA';
                    break;

                case 'Ayuntamiento':
                    $entidad = 'GVA-AYTO';
                    $indice = 100;
                    break;

                case 'Ferrocarrils':
                    $entidad = 'FGV';
                    break;

                case 'RadioTelevisió':
                    $entidad = 'RTVV';
                    break;

                case 'Diputación':
                    $entidad = 'DIP. ' . mb_strtoupper($vectent[2]);
                    break;

                default:
                    $entidad = mb_strtoupper($entidad);
                    break;
            }
            $titsel[$indice] = $entidad;
        }
        $this->set('titulares', $titsel);

        // Comprobamos si hemos recibido datos del formulario:
        $condiciones = array();
        if ($this->request->is('post')){
            // Condiciones iniciales:
            $tampag = 30;
            $pagina = 1;
            // Select de Provincia
            if (!empty($this->request->data['Emplazamiento']['provincia'])){
                $addcond = array('Emplazamiento.municipio_id LIKE'  => $this->request->data['Emplazamiento']['provincia'] . '%');
                $condiciones = array_merge($addcond, $condiciones);
            }
            // Input de Centro
            if (!empty($this->request->data['Emplazamiento']['centro'])){
                $addcond = array('Emplazamiento.centro LIKE'  => '%' . $this->request->data['Emplazamiento']['centro'] . '%');
                $condiciones = array_merge($addcond, $condiciones);
            }
            // Select de Comarca
            if (!empty($this->request->data['Emplazamiento']['comarca'])){
                $addcond = array('Emplazamiento.comarca_id'  => $this->request->data['Emplazamiento']['comarca']);
                $condiciones = array_merge($addcond, $condiciones);
            }
            // Select de Titular
            if (!empty($this->request->data['Emplazamiento']['titular'])){
                if ($this->request->data['Emplazamiento']['titular'] == 100){
                    $addcond = array('Emplazamiento.entidad_id BETWEEN ? AND ?'  => array(6,547));
                }
                else{
                    $addcond = array('Emplazamiento.entidad_id'  => $this->request->data['Emplazamiento']['titular']);
                }
                $condiciones = array_merge($addcond, $condiciones);
            }
            // Select de COMDES
            if (!empty($this->request->data['Emplazamiento']['comdes'])){
                $addcond = array('Emplazamiento.comdes'  => $this->request->data['Emplazamiento']['comdes']);
                $condiciones = array_merge($addcond, $condiciones);
            }
            // Select de TDT-GVA
            if (!empty($this->request->data['Emplazamiento']['tdt-gva'])){
                $addcond = array('Emplazamiento.tdt-gva'  => $this->request->data['Emplazamiento']['tdt-gva']);
                $condiciones = array_merge($addcond, $condiciones);
            }
            // Select de RTVV
            if (!empty($this->request->data['Emplazamiento']['rtvv'])){
                $addcond = array('Emplazamiento.rtvv'  => $this->request->data['Emplazamiento']['rtvv']);
                $condiciones = array_merge($addcond, $condiciones);
            }
            // Cambio de página
            if (!empty($this->request->data['Emplazamiento']['irapag'])&&($this->request->data['Emplazamiento']['irapag'] > 0)){
                $this->paginate['page'] = $this->request->data['Emplazamiento']['irapag'];
            }
            // Tamaño de página
            if (!empty($this->request->data['Emplazamiento']['regPag'])&&($this->request->data['Emplazamiento']['regPag'] > 0)){
                $this->paginate['limit'] = $this->request->data['Emplazamiento']['regPag'];
            }
        }
        $this->paginate['conditions'] = $condiciones;
        $emplazamientos = $this->paginate();
        $this->set('emplazamientos', $emplazamientos);
    }

    public function detalle ($id = null){
       // Fijamos el título de la vista
       $this->set('title_for_layout', __('Emplazamiento de Telecomunicaciones'));
       $this->Emplazamiento->id = $id;
       if (!$this->Emplazamiento->exists()) {
           throw new NotFoundException(__('Error: el emplazamiento seleccionado no existe'));
       }
       $emplazamiento = $this->Emplazamiento->read(null, $id);
       // Buscamos el municipio del titular:
       if (!empty($emplazamiento['Entidad']['municipio_id'])){
           $this->Emplazamiento->Municipio->id = $emplazamiento['Entidad']['municipio_id'];
           if (!$this->Emplazamiento->Municipio->exists()) {
               throw new NotFoundException(__('Error: el municipio de la entidad no existe'));
           }
           $emplazamiento['Entidad']['Municipio'] = $this->Emplazamiento->Municipio->read(null, $emplazamiento['Entidad']['municipio_id']);
       }
       if (!empty($emplazamiento['Suministro'])){
           $suministro = $emplazamiento['Suministro'][0];
           $emplazamiento['Suministro'] = $suministro;
           // Datos del titular:
           if ($suministro['titular'] > 0){
               $this->Emplazamiento->Entidad->id = $suministro['titular'];
               $this->Emplazamiento->Entidad->recursive = -1;
               if (!$this->Emplazamiento->Entidad->exists()) {
                   throw new NotFoundException(__('Error: el titular del Suministro no existe'));
               }
               $emplazamiento['Suministro']['Titular'] = $this->Emplazamiento->Entidad->read(null, $suministro['titular'])['Entidad'];
           }
           // Datos del proveedor:
           if ($suministro['proveedor'] > 0){
               $this->Emplazamiento->Entidad->id = $suministro['proveedor'];
               $this->Emplazamiento->Entidad->recursive = -1;
               if (!$this->Emplazamiento->Entidad->exists()) {
                   throw new NotFoundException(__('Error: el proveedor del Suministro no existe'));
               }
               $emplazamiento['Suministro']['Proveedor'] = $this->Emplazamiento->Entidad->read(null, $suministro['proveedor'])['Entidad'];
           }
       }
       $this->set('emplazamiento', $emplazamiento);

   }

    public function xlsexportar () {
        // Buscamos los emplazamientos
        $emplazamientos = $this->Emplazamiento->find('all', array('order' => 'Emplazamiento.centro'));
        $this->set('emplazamientos', $emplazamientos);

        // Definimos la vista
        $this->render('xlsexportar', 'xls');
    }
}
?>

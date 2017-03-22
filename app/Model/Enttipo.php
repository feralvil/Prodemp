<?php
/**
 * Descriptción de Enttipo (Tipo de Entidad)
 *
 * @author alfonso_fer
 */

 App::uses('AppModel', 'Model');
 App::uses('BlowfishPasswordHasher', 'Controller/Component/Auth');

 class Enttipo extends AppModel {
     public $hasMany = array('Entidad');
 }

?>

<?php
/**
 * Modelo de Municipio
 *
 * @author alfonso_fer
 */

 App::uses('AppModel', 'Model');
 App::uses('BlowfishPasswordHasher', 'Controller/Component/Auth');

class Municipio extends AppModel {
    public $hasMany = array('Emplazamiento');
    public $belongsTo = array('Comarca');
}

?>

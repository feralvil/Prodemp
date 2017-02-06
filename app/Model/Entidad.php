<?php

/**
 * Descriptción de Entidad
 *
 * @author alfonso_fer
 */

 App::uses('AppModel', 'Model');
 App::uses('BlowfishPasswordHasher', 'Controller/Component/Auth');

class Entidad extends AppModel {
    //public $hasMany = array('Emplazamiento');
    public $hasMany = array(
        'Emplazamiento',
        'TitSuministro' => array(
            'className' => 'Suministro',
            'foreignKey' => 'titular'
        ),
        'ProvSuministro' => array(
            'className' => 'Suministro',
            'foreignKey' => 'proveedor'
        )
    );
    public $validate = array(
        'centro' => array(
            'required' => array(
                'rule' => array('notBlank'),
                'message' => 'El Emplazamiento no puede estar vacío'
            ),
            'unico' => array(
                'rule' => 'isUnique',
                'message' => 'Ya existe un Emplazamiento con el mismo nombre'
            )
        ),
        'latitud' => array(
            'required' => array(
                'rule' => array('notBlank'),
                'message' => 'La latitud no puede estar vacía'
            ),
        ),
        'longitud' => array(
            'required' => array(
                'rule' => array('notBlank'),
                'message' => 'La latitud no puede estar vacía'
            ),
        ),
    );
}

?>

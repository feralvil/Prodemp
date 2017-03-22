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
    public $belongsTo = array('Enttipo', 'Municipio');
    public $validate = array(
        'nombre' => array(
            'required' => array(
                'rule' => array('notBlank'),
                'message' => 'El nombre de la entidad no puede estar vacío'
            ),
            'unico' => array(
                'rule' => 'isUnique',
                'message' => 'Ya existe una Entidad con el mismo nombre'
            )
        ),
        'enttipo_id' => array(
            'required' => array(
                'rule' => array('notBlank'),
                'message' => 'Debe seleccionar un tipo de entidad'
            ),
        ),
    );
}

?>

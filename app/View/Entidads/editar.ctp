<h1><?php echo __('Modificar Entidad') . ' ' . $this->request->data['Entidad']['nombre']; ?></h1>
<?php
echo $this->Form->create('Entidad', array(
    'inputDefaults' => array('label' => false,'div' => false),
    'class' => 'form-horizontal'
));
?>
<fieldset>
    <legend><?php echo __('Datos de la Entidad');?></legend>
    <div class="form-group">
        <?php
        echo $this->Form->label('Entidad.cif', __('CIF'), array('class' => 'col-sm-1 control-label'));
        echo $this->Form->input('Entidad.cif', array('div' => 'col-sm-2', 'class' => 'form-control'));
        echo $this->Form->label('Entidad.nombre', __('Entidad'), array('class' => 'col-sm-1 control-label'));
        echo $this->Form->input('Entidad.nombre', array('div' => 'col-sm-4 has-error', 'class' => 'form-control'));
        echo $this->Form->label('Entidad.acronimo', __('Acrónimo'), array('class' => 'col-sm-1 control-label'));
        echo $this->Form->input('Entidad.acronimo', array('div' => 'col-sm-2 has-error', 'class' => 'form-control'));
        ?>
    </div>
    <div class="form-group">
        <?php
        echo $this->Form->label('Entidad.enttipo_id', __('Tipo de Entidad'), array('class' => 'col-sm-2 control-label'));
        echo $this->Form->input('Entidad.enttipo_id', array('options' => $enttipos, 'empty' => __('Seleccionar'), 'div' => 'col-sm-2 has-error', 'class' => 'form-control'));
        echo $this->Form->label('Entidad.web', __('Web'), array('class' => 'col-sm-1 control-label'));
        echo $this->Form->input('Entidad.web', array('div' => 'col-sm-3', 'class' => 'form-control'));
        echo $this->Form->label('Entidad.mail', __('E-mail'), array('class' => 'col-sm-1 control-label'));
        echo $this->Form->input('Entidad.mail', array('div' => 'col-sm-3', 'class' => 'form-control'));
        ?>
    </div>
    <legend><?php echo __('Ubicación de la Entidad');?></legend>
    <div class="form-group">
        <?php
        echo $this->Form->label('Entidad.domicilio', __('Domicilio'), array('class' => 'col-sm-1 control-label'));
        echo $this->Form->input('Entidad.domicilio', array('div' => 'col-sm-3', 'class' => 'form-control'));
        echo $this->Form->label('Entidad.codpostal', __('C.P.'), array('class' => 'col-sm-1 control-label'));
        echo $this->Form->input('Entidad.codpostal', array('div' => 'col-sm-1', 'class' => 'form-control'));
        echo $this->Form->label('Entidad.telefono', __('Teléfono'), array('class' => 'col-sm-1 control-label'));
        echo $this->Form->input('Entidad.telefono', array('div' => 'col-sm-2', 'class' => 'form-control'));
        echo $this->Form->label('Entidad.fax', __('Fax'), array('class' => 'col-sm-1 control-label'));
        echo $this->Form->input('Entidad.fax', array('div' => 'col-sm-2', 'class' => 'form-control'));
        ?>
    </div>
    <div class="form-group">
        <?php
        $provent = $this->request->data['Entidad']['provincia'];
        if (in_array($provent, $provcv)){
            $this->request->data['Entidad']['provincia'] = '';
        }
        echo $this->Form->label('Entidad.municipio_id', __('Municipio CV'), array('class' => 'col-sm-2 control-label'));
        echo $this->Form->input('Entidad.municipio_id', array('options' => $selmuni, 'empty' => __('Seleccionar'), 'div' => 'col-sm-2', 'class' => 'form-control'));
        echo $this->Form->label('Entidad.municipio', __('Municipio no CV'), array('class' => 'col-sm-2 control-label'));
        echo $this->Form->input('Entidad.municipio', array('div' => 'col-sm-2', 'class' => 'form-control'));
        echo $this->Form->label('Entidad.provincia', __('Provincia no CV'), array('class' => 'col-sm-2 control-label'));
        echo $this->Form->input('Entidad.provincia', array('div' => 'col-sm-2', 'class' => 'form-control'));
        ?>
    </div>
    <div class="form-group text-center">
        <div class="btn-group" role="group" aria-label="...">
            <?php
            echo $this->Form->button(
            '<span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span> &nbsp;' . __('Guardar Datos'),
            array('type' => 'submit', 'class' => 'btn btn-default', 'title' => __('Guardar Datos'), 'alt' => __('Guardar Datos'), 'escape' => false)
            );
            echo $this->Form->button(
            '<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>  &nbsp;'.__('Cancelar Cambios'),
            array('type' => 'reset', 'class' => 'btn btn-default', 'title' => __('Cancelar Cambios'), 'alt' => __('Cancelar Cambios'), 'escape' => false)
            );
            echo $this->Html->Link(
                '<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>' . ' ' . __('Volver'),
                array('controller' => 'entidads', 'action' => 'detalle', $this->request->data['Entidad']['id']),
                array('class' => 'btn btn-default', 'title' => __('Volver'), 'alt' => __('Volver'), 'escape' => false)
            );
            ?>
        </div>
    </div>
</fieldset>

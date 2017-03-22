<?php
// Dinamismo con JQuery
$next = $this->Paginator->counter('{:page}') + 1;
$prev = $this->Paginator->counter('{:page}') - 1;
$ultima = $this->Paginator->counter('{:pages}');
$this->Js->get("#anterior");
$this->Js->event('click', "$('#EntidadIrapag').val($prev);$('#EntidadIndexForm').submit()");
$this->Js->get("#siguiente");
$this->Js->event('click', "$('#EntidadIrapag').val($next);$('#EntidadIndexForm').submit()");
$this->Js->get("#primera");
$this->Js->event('click', "$('#EntidadIrapag').val(1);$('#EntidadIndexForm').submit()");
$this->Js->get("select");
$this->Js->event('change', '$("#EntidadIndexForm").submit()');
$this->Js->get("#ultima");
$this->Js->event('click', "$('#EntidadIrapag').val($ultima);$('#EntidadIndexForm').submit()");
$nent = count($entidades);
?>
<h1><?php echo __('Entidades relacionadas con Emplazamientos'); ?></h1>
<?php
echo $this->Form->create('Entidad', array(
    'inputDefaults' => array('label' => false,'div' => false),
    'class' => 'form-horizontal'
));
echo $this->Form->hidden('tampag', array('value' => $this->Paginator->counter('{:current}')));
echo $this->Form->hidden('irapag', array('value' => '0'));
?>
<fieldset>
    <legend>
        <?php
        echo __('Criterios de Búsqueda') . ' &mdash; ';
        echo $this->Html->Link(
            '<span class="glyphicon glyphicon-refresh" aria-hidden="true"></span>',
            array('controller' => 'entidads', 'action' => 'index'),
            array('title' => __('Limpiar Criterios'), 'escape' => false)
        );
        ?>
    </legend>
    <div class="form-group">
        <?php
        echo $this->Form->label('Entidad.enttipo_id', __('Tipo de entidad'), array('class' => 'col-sm-2 control-label'));
        echo $this->Form->input('Entidad.enttipo_id', array('options' => $enttipos, 'empty' => __('Seleccionar'), 'div' => 'col-sm-2', 'class' => 'form-control'));
        echo $this->Form->label('Entidad.provincia', __('Provincia'), array('class' => 'col-sm-1 control-label'));
        echo $this->Form->input('Entidad.provincia', array('options' => $provincias, 'empty' => __('Seleccionar'), 'div' => 'col-sm-2', 'class' => 'form-control'));
        echo $this->Form->label('Entidad.nombre', __('Entidad'), array('class' => 'col-sm-1 control-label'));
        ?>
        <div class="input-group col-sm-3">
            <?php
            echo $this->Form->input('Entidad.nombre', array('class' => 'form-control'));
            ?>
            <div class="input-group-btn">
                <button type="submit" class="btn btn-default"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></button>
            </div>
        </div>
    </div>
</fieldset>
<fieldset>
    <legend>
        <?php
        echo __('Resultados de Búsqueda');
        if ($nent > 0){
            echo ' &mdash; ' . __($this->Paginator->counter("Entidades <b>{:start}</b> a <b>{:end}</b> de <b>{:count}</b>"));
        }
        ?>
    </legend>
    <div class="form-group">
        <?php
        $opciones = array(30 => 30, 50 => 50, 100 => 100, $this->Paginator->counter('{:count}') => 'Todos');
        echo $this->Form->label('Entidad.tampag', __('Entidades por página'), array('class' => 'col-md-2 control-label'));
        echo $this->Form->input('Entidad.tampag', array('options' => $opciones, 'empty' => __('Seleccionar'), 'div' => 'col-md-2', 'class' => 'form-control'));
        ?>
        <div class="btn-group col-md-4" role="group" aria-label="...">
            <?php
            $clase = 'btn btn-default';
            if ($this->Paginator->counter('{:page}') == 1) {
                    $clase .= ' disabled';
            }
            echo $this->Html->Link(
                    '<span class="glyphicon glyphicon-step-backward" aria-hidden="true"></span>', '#',
                    array('title' => __('Primera Página'), 'class' => $clase, 'id' => 'primera', 'alt' => __('Primera Página'), 'escape' => false)
            );
            $clase = 'btn btn-default';
            if (!$this->Paginator->hasPrev()) {
                    $clase .= ' disabled';
            }
            echo $this->Html->Link(
                    '<span class="glyphicon glyphicon-backward" aria-hidden="true"></span>', '#',
                    array('title' => __('Página Anterior'), 'class' => $clase, 'id' => 'anterior', 'alt' => __('Página Anterior'), 'escape' => false)
            );
            $clase = 'btn btn-default';
            echo $this->Html->Link(
                    __('Página') . ' ' . $this->Paginator->counter('{:page}')  . ' / ' . $this->Paginator->counter('{:pages}'), '#',
                    array('title' => __('Página Actual'), 'class' => $clase, 'alt' => __('Página Actual'), 'escape' => false)
            );
            $clase = 'btn btn-default';
            if (!$this->Paginator->hasNext()) {
                    $clase .= ' disabled';
            }
            echo $this->Html->Link(
                '<span class="glyphicon glyphicon-forward" aria-hidden="true"></span>', '#',
                array('title' => __('Página Siguiente'), 'class' => $clase, 'id' => 'siguiente', 'alt' => __('Página Siguiente'), 'escape' => false)
            );
            $clase = 'btn btn-default';
            if ($this->Paginator->counter('{:page}') == $this->Paginator->counter('{:pages}')) {
                    $clase .= ' disabled';
            }
            echo $this->Html->Link(
                    '<span class="glyphicon glyphicon-step-forward" aria-hidden="true"></span>', '#',
                    array('title' => __('Última Página'), 'class' => $clase, 'id' => 'ultima', 'alt' => __('Última Página'), 'escape' => false)
            );
            ?>
        </div>
        <div class="col-md-2">
            <div class="btn-group" role="group" aria-label="...">
                <?php
                if ((AuthComponent::user('role') == 'admin') || (AuthComponent::user('role') == 'colab')) {
                    echo $this->Html->Link(
                        '<span class="glyphicon glyphicon-plus" aria-hidden="true"></span>',
                        array('controller' => 'entidads', 'action' => 'agregar'),
                        array('title' => __('Agregar Entidad'), 'class' => 'btn btn-default', 'alt' => __('Agregar Entidad'), 'escape' => false)
                    );
                }
                echo $this->Html->Link(
                    '<span class="glyphicon glyphicon-calendar" aria-hidden="true"></span>',
                    array('controller' => 'entidads', 'action' => 'xlsexportar'),
                    array('title' => __('Exportar a Excel'), 'class' => 'btn btn-default', 'alt' => __('Exportar a Excel'), 'target' => '_blank', 'escape' => false)
                );
                ?>
            </div>
        </div>
    </div>
</fieldset>
<?php
echo $this->Form->end();
if ($nent > 0){
?>
    <table class="table table-condensed table-hover table-striped table-bordered">
        <tr>
            <th><?php echo __('Acciones');?></th>
            <th><?php echo __('CIF');?></th>
            <th><?php echo __('Nombre');?></th>
            <th><?php echo __('Tipo');?></th>
            <th><?php echo __('Provincia');?></th>
            <th><?php echo __('Municipio');?></th>
            <th><?php echo __('Mail');?></th>
            <th><?php echo __('Teléfono');?></th>
        </tr>
        <?php
        foreach ($entidades as $entidad) {
        ?>
            <tr>
                <td class="text-center">
                    <?php
                    echo $this->Html->Link(
                        '<span class="glyphicon glyphicon-search" aria-hidden="true"></span>',
                        array('controller' => 'entidads', 'action' => 'detalle', $entidad['Entidad']['id']),
                        array('title' => __('Detalle de Entidad'), 'alt' => __('Detalle de Entidad'), 'escape' => false)
                    );
                    if ((AuthComponent::user('role') == 'admin') || (AuthComponent::user('role') == 'colab')) {
                        echo ' &mdash; ';
                        echo $this->Html->Link(
                            '<span class="glyphicon glyphicon-edit" aria-hidden="true"></span>',
                            array('controller' => 'entidads', 'action' => 'editar', $entidad['Entidad']['id']),
                            array('title' => __('Modificar Entidad'), 'alt' => __('Modificar Entidad'), 'escape' => false)
                        );
                    }
                    ?>
                </td>
                <td><?php echo $entidad['Entidad']['cif'];?></td>
                <td><?php echo $entidad['Entidad']['nombre'];?></td>
                <td><?php echo $entidad['Enttipo']['tipo'];?></td>
                <td><?php echo $entidad['Entidad']['provincia'];?></td>
                <td>
                    <?php
                    if ($entidad['Municipio']['nombre'] != NULL){
                        echo $entidad['Municipio']['nombre'];
                    }
                    else{
                        echo $entidad['Entidad']['municipio'];
                    }
                    ?>
                </td>
                <td><?php echo $entidad['Entidad']['mail'];?></td>
                <td><?php echo $entidad['Entidad']['telefono'];?></td>
            </tr>
        <?php
        }
        ?>
    </table>
<?php
}
else{
?>
    <div class='panel panel-warning'>
        <div class="panel-heading">
            <h3 class="panel-title"><?php echo  __('No hay resultados'); ?></h3>
        </div>
        <div class="panel-body">
            <?php echo __('No se han econtrado entidades con los criterios de búsqueda seleccionados'); ?>
        </div>
    </div>
<?php
}
?>

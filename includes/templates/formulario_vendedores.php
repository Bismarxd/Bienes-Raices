<fieldset>
    <legend>Información General</legend>
    <label for="titulo">Nombre:</label>
    <input type="text" name="vendedor[nombre]" id="nombre" placeholder="Nombre Vendedor(a)" value="<?php echo s($vendedor->nombre); ?>">

    <label for="titulo">Apellido:</label>
    <input type="text" name="vendedor[apellido]" id="apellido" placeholder="Apellido Vendedor(a)" value="<?php echo s($vendedor->apellido); ?>">

</fieldset>

<fieldset>
    <legend>Información Extra</legend>

    <label for="titulo">Teléfono:</label>
    <input type="text" name="vendedor[telefono]" id="telefono" placeholder="Teléfono Vendedor(a)" value="<?php echo s($vendedor->telefono); ?>">

</fieldset>
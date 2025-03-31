window.addEventListener('DOMContentLoaded', eventListeners);

function eventListeners() {
    
    const form = document.getElementById('formulario');
    form.addEventListener('reset', resetForm);
    form.addEventListener('submit', saveForm);

    document.querySelectorAll('[data-fillwithdb=tipo_tarjeta]').forEach(setSlcTipoTarjeta);

    document.querySelectorAll('[data-enabledwith]').forEach(enabledWith);

    document.getElementById('inputNumSucursal')?.addEventListener('change', setSucursalesInfo);

}

function saveForm(evt) {
    evt.preventDefault();

    const form = evt.target;

    const btnSubmit = form.querySelector('input[type=submit]');
    btnSubmit.disabled = true;

    const tableName = document.getElementById('nombre_tabla_bd');

    let obj = {};
    document.querySelectorAll('[data-dbname]').forEach(e => {
        let attrName = e.getAttribute('data-dbname');
        obj[attrName] = e.value;
    });
    obj = JSON.stringify(obj);

    let form_data = new FormData();
    form_data.append('opc', 'submitForm');
    form_data.append('obj', obj);
    form_data.append('tableName', tableName.value);

    fetch('../php/funciones.php', {
        method: 'POST',
        body: form_data
    })
        .then(response => response.json())
        .then(data => {

            if (!data.estado) throw new Error(data.mensaje);
            pointless('Registro guardado', 'success');
            resetForm();

        })
        .catch(err => {
            console.error(err)
            pointless(err.message, 'error');
        })
        .finally(() => {
            btnSubmit.disabled = false;
        });
}

function resetForm() {
    document.querySelectorAll('[data-enabledwith]').forEach(elem => elem.disabled = true);
    document.querySelectorAll('[data-dbname]').forEach(elem => elem.value = '')
}

function setSlcTipoTarjeta(elem) {

    fetch(`../php/funciones.php?opc=getTipoTarjetas`)
        .then(res => res.json())
        .then(data => {

            if (!data.estado) throw new Error(data.mensaje);
            elem.innerHTML = data.datos;
        })
        .catch(err => {
            console.error(err)
            createToast('Error al cargar los tipos de tarjeta', 'error');
        })

}

function setSucursalesInfo() {

    const inputNumSucursal = document.getElementById('inputNumSucursal');
    const inputNombreSucursal = document.getElementById('inputNombreSucursal');
    const inputGerenciaComercial = document.getElementById('inputGerenciaComercial');

    if( inputNombreSucursal ) inputNombreSucursal.value = '';
    if( inputGerenciaComercial ) inputGerenciaComercial.value = '';

    if (inputNumSucursal.value.trim().length > 0) {

        fetch(`http://10.30.248.6:50/api/v1/sucursales?orderBy=numero_sucursal&numero_sucursal=${inputNumSucursal.value}`)
            .then(res => res.json())
            .then(data => {

                if (data.status !== 200) throw new Error(data.message);

                const resp = data.result[0];
                
                if( inputNombreSucursal ) inputNombreSucursal.value = resp.nombre;
                if( inputGerenciaComercial ) inputGerenciaComercial.value = resp.gcb;
                
            })
            .catch(err => {
                console.error(err);
                createToast(`Error al conseguir el nombre y la gerencia comercial de la sucursal ${inputNombreSucursal.value}`);
            })
    }
}
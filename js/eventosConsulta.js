window.addEventListener('DOMContentLoaded', () => {

    checkEnabledFields();
        
    const form = document.getElementById('formulario');
    form.addEventListener('reset', evt => {
        evt.preventDefault();
        resetForm();
    });
    form.addEventListener('submit', saveForm );

    document.querySelectorAll('[data-fillwithdb=estatus_bo_cat]').forEach(setSlcEstatusBoCat);
    document.querySelectorAll('form .card:not([data-cardbo]) :is(input, textarea, select)').forEach(elem => elem.disabled = true);

});

function resetForm() {
    document.querySelectorAll('[data-cardbo] [data-enabledwith]').forEach( elem => elem.disabled = true);
    document.querySelectorAll('[data-cardbo] [data-dbname]').forEach(elem => elem.value = '');
}

function saveForm( evt ){
    evt.preventDefault();
    const form = evt.target;

    const btnSubmit = form.querySelector('input[type=submit]');
    btnSubmit.disabled = true;

    const tableName = document.getElementById('nombre_tabla_bd');
    const folio_uuid = document.querySelector('[data-dbname=folio_uuid]');

    let obj = {};
    document.querySelectorAll('[data-cardbo] [data-dbname]').forEach(elem => {
        if( elem === folio_uuid ) return;
        let attrName = elem.getAttribute('data-dbname');
        obj[attrName] = elem.value;
    });
    obj = JSON.stringify(obj);

    let form_data = new FormData();
    form_data.append('opc', 'updateForm');
    form_data.append('obj', obj);
    form_data.append('tableName', tableName.value);
    form_data.append('folio_uuid', folio_uuid.value);

    fetch('../php/funciones.php', {
        method: 'POST',
        body: form_data
    })
        .then(response => response.json())
        .then(data => {
            
            if( !data.estado ) throw new Error( data.mensaje );

            Swal.mixin({
                toast: true,
                position: "top-end",
                showConfirmButton: false,
                timer: 2500,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.onmouseenter = Swal.stopTimer;
                    toast.onmouseleave = Swal.resumeTimer;
                },
                didClose: () => {
                    window.location.reload();
                }
            }).fire({
                icon:'success',
                title:'Se actualizó el registro',
                text:'Reiniciando formulario...'
            });


        })
        .catch(err => {
            console.error(err)
            pointless(err.message, 'error');
        })
        .finally(() => {
            btnSubmit.disabled = false;
        });

}

function setSlcEstatusBoCat( elem ){

    fetch('../php/funciones.php?opc=getEstatusBoCat')
        .then(res => res.json())
        .then(data => {
            if(!data.estado) throw new Error( data.mensaje );
            elem.innerHTML = data.datos;
        })
        .catch(err => {
            console.error(err);
            createToast('Error al cargar los estatus para BO', 'error');
        })

}

function disabledFields( disabledElem = true ){
    document.querySelectorAll('form .card[data-cardbo] :is(input, textarea, select)').forEach(elem => elem.disabled = disabledElem);
    document.querySelectorAll('form input:is( [type=submit], [type=reset] )').forEach( elem => elem.disabled = disabledElem );
}


async function checkEnabledFields(){

    userData = await getSessionInfo();

    disabledFields( 
        !['CONSULTOR'].includes( userData.rol?.toUpperCase() )
    );

}
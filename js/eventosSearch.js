window.addEventListener('DOMContentLoaded', () => {

    document.getElementById('modal-search').showModal();

    document.getElementById('formSearch').addEventListener('submit', evt => {
        evt.preventDefault();
        fillTableSearch();
    });

    document.getElementById('btnSearchModal').addEventListener('click', validaBusqueda);
    document.getElementById('btnResetModal').addEventListener('click', resetBusqueda);

    fillTableSearch();
});

function fillTableSearch(){

    const tableName = document.getElementById('nombre_tabla_bd');
    const tableSearch = document.getElementById('tableSearch');
    const tableBody = tableSearch.querySelector('tbody');

    const numero_caso = document.querySelector('[data-searchParam=numero_caso]');
    const numero_cliente = document.querySelector('[data-searchParam=numero_cliente]');
    const fecha = document.querySelector('[data-searchParam=fecha]');

    let form_data = new FormData();
    form_data.append('opc', 'fillTableSearch');
    form_data.append('tableName', tableName.value);
    form_data.append('num_caso', numero_caso.value);
    form_data.append('num_cte', numero_cliente.value);
    form_data.append('fecha', fecha.value);

    fetch('../php/funciones.php',{
        method: 'POST',
        body: form_data
    }).then(res => res.json())
        .then(data => {
            if( !data.estado ) throw new Error('Error al obtener la informacion de la tabla');

            tableBody.innerHTML = data.datos;
            addListenerTr();
        })
        .catch(err => {
            console.error(err);
            createToast('Error al obtener valores', 'error');
        })

}

function addListenerTr(){

    const tableSearch = document.getElementById('tableSearch');
    const tableBody = tableSearch.querySelector('tbody');

    tableBody.querySelectorAll('tr').forEach(elem => {
        
        elem.addEventListener('click', evt => {

            tableBody.querySelectorAll('[selected]').forEach( elem => elem.removeAttribute('selected') );

            const trParent = evt.target.parentNode;
            trParent.setAttribute('selected', true);
        });

        elem.addEventListener('dblclick', getInfoRegistro);

    });

}

function validaBusqueda(){

    
    const tableSearch = document.getElementById('tableSearch');
    const tableBody = tableSearch.querySelector('tbody');

    if( tableBody.querySelector('[selected]') ){
        getInfoRegistro();
    }

}

function getInfoRegistro(){

    const tableName = document.getElementById('nombre_tabla_bd');
    const trSelected = document.querySelector('#tableSearch tbody tr[selected]');

    let form_data = new FormData();
    form_data.append('opc', 'getInfoRegistro');
    form_data.append('tableName', tableName.value);
    form_data.append('folio_uuid', trSelected.getAttribute('data-folio-uuid') ?? '');

    fetch('../php/funciones.php', {
        method: 'POST',
        body: form_data
    }).then( res => res.json())
        .then(data => {
            
            if( !data.estado ) throw new Error(data.mensaje);

            for( const [column, value] of Object.entries( data.datos ) ){
                
                const element = document.querySelector(`[data-dbname=${column}]`);

                if( !element ) continue;
                if( 
                    element.nodeName === 'SELECT'
                    && ![... element.options].find(opt => opt.value == value)
                ) addOptionTo(element, value);
                
                element.value = value
                
            }
        })
        .catch(err => {
            console.error(err);
            pointless('Error al obtener la informacion del registro', 'error');
        })
        .finally(() => {
            document.getElementById('modal-search').close();
        });

}

function resetBusqueda(){

    const modalSearch = document.getElementById('modal-search');

    modalSearch.querySelectorAll('input').forEach(elem => elem.value='');
    
    fillTableSearch();
}
window.addEventListener('DOMContentLoaded', () =>{

    getBitacoraBancoppel();

    document.getElementById('formularioDescarga').addEventListener('submit', descargaDatos);
});


function getBitacoraBancoppel() {
    
    const selectNombreBitacora = document.getElementById('bitacora');

    fetch(`../php/funciones.php?opc=getBitacoraBancoppel`)
    .then(response => response.json())
    .then(data => {
  
      if (!data.estado) throw new Error(data.mensaje);

      data.datos.forEach(({ bitacora }) => {
        const option = document.createElement('option');
        option.text = bitacora;
        selectNombreBitacora.appendChild(option);
      });
  
    })
    .catch(error => {
      console.error(error)
    });
 
}

function descargaDatos(evt){
    evt.preventDefault();

    const tableName = document.getElementById('bitacora');
    const fechaInicio = document.getElementById('fecha-inicial');
    const fechaFin = document.getElementById('fecha-final');

    const link = document.createElement('a');
    link.href = `../php/descarga_Archivos.php?tabla=${tableName.value}&fechaInicio=${fechaInicio.value}&fechaFin=${fechaFin.value}`;

    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
    
}


window.addEventListener('DOMContentLoaded', () => {

    document.getElementById('formularioSignin').addEventListener('submit', login);

    document.getElementById('formularioSignup').addEventListener('submit', signUp)

    document.getElementById('spanUpdatePass').addEventListener('click', updatePass);

});


function login( evt ){
    evt.preventDefault();

    const form = evt.target;

    let form_data = new FormData( form );
    form_data.append('opc', 'login');

    fetch('php/funciones.php',{
        method: 'POST',
        body: form_data
    }).then(res => res.json())
        .then(data => {
            
            if( !data.estado ) throw new Error( data.mensaje );

            window.location.reload();
        })
        .catch(err => {
            console.error(err)
            createToast( err.message, 'error')
        })

}

function signUp( evt ){
    evt.preventDefault();

    const form = evt.target;

    let form_data = new FormData( form )
    form_data.append('opc', 'signUp');

    
    fetch('php/funciones.php',{
        method: 'POST',
        body: form_data
    }).then(res => res.json())
        .then(data => {            
            if( !data.estado ) throw new Error( data.mensaje );

            toastReloadPage('Se dió de alta con éxito', 'success','Transfiriendo al menu...')
            form.reset();

        })
        .catch(err => {
            console.error(err)
            createToast( err.message, 'error');
        })
}

function updatePass(){

    Swal.fire({
        title: "Actualizar Contraseña",
        html: `
            <form id="formUpdatePass">
                <input type="text" name="username" placeholder="# Empleado" onlyNumbers required>
                <input type="password" name="old_password" placeholder="Contraseña Actual" required>
                <input type="password" name="new_password" placeholder="Contraseña Nueva" required>
            </form>
        `,
        focusConfirm: false,
        confirmButtonText: "Actualizar",
        showCancelButton: true,
        cancelButtonText: 'Cancelar',
        showLoaderOnConfirm: true,
        preConfirm: async () => {
            const form = document.getElementById('formUpdatePass');

            let form_data = new FormData( form );
            form_data.append('opc','formUpdatePass');
            
            try{

                form.querySelectorAll('[required]').forEach(elem => {
                    if( elem.value.trim().length < 1 ) throw new Error('Favor de llenar todos los campos');
                });

                let res = await fetch('php/funciones.php',{ method: 'POST', body: form_data });
                let data = await res.json()

                if( !data.estado ) throw new Error( data.mensaje );

                toastReloadPage('Se actualizó la contraseña correctamente, serás transferido al menu', 'success','Transfiriendo al menu...')

            }catch(err){
                console.error(err);
                Swal.showValidationMessage( err.message );
            }

        }
    });

}
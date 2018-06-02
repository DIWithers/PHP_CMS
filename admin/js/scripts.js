

$(document).ready(function() {

    ClassicEditor
    .create( document.querySelector( '#editor', {
        ckfinder: {
            uploadUrl: '../images/'
        }
        
    } ) )
    .then( editor => {

    })
    .catch( error => {
        console.error( error );
    }
    );
});

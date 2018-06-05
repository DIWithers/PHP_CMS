$(document).ready(function() {

    ClassicEditor
    .create( document.querySelector( '#add_post_editor') )
    .then( editor => {

    })
    .catch( error => {
        console.error( error );
    }
    );

    ClassicEditor
    .create( document.querySelector( '#edit_post_editor') )
    .then( editor => {

    })
    .catch( error => {
        console.error( error );
    }
    );

    $('#selectAllBoxes').click(function(event) {
        if (this.checked) {
            $('.checkBoxes').each(function() {
                this.checked = true;
            });
        }
        else {
            $('.checkBoxes').each(function() {
                this.checked = false;
            })
        }
    })
});

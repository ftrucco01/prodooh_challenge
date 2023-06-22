$(document).ready(function() {
    $.ajax({
        url: createImageUrl,
        type: 'POST',
        data: JSON.stringify({
            phraseId: phraseId,
            dimensions: dimensions
        }),
        contentType: 'application/json',
        success: function(response) {
            console.log(response);
        },
        error: function(xhr, status, error) {
            console.error(error);
        }
    });
});
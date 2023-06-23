/**
 * Make the request to the API with the authentication token.
 * This code snippet performs user authentication by sending a POST request to the login endpoint
 * with the user's email and password. Upon successful authentication, it obtains an authentication token.
 * The obtained token is then used to make a subsequent POST request to the createImageUrl endpoint,
 * sending the desired parameters for image creation. The request includes the authentication token
 * in the Authorization header for access to the protected resource.
 * If the token is not found, an appropriate message is logged.
 * This code assumes the usage of jQuery's AJAX function.
 * */
$(document).ready(function() {
    $.ajax({
        url: loginUrl,
        type: 'POST',
        data: JSON.stringify({
            email: 'creator@mock.com',
            password: 'password'
        }),
        contentType: 'application/json',
        success: function(response) {
            var token = response.token;

            // Make the request to the API with the authentication token.
            if (token) {
                $.ajax({
                    url: createImageUrl,
                    type: 'POST',
                    data: JSON.stringify({
                        phraseId: phraseId,
                        dimensions: dimensions
                    }),
                    contentType: 'application/json',
                    beforeSend: function(xhr) {
                        xhr.setRequestHeader('Authorization', 'Bearer ' + token);
                    },
                    success: function(response) {
                        console.log(response);
                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                    }
                });
            } else {
                console.log('Token not found. Please authenticate first.');
            }
        },
        error: function(xhr, status, error) {
            console.error(error);
        }
    });
});
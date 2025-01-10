function redirectTo(url, timeout=0) {
    setTimeout(() => {
        if (typeof url === 'string' && url.trim() !== '') {
            window.location.href = url;
        }
    }, timeout);

}

function deleteCookies() {
    // Check if the cookies exist
    const isLoggedCookie = document.cookie.split('; ').find(row => row.startsWith('is_logged='));
    const usernameCookie = document.cookie.split('; ').find(row => row.startsWith('username='));

    if (isLoggedCookie && usernameCookie) {
        // Delete the cookies by setting their expiration date to a time in the past
        document.cookie = "is_logged=; expires=Thu, 01 Jan 1970 00:00:00 GMT; path=/";
        document.cookie = "username=; expires=Thu, 01 Jan 1970 00:00:00 GMT; path=/";

        // Alert the user that the cookies have been deleted
        alert('You logged out from your account.');

        // Optional: Refresh the page or redirect
        // location.reload(); // Uncomment this if you want to reload the page
    }
}



function showCookie(tag_id='logout', text='Logout') {
    const username = sessionUsername;
    alert(username);
    if (username) {
        const logoutLink = document.getElementById(tag_id);

        if (logoutLink) {
            logoutLink.textContent = `${text} (${username})`;
        }
    }


}

function filter_image() {
    document.getElementById('imageInput').addEventListener('change', function() {
        const file = this.files[0];
        const fileExtension = file.name.split('.').pop().toLowerCase();
        const validExtensions = ['jpg', 'jpeg', 'png'];

        if (file && validExtensions.indexOf(fileExtension) === -1) {
            alert('Please upload an image file (JPG or PNG only).');
            this.value = ''; // Clear the input
        }
    });

}
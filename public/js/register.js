document.getElementById('get-otp').addEventListener('click', function () {
    const email = document.getElementById('email').value;
    if (!email) {
        alert('Enter Email!');
        return;
    }

    const url = window.BASE_URL;
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    fetch(`${url}/otp`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken
        },
        body: JSON.stringify({ email: email })
    })
    .then(response => response.json())
    .then(info => {
        if (info.success) {
            alert('OTP has been sent to your email. Check your inbox or spam folder.');
        } else {
            alert(info.message || 'Something went wrong. Please try again.');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred. Please try again later.');
        // alert(`An error occurred. Please try again later.${error}`);
    });
});

document.querySelector("form").addEventListener("submit", function(e) {
    const pw = document.getElementById("password").value;
    const confirm = document.getElementById("confirm_password").value;

    if (pw !== confirm) {
        e.preventDefault(); 
        alert("Wachtwoorden komen niet overeen!");
    }
});
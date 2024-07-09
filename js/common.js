window.addEventListener("load", ()=>{
    var signup_form = document.getElementById("signup-form");
    signup_form.addEventListener("submit", function (event) {
        var xhr = new XMLHttpRequest();
        var form_data = new FormData(signup_form);
        
        xhr.open('POST', 'php/signup.php');

        //on success
        xhr.addEventListener("load", success_form);
        
        //on error
        xhr.addEventListener("error", err_form);

        xhr.send(form_data);

        document.getElementById("loading")
        .style.display="block";
        event.preventDefault();
    })
});

window.addEventListener("load", ()=>{
    var login_form = document.getElementById("login-form");
    login_form.addEventListener("submit", function (event) {
        var xhr = new XMLHttpRequest();
        var form_data = new FormData(login_form);
        
        xhr.open('POST', 'php/login.php');

        //on success
        xhr.addEventListener("load", success_login);
        
        //on error
        xhr.addEventListener("error", err_form);

        xhr.send(form_data);

        document.getElementById("loading")
        .style.display="block";
        event.preventDefault();
    })
});

var success_login = (event)=>{
    document.getElementById("loading")
    .style.display="none";

    var response = JSON.parse(event.target.responseText);

    if(response.success){
        alert(response.message);
        location.reload();
    } else{
        alert(response.message);
    }
};

var success_form = (event) =>{
    document.getElementById("loading").style.display="none";

    var response = JSON.parse(event.target.responseText);

    if(response.success){
        alert(response.message);
        window.location.href="index.php";
    } else{
        alert(response.message);
    }
};

var err_form = (event)=>{
    document.getElementById("loading")
    .style.display="none";

    alert("Oops! Something went wrong");
};
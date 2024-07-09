window.addEventListener("load", ()=>{
    const search = window.location.search;
    const params = new URLSearchParams(search);
    var property_id = params.get('property_id');

    heart_img = document.querySelector('.is-interested-image');
    heart_img.addEventListener('click', (event)=>{
        const xhr = new XMLHttpRequest();
        xhr.open('GET', 'php/toggle_intrested.php?property_id='+property_id);
        xhr.addEventListener('load', convert_heart);
        xhr.addEventListener('error', on_error);
        xhr.send();
        document.getElementById('loading').style.display='block';
        event.preventDefault();
    })
})

var convert_heart = (event)=>{
    document.getElementById('loading').style.display='none';

    var response = JSON.parse(event.target.responseText);

    if(response.success){
        var heart = document.querySelector('.is-interested-image');
        var like_count = document.querySelector('.interested-user-count');

        if(response.is_interested){
            heart.classList.add('fa-solid');
            heart.classList.remove('far');
            like_count.innerHTML = parseInt(like_count.innerHTML)+1;
        } else{
            heart.classList.add('far');
            heart.classList.remove('fa-solid');
            like_count.innerHTML = parseInt(like_count.innerHTML)-1;
        }

    }else if(!response.success && !response.logged_in){

        window.$('#login-modal').modal('show');
    }
};

var on_error = (event)=>{
    document.getElementById("loading")
    .style.display="none";

    alert("Oops! Something went wrong");
};
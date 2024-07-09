window.addEventListener('load', function () {
    var hearts = document.querySelectorAll('.is-interested-image');
    hearts.forEach((heart)=>{
        heart.addEventListener('click', (event)=>{
            var property_id = event.target.getAttribute('property_id');

            var xhr = new XMLHttpRequest();
            xhr.open('GET','php/toggle_intrested.php?property_id='+property_id);

            xhr.addEventListener('load', remove_heart);
            xhr.addEventListener('error', on_error);

            xhr.send();

            document.querySelector('#loading').style.display='block';
            event.preventDefault();
        })
    })
})

var remove_heart = (event)=>{
    document.querySelector('#loading').style.display='none';

    var response = JSON.parse(event.target.responseText);

    if(response.success){
        var elem = document.querySelector(`[prop_no-${response.property_id}]`);
        console.log(elem);
        elem.style.position = 'absolute';
        elem.style.left = '-200%';
    }
};

var on_error = (event) => {
    document.getElementById("loading").style.display = "none";
  
    alert("Oops! Something went wrong");
  };
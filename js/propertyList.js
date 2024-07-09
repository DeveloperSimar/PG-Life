window.addEventListener("load", () => {
  heart_imgs = document.querySelectorAll(".is-interested-image");

  heart_imgs.forEach((heart_img) => {
    heart_img.addEventListener("click", (event) => {
      const xhr = new XMLHttpRequest();
      var property_id = event.target.getAttribute("data-property");
      console.log(property_id);
      xhr.open("GET", "php/toggle_intrested.php?property_id="+property_id);
      xhr.addEventListener("load", convert_heart);
      xhr.addEventListener("error", on_error);
      xhr.send();
      document.getElementById("loading").style.display = "block";
      event.preventDefault();
    });
  });
});

var convert_heart = (event) => {
  document.getElementById("loading").style.display = "none";


  var response = JSON.parse(event.target.responseText);
  var property_id = response.property_id;

  if (response.success) {
    var heart = document.querySelector(".property-"+property_id);
    var like_count = document.querySelector(".like_count_"+property_id);

    if (response.is_interested) {
      heart.classList.add("fa-solid");
      heart.classList.remove("far");
      like_count.innerHTML = parseInt(like_count.innerHTML) + 1;
    } else {
      heart.classList.add("far");
      heart.classList.remove("fa-solid");
      like_count.innerHTML = parseInt(like_count.innerHTML) - 1;
    }
  } else if (!response.success && !response.logged_in) {
    window.$("#login-modal").modal("show");
  }
};

var on_error = (event) => {
  document.getElementById("loading").style.display = "none";

  alert("Oops! Something went wrong");
};

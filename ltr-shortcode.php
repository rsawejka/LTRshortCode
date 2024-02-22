<?php

/*

* Plugin Name: LTR Short Code

* Description: Pull cards from trello

* Version: 1.0

* Author: Ryan Sawejka

* Author URI: Your URL

*/

add_shortcode( 'ltr', 'rs_ltr' );
function rs_lrt_init(){
 function rs_ltr() {
        ?>
        <script>
        

        const mainContainer = document.createElement('div');
        mainContainer.className = "pt-1 rs-card-container";

        const container = document.createElement('div');
    container.className += " row pt-1";
   const main = document.getElementById("main");
  var numLoop = 0;
   main.appendChild(mainContainer);
   mainContainer.appendChild(container);
  let cardRequest = new XMLHttpRequest();
  var buttons = [];
  cardRequest.open('GET', 'https://api.trello.com/1/lists/643579e2a62d257c40452f2d/cards?key=4b96071c08e505d8bdfce122eec3c099&token=ATTAc40360d328ddda444a87ad93789d6fd0e47e11d965c7a747b3b1803b583bbee792D481CB');

  cardRequest.send();

  cardRequest.addEventListener('load', function(){
     let data = JSON.parse(cardRequest.responseText);
    //  console.log(data);
    
    data.forEach(function(card){

      let coverRequest = new XMLHttpRequest();
  
  coverRequest.open('GET', 'https://api.trello.com/1/cards/' + card.id + '/attachments?key=4b96071c08e505d8bdfce122eec3c099&token=ATTAc40360d328ddda444a87ad93789d6fd0e47e11d965c7a747b3b1803b583bbee792D481CB');

  coverRequest.send();
  coverRequest.addEventListener('load', function(){
      let coverData = JSON.parse(coverRequest.responseText);
 //console.log(coverData);
  coverData.forEach(function(cover){
          //console.log(cover.previews[0].url)
          numLoop++;
          var animalName = card.name.replaceAll(' ','');
         // console.log(animalName);
          container.innerHTML += "<div class=' rs-animal-card col-xl-4 col-lg-6 col-md-6 mb-3'><div class='rs-card-border mr-2'><h3 class='rs-card-title px-2'>" + card.name + "</h3><div class='rs-background-img' style='background-image: url(" + cover.previews[5].url + "); background-position: center top; background-repeat: no-repeat; background-size: cover;height:550px;width: 100%;'></div><div class=' rs-card-body rs-card-body-" + card.name.replaceAll(' ','') + "' id='" + card.name.replaceAll(' ','') + "'><div class='rs-text-box'><p class='card-text p-3'>" + card.desc + ' If you are intrested in helping ' + card.name + ' find a new home please email <a href="mailto:Jessica@hawspets.org">Jessica@hawspets.org</a> today' + "</p><div style='text-align: center;'><a target='_blank' href='https://hawspets.org/foster-to-adopt-application-agreement/'><button style='padding: 10px; border: none; margin-top: 5px; margin-bottom: 10px; color: white; background-color: #88cd00; border-radius: 10px;'>Foster Application</button></a></div></div></div><p id='button-area-" + card.name.replaceAll(' ','') + "' class='card-text'><button onclick='showMore(" + animalName + ")' id='rs-button-" + card.name.replaceAll(' ','') + "' class='text-body-secondary rs-read-more'><div>Read More</div><span class='dashicons dashicons-arrow-down-alt'></span></button></p></div></div>";
//id='" + card.name.replaceAll(' ','') + "' ----> ID for the card above
      
  })

  })
    });
  });   
  
  function showMore(rsName){
      console.log(rsName.id);
      var selectedElement = document.getElementById(rsName.id);
          selectedElement.classList.remove("rs-card-body");
      var selectedButton = document.getElementById("rs-button-" + rsName.id);
          selectedButton.style.display = "none";
      var buttonArea = document.getElementById("button-area-" + rsName.id);
          buttonArea.innerHTML = "<button class='rs-read-more' id='showLess-" + rsName.id  +"' onclick='showLess(" + rsName.id + ")'><span class='dashicons dashicons-arrow-up-alt'></span><div>Show Less</div></button>";
  }

  function showLess(rsNameLess){
    console.log(rsNameLess.id);
    var selectedElementShowLess = document.getElementById(rsNameLess.id);
        selectedElementShowLess.classList.add("rs-card-body");
    var showLessButton = document.getElementById("showLess-" + rsNameLess.id);
        showLessButton.style.display = "none";
    //   var selectedButtonLess = document.getElementById("rs-button-" + rsNameLess.id);
    // selectedButtonLess.style.display = "block";
    var buttonAreaLess = document.getElementById("button-area-" + rsNameLess.id);
    buttonAreaLess.innerHTML = "<button onclick='showMore(" + rsNameLess.id + ")' id='rs-button-" + rsNameLess.id.replaceAll(' ','') + "' class='text-body-secondary rs-read-more'><div>Read More</div><span class='dashicons dashicons-arrow-down-alt'></span></button>";
  }

</script>
<?php
}
}
add_action('init', 'rs_lrt_init');

?>
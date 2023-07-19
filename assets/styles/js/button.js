var animateButton = function(e) {

    e.preventDefault;
    //reset animation
    e.target.classList.remove('animate');
    
    e.target.classList.add('animate');
    setTimeout(function(){
      e.target.classList.remove('animate');
    },700);
  };
  
  var mybutton = document.getElementsByClassName("mybutton");
  
  for (var i = 0; i < mybutton.length; i++) {
    mybutton[i].addEventListener('click', animateButton, false);
  }
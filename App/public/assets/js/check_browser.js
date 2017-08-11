var validNavigation = false;
function removeCurrentUserCart() {

  alert('ok');

  $.ajax({

    url:"/ajax/remove_cart_history.php",
    method:"post",
    dataType :'json',
    data :{
      ip : 'ip'
     
    },
    success:function(data){

      if (data.exists==true) {
        
       alert('ok');
        return true;
      }
    },
    error:function(){

      return false;
    }
  });
}
 
function detectBrowserClose() {

  // alert('OK');

  window.addEventListener("beforeunload", function (e) {

    if (!validNavigation) {
      removeCurrentUserCart();
      //var confirmationMessage = removeCurrentUserCart();

      //e.returnValue = confirmationMessage;     // Gecko, Trident, Chrome 34+
                     // Gecko, WebKit, Chrome <34
      }
    
  });

  $("a").on("click", function() {
    validNavigation = true;
  });

  $(document).on('keydown', function(e) {
    if ((e.which || e.keyCode)==116){
      validNavigation = true;
      
    }
  });

}
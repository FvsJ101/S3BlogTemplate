/**
 * Created by User on 25/09/2016.
 */

//TEST JQUERY
/*window.onload = function() {
    if (window.jQuery) {
        // jQuery is loaded
        alert("Yeah!");
    }
};*/

$(function () {

    
    dynamicActiveClass();
   // flashMessageClose();
    
    // DYNAMICALLY ADD ACTIVE CLASS TO MENU ITEM
    function dynamicActiveClass() {
        var pathNameOfCurrentPage = window.location.pathname;
        
        $('a[href="' + pathNameOfCurrentPage + '"]').parent().addClass('active');
        
    }
    
   // function flashMessageClose() {
        $('#flashClose').on('click', function () {
            $('#flashClose').parent().fadeOut( "slow" );
        });
    //}
  
  
});
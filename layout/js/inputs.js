$(document).ready(function () {
   
   // Page SignUp
   //// اظهاء واخفاء كلمة المرور
   $("body").on("click", ".hidePassword", function () {
       
        if ( $(this).text() == "visibility" ) {
            $(this).text("visibility_off");
            $(this).siblings("input").attr("type", "text");
        } else {
            $(this).text("visibility");
            $(this).siblings("input").attr("type", "password");
        }
   });
   // End SignUp
    
});
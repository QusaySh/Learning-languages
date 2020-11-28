$(document).ready(function (){
    $('.sidenav').sidenav({edge: "right"}); // استدعاء السايد بار
    $('select').formSelect(); // استدعاء السيليكت
    $('input#username, input#password, input#new_password, textarea#textarea2').characterCounter(); // عداد الانبوت
    $('.tabs').tabs(); // Tabs
    $('.dropdown-trigger').dropdown({constrainWidth: false});
    $('.collapsible').collapsible();
    $('.modal').modal();
    
    setTimeout(function () {
        $(".downloadApp a").toggleClass("scale-out");
    }, 15000);
    
});
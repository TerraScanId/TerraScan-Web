/*---------------------------------------------------------------------
    File Name: custom.js
---------------------------------------------------------------------*/

$(function() {

    "use strict";
  
    /* Navbar toggle
    -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- */
  
    $(document).ready(function(){
      $(".navbar-toggler").click(function(){
          $(".navbar-collapse").toggleClass("show");
      });
  });

  
    /* Tooltip
    -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- */
  
    $(document).ready(function() {
      $('[data-toggle="tooltip"]').tooltip();
    });
  
  
  
    /* Mouseover
    -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- */
  
    $(document).ready(function() {
      $(".main-menu ul li.megamenu").mouseover(function() {
        if (!$(this).parent().hasClass("#wrapper")) {
          $("#wrapper").addClass('overlay');
        }
      });
      $(".main-menu ul li.megamenu").mouseleave(function() {
        $("#wrapper").removeClass('overlay');
      });
    });
  
  
  
    /* Toggle sidebar
    -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- */
  
    $(document).ready(function() {
      $('#sidebarCollapse').on('click', function() {
        $('#sidebar').toggleClass('active');
        $(this).toggleClass('active');
      });
    });
  
    /* Product slider 
    -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- */
    // optional
    $('#blogCarousel').carousel({
      interval: 5000
    });
  

    /** Chatbox **/
    $(document).ready(function() {
      const chatBox = $("#chatBox-container");
      chatBox.hide();
      const toggleChat = $("#toggleChat");
  
      let isChatboxVisible = false;
      function toggleChatbox() {
        if (isChatboxVisible) {
          // Jika terlihat, ubah ke dropdown
          $("#toggleChat i").removeClass("fa-angle-down").addClass("fa-message");

        } else {
          // Jika tidak terlihat, ubah ke message
          $("#toggleChat i").removeClass("fa-message").addClass("fa-angle-down");

        }
        chatBox.toggle("slide:right");
        isChatboxVisible = !isChatboxVisible;
      }
      
      toggleChat.click(function() {
        toggleChatbox();
      });

  
    });
  
  
  
  });
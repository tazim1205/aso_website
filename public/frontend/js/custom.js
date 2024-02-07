(function($){
    'use strict';


    $('.all-bid').on('click', function(){

        $('.sure').show();

    });
   
   






    
    $('.location').on('click', function(){

        $('.loc-area').slideToggle();

    });

    
    $('.bajed').on('click', function(){

        $('.pop-up-2-b').slideToggle();
    });
    $('.pop-up-2-as').on('click', function(){

        $('.pop-up-2-b').slideToggle();
    });


    $('.dtime').on('click', function(){

        $('.pop-up-d').slideToggle();
    });
    $('.pop-up-2-c').on('click', function(){

        $('.pop-up-d').slideToggle();
    });



    $('.rating').on('click', function(){

        $('.w-pop-up-1').slideToggle();
    });
    $('.rating-1').on('click', function(){

        $('.w-pop-up-1').slideToggle();
    });



    
    $('.delivary').on('click', function(){

        $('.w-pop-up-2').slideToggle();
    });
    $('.rating-2').on('click', function(){

        $('.w-pop-up-2').slideToggle();
    });


    $('.order-x').on('click', function(){

        $('.w-pop-up-3').slideToggle();
    });
    $('.rating-3').on('click', function(){

        $('.w-pop-up-3').slideToggle();
    });
    





    $('.sb').on('click', function(){

        $('.qn').slideToggle();
    });
    $('.sb-1').on('click', function(){

        $('.qn-1').slideToggle();
    });
    $('.sb-2').on('click', function(){

        $('.qn-2').slideToggle();
    });


    $('.sb-1').on('click', function(){

        $('.qn').hide();
    });
    $('.sb-2').on('click', function(){

        $('.qn').hide();
    });


    $('.sb').on('click', function(){

        $('.qn-1').hide();
    });
    $('.sb-2').on('click', function(){

        $('.qn-1').hide();
    });
   

    
    $('.sb').on('click', function(){

        $('.qn-2').hide();
    });
    $('.sb-1').on('click', function(){

        $('.qn-2').hide();
    });









    $('.complain').on('click', function(){

        $('.pop-12').slideToggle();

    });

    $('.cancel').on('click', function(){

        $('.pop-12').slideToggle();

    });




    $('.menu-icon i').on('click', function(){

        $('.three-dot').slideToggle();

    });

    $('.bar-cross i').on('click', function(){

        $('.three-dot').slideToggle();

    });

    $('.three-dot-2').on('click', function(){

        $('.three-dot').slideToggle();

    });








    $('.s-icon').on('click', function(){

        $('.search').slideToggle();

    });

    $('.s-cross-1 i').on('click', function(){

        $('.search').slideToggle();

    });








    $('.db').on('click', function(){

        $('.db-1').slideToggle();

    });

    $('.db-2').on('click', function(){

        $('.db-1').slideToggle();

    });







    $('.forget-pass-1').on('click', function(){

        $('.forget-pass').slideToggle();

    });


    $('.service-6').on('click', function(){

        $('.service-3').slideToggle();
        $('.service-6').hide();
        $('.service-5').show();

      
    });

    $('.service-5').on('click', function(){

        $('.service-3').slideToggle();
        $('.service-6').show();
        $('.service-5').hide();

      
    });


    $('.service-66').on('click', function(){

        $('.service-33').slideToggle();
        $('.service-55').show();
        $('.service-66').hide();

      
    });

    $('.service-55').on('click', function(){

        $('.service-33').slideToggle();
        $('.service-55').hide();
        $('.service-66').show();

      
    });




    $('.cn-pass').on('click', function(){

        $('.write-pass').show();

      
    });

    $('.cn-2').on('click', function(){

        $('.write-pass').hide();
      
    });

    $('.signout').on('click', function(){

        $('.write-pass-1').show();
      
    });
    $('.cn-2').on('click', function(){

        $('.write-pass-1').hide();
      
    });





    $('.colo').on('click', function(){

        $('.color-pic').slideToggle();
      
    });

    $('.colo-1').on('click', function(){

        $('.color-pic').slideToggle();
      
    });

    
    $('.colo-2').on('click', function(){

        $('.lc').slideToggle();
      
    });

    $('.colo-2').on('click', function(){

        $('.lc-1').slideToggle();
      
    });


    $('.privacy-1').on('click', function(){

        $('.privacy').slideToggle();
      
    });

    $('.colo-3').on('click', function(){

        $('.privacy').slideToggle();
      
    });


    $('.u-1').on('click', function(){

        $('.u-2').slideToggle();
      
    });
    


    $('.r-area-1').on('click', function(){

        $('.r-area').slideToggle();
      
    });


















    $('.rep h3').on('click', function(){

        $('.rep-1').slideToggle();
        $('.rep-1').css({
            display : 'flex'
        });
      
    });


    $('.ans h3').on('click', function(){

        $('.ans-1').slideToggle();
        $('.ans-1').css({
            display : 'flex'
        });
      
    });











   




  
    $('.l-item-1').on('click', function(){

        $('.tab-1').show();
        $('.tab-2 , .tab-3 , .tab-4').css({
            display : 'none'
        });

        $('.l-item-2 , .l-item-3 , .l-item-4').css({
            background : 'transparent'
           
        });
        $('.l-item-1').css({
            background : 'linear-gradient(95.14deg, #4E5897 0%, #141727 100%)'
           
        });

        $('.cl-1').css({
            color : '#fff'
           
        });

        $('.cl-2 , .cl-3 , .cl-4').css({
            color : '#000'
           
        });
      
    });


    $('.l-item-2').on('click', function(){

        $('.tab-2').show();
        $('.tab-1 , .tab-3 , .tab-4').css({
            display : 'none'
        });

        $('.l-item-1 , .l-item-3 , .l-item-4').css({
            background : 'transparent'
           
        });
        $('.l-item-2').css({
            background : 'linear-gradient(92.32deg, #17AD37 0%, #92E92E 100%)'
           
        });

        $('.cl-2').css({
            color : '#fff'
           
        });

        $('.cl-1 , .cl-3 , .cl-4').css({
            color : '#000'
           
        });
      
    });


    $('.l-item-3').on('click', function(){

        $('.tab-3').show();
        $('.tab-1 , .tab-2 , .tab-4').css({
            display : 'none'
          
        });

        $('.l-item-1 , .l-item-2 , .l-item-4').css({
            background : 'transparent'
           
        });
        $('.l-item-3').css({
            background : 'linear-gradient(95.14deg, #4E5897 0%, #141727 100%)'
           
        });


        $('.cl-3').css({
            color : '#fff'
           
        });

        $('.cl-1 , .cl-2 , .cl-4').css({
            color : '#000'
           
        });
      
    });


    $('.l-item-4').on('click', function(){

        $('.tab-4').show();
        $('.tab-1 , .tab-2 , .tab-3').css({
            display : 'none'
        });
        $('.l-item-1 , .l-item-3 , .l-item-2').css({
            background : 'transparent'
           
        });
        $('.l-item-4').css({
            background : 'linear-gradient(92.32deg, #D2433C 0%, #BF0836 100%)'
           
        });


        $('.cl-4').css({
            color : '#fff'
           
        });

        $('.cl-1 , .cl-3 , .cl-2').css({
            color : '#000'
           
        });
    });










    
    $('.item-1').on('click', function(){

        $('.bid-order').show();
        $('.gig-order , .service-order , .special-order').css({
            display : 'none'
        });

        $('.item-1').css({
            borderBottom: '2px solid #4E5897'
        });
        $('.item-2 , .item-3 , .item-4').css({
            borderBottom: 'none'
        });
      
      
      
    });

    $('.item-2').on('click', function(){

        $('.gig-order').show();
        $('.bid-order , .service-order , .special-order').css({
            display : 'none'
        });

        $('.item-2').css({
            borderBottom: '2px solid #4E5897'
        });
        $('.item-1 , .item-3 , .item-4').css({
            borderBottom: 'none'
        });
      
      
      
    });




    $('.item-3').on('click', function(){

        $('.service-order').show();
        $('.gig-order , .bid-order , .special-order').css({
            display : 'none'
        });

        $('.item-3').css({
            borderBottom: '2px solid #4E5897'
        });
        $('.item-2 , .item-1 , .item-4').css({
            borderBottom: 'none'
        });
      
      
      
    });



    $('.item-4').on('click', function(){

        $('.special-order').show();
        $('.gig-order , .service-order , .bid-order').css({
            display : 'none'
        });

        $('.item-4').css({
            borderBottom: '2px solid #4E5897'
        });
        $('.item-2 , .item-3 , .item-1').css({
            borderBottom: 'none'
        });
      
      
      
    });







    

    $('.off').on('click', function(){

        $('.on').show();
        $('.off').css({
            display : 'none'
        });
      
    });
    $('.on').on('click', function(){

        $('.off').show();
        $('.on').css({
            display : 'none'
        });
      
    });

    $('.off-1').on('click', function(){

        $('.on-1').show();
        $('.off-1').css({
            display : 'none'
        });
      
    });
    $('.on-1').on('click', function(){

        $('.off-1').show();
        $('.on-1').css({
            display : 'none'
        });
      
    });

    $('.off-2').on('click', function(){

        $('.on-2').show();
        $('.off-2').css({
            display : 'none'
        });
      
    });
    $('.on-2').on('click', function(){

        $('.off-2').show();
        $('.on-2').css({
            display : 'none'
        });
      
    });







    $('.page-1').on('click', function(){

        $('.page').show();
        $('.gig').css({
            display : 'none'

        });
        $('.gig-1').css({
            borderBottom : 'none'

        });
        $('.page-1').css({
            borderBottom : '2px solid #4E5897'

        });
      
      

    });
    
    $('.gig-1').on('click', function(){

        $('.gig').show();
        $('.page').css({
            display : 'none'

        });

        $('.page-1').css({
            borderBottom : 'none'

        });
        $('.gig-1').css({
            borderBottom : '2px solid #4E5897'

        });

    });






















   

   

   
    
   
    



   





    







    




   



})(jQuery);
(function($) {

    //console.log( 'Hello x DIOS scripts.js');

    $(document).ready(function(){

        $(document).on('click', '.cat-list-item > a', function(e){
            e.preventDefault();
            console.log ("dale click ok");

            var category = $(this).data('category');

            $.ajax({
                url: wp_ajax.ajax_url,
                data: { action: 'filter', category: category },
                type: 'post',
                success: function(result) {
                   //$('.cat-list-2').html(result);
                   $('.le-pedido-box-result').html(result);
                },
                error: function(result) {
                    console.warn(result);
                },
            });
        });
        //console.log ("hello 1");
        
        //$('.cat-list').html("hello 2");
    });

    $(document).ready(function(){
        
        $(document).on('click', '.pagination a', function(e){
        //jQuery('.pagination a').live('click', function(e){
          e.preventDefault();
          console.log("mas");
          var link = jQuery(this).attr('href');
          //console.log( link );
          //$('.le-pedido-box-result').html('Loading...');
          $('.le-pedido-box-result').load(link+' .le-pedido-box-result');

          //jQuery('#ID').html('Loading...');
          //jQuery('#ID').load(link+' #contentInner');
           
          });
           
          });

})(jQuery);
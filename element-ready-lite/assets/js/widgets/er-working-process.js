(function ($) {
   $(window).on("elementor/frontend/init", function () {
       elementorFrontend.hooks.addAction("frontend/element_ready/er_working_process_widget.default", function($scope){
           var elementItems = $scope.find('.erwp-single-item');
           elementItems.each(function(index, element) {
               $(element).on('mouseover', function() {
                   if ((index + 1) == elementItems.length) {
                       return;
                   }
                   // Calculate the width percentage for the progress bar
                   var widthPercentage = ((index + 1) / (elementItems.length - 1)) * 80;
                   $('.erwp-progress-bar').css('width', widthPercentage + '%');
               });
           });

           // Reset the progress bar width when the mouse leaves the container
           $scope.find('.erwp-progress-container').on('mouseleave', function() {
               $scope.find('.erwp-progress-bar').css('width', '0');
           });
       });
   });
})(jQuery);
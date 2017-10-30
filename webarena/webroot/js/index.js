/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$(document).ready(function() {
    // use anonymous function to prevent clutter of the scope
(function() {
    var max_height = 0;
    var image = null;

    $('.carrousel-inner').each(function() {
      var cur_height = $(this).height();
      if (cur_height > max_height) {
          max_height = cur_height;
          image = this;
      }
    });

    // just an example
    $(image).addClass('tallest');
})();
} );
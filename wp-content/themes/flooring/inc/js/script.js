jQuery(document).ready(function ($) {
  "use strict";


  var flooring_font_family = "";
  var flooring_font_weight = "";
  var flooring_font_subsets = "";


  $("#tabs-2 select.font_familly").on('change',function () {
    flooring_font_family = $(this).find(":selected").val();

    $("#wd-google-fonts-css").attr("href", "http://fonts.googleapis.com/css?family=" + flooring_font_family + ":" + flooring_font_weight + "&subset=" + flooring_font_subsets);
    $(this).closest("tbody").find("p").css("font-family", flooring_font_family);
    $(this).closest("tbody").find("h2").css("font-family", flooring_font_family);
    $(this).closest("tbody").find("ul li").css("font-family", flooring_font_family);
  });

  $("#tabs-2 select.font_weight").on('change',function () {
    flooring_font_family = $(this).find(":selected").val();

    $(this).closest("tbody").find("p").css("font-weight", flooring_font_family);
    $(this).closest("tbody").find("h2").css("font-weight", flooring_font_family);
    $(this).closest("tbody").find("ul li").css("font-weight", flooring_font_family);
  });


  $("#tabs-2 select.text_transform").on('change',function () {
    flooring_font_family = $(this).find(":selected").val();

    $(this).closest("tbody").find("p").css("text-transform", flooring_font_family);
    $(this).closest("tbody").find("h2").css("text-transform", flooring_font_family);
    $(this).closest("tbody").find("ul li").css("text-transform", flooring_font_family);
  });

  $("#tabs-2 select.text_size").on('change',function () {
    flooring_font_family = $(this).find(":selected").val();
    $(this).closest("tbody").find("p").css("font-size", flooring_font_family + 'px');
    $(this).closest("tbody").find("h2").css("font-size", flooring_font_family + 'px');
    $(this).closest("tbody").find("ul li").css("font-size", flooring_font_family + 'px');
  });

  $("#tabs-2 select.font_subsets").on('change',function () {
    flooring_font_family = $(this).find(":selected").val();
    $("#wd-google-fonts-css").attr("href", "http://fonts.googleapis.com/css?family=" + flooring_font_family + ":" + flooring_font_weight + "&subset=" + flooring_font_subsets);
  });


  $('#flooring_show_adress_bar').on('change', function () {
    console.log($(this).attr("checked"));
    if ($(this).attr("checked")) {
      $('.address_bar_item').removeClass('hidden_item');
    } else {
      $('.address_bar_item').addClass('hidden_item');
    }
  });
  $('#flooring_menu_style').on('change', function () {
    console.log($(this).val());
    if ($(this).val() == 'corporate') {
      $('.corporate_bar_item').removeClass('hidden_item');
    }else{
      $('.corporate_bar_item').addClass('hidden_item');
    }
  });
//-------------social icon---------
  // Creating and Adding Dynamic Form Elements.
  var addButton = $('.add_button'); //Add button selector
  var datanumber;
  var output;
  var wrapper = $('.socialmedia_wrapper'); //Input field wrapper
  var x = 0; //Initial field counter is 1
  $(addButton).on('click', function () { //Once add button is clicked
    datanumber = $('.socialmedia_wrapper div:last-child').find('input').data('number');
    if (datanumber != undefined) {
      x = datanumber;
    }
    x++;
    output = '<div class="social_media">';
    output += '<select name="social_icon[icon' + x + ']">';
    output += '<option value="-1" selected disabled>Select social media icon</option>';
    output += '<option value="fa-facebook">&#xf09a; facebook</option>';
    output += '<option value="fa-flickr">&#xf16e; flickr</option>';
    output += '<option value="fa-google-plus">&#xf0d5; google-plus</option>';
    output += '<option value="fa-instagram">&#xf16d; instagram</option>';
    output += '<option value="fa-linkedin">&#xf0e1; linkedin</option>';
    output += '<option value="fa-twitter">&#xf099; twitter</option>';
    output += '<option value="fa-vimeo">&#xf27d; vimeo</option>';
    output += '<option value="fa-whatsapp">&#xf232; whatsapp</option>';
    output += '<option value="fa-youtube">&#xf167; youtube</option>';
    output += '</select>';
    output += '<input type="text" name="socialmedia_name[media' + x + ']" placeholder="Your social media link" data-number="' + x + '" value="">';
    output += '<a href="javascript:void(0);" class="remove_button" title="Remove socialmedia">';
    output += '<button type="button" class="button bg_delete_button">delete</button>';
    output += '</a>';
    output += '</div>';

    $(wrapper).append(output); // Add field html
  });
  $(wrapper).on('click', '.remove_button', function (e) { //Once remove button is clicked
    e.preventDefault();
    $(this).parent('div').remove(); //Remove field html
    x--;
  });


  $('.wd-color-picker').wpColorPicker(
    {format: 'rgba'}
  );
$('.footer-style').on('change', function(){
  $('.pn-copyright').toggle('.hiden');
});
  //---------------logo script-----------
  jQuery('#flooring_upload_btn').on('click',function () {
    wp.media.editor.send.attachment = function (props, attachment) {
      jQuery('#flooring_logo_path').val(attachment.url);
    }
    wp.media.editor.open(this);

    return false;
  });

  //---------------footer bg script-----------
  jQuery('#flooring_upload_bg_btn').on('click',function () {
    wp.media.editor.send.attachment = function (props, attachment) {
      jQuery('#flooring_footer_bg_path').val(attachment.url);
    }
    wp.media.editor.open(this);

    return false;
  });

  //------single background post script-----
  jQuery('#flooring_upload_single_post').on('click',function () {
    wp.media.editor.send.attachment = function (props, attachment) {
      jQuery('#flooring_bg_single_post_path').val(attachment.url);
    }
    wp.media.editor.open(this);
    return false;
  });
  //------tile background for pages-----
  jQuery('#flooring_upload_title_page_bg').on('click',function () {
    wp.media.editor.send.attachment = function (props, attachment) {
      jQuery('#flooring_bg_single_page').val(attachment.url);
    }
    wp.media.editor.open(this);
    return false;
  });




  /*--------------------------------------*/
  var curent_sreen = '';

  function flooring_add_ckeckbox_class() {
    curent_sreen = $("input:radio[name='flooring_start_screan']:checked").val();
    $("input[name='flooring_start_screan']").parent().removeClass('selected');

    $("input[value='" + curent_sreen + "'][name='flooring_start_screan']").parent().addClass('selected');
  }


  $("#tabs").tabs(); //initialize tabs
  $(function () {
    $("#tabs").tabs({
      activate: function (event, ui) {
        var scrollTop = $(window).scrollTop(); // save current scroll position
        window.location.hash = ui.newPanel.attr('id'); // add hash to url
        $(window).scrollTop(scrollTop); // keep scroll at current position
      }
    });
  });
  // reload the form when the checkbox is changed
  flooring_add_ckeckbox_class();
  $('.flooring_start_screan').on('click',function (e) {
    if (curent_sreen != $(this).val()) {
      flooring_add_ckeckbox_class();
      $(this).closest('form').submit();
    }
  });
  
  $('ul.g_tab li').on('click',function(){
    var tab_id = $(this).attr('data-tab');
    var fromParent = $(this).closest('.groups_tabs');
    console.log(fromParent);
    $('ul.g_tab li', fromParent).removeClass('current');
    $('.tab-content', fromParent).removeClass('current');
    $(this).addClass('current');
    $("#"+tab_id, fromParent).addClass('current');
  });
  
  
   //---------------images upload script-----------
   var mediaUploader;
   if (typeof wp !== "undefined" && wp.media && wp.media.editor) {
     jQuery('.add_image').on("click", function (e) {
       //wp.media.editor.send.attachment = function (props, attachment) {
       e.preventDefault();
       var fromParent = $(this).closest('.imgset'),
         buttonRemove = $('.remove_image', fromParent),
         panel_image_preview = $('.panel_image_preview', fromParent),
         img_input_field = $('.img_input_field', fromParent);
       wp.media.editor.send.attachment = function (props, attachment) {
         buttonRemove.show();
         panel_image_preview.show();
         panel_image_preview.attr('src', attachment.url);
         img_input_field.val(attachment.url);
        };
       wp.media.editor.open(this);
       return false;
     });
   }
  
   $('.remove_image').on("click", function () {
     $(this).parent().parent().find('.img_input_field').val('');
     $(this).parent().parent().find('img').attr('src', "");
     $(this).parent().parent().find('.panel_image_preview').hide();
     $(this).hide();
   });
  
   $('.cmn-toggle').on("click", function () {
    var parent = $(this).closest(".wd_checkbox");
    if ($(this).attr('checked')) {
      $(this).val('off');
      $(this).removeAttr('checked');
      if($(this).is('[name="show_the_logo"]')) {
        $('.imgset').fadeOut();
      }
    }
    else {
      $(this).val('on');
      $(this).attr("checked", "checked")
      if($(this).is('[name="show_the_logo"]')) {
        $('.imgset').fadeIn();
      }
    }
    $('.hidden_check', parent).val($(this).val());
  });
  //------- footer checkbox ----
  $('.flooring_footer_columns label').on("click", function () {
    $('.flooring_footer_columns label').removeClass('label_selected ');
    $(this).addClass('label_selected ');
  });

  if (typeof wp.media !== 'undefined') {

    var _custom_media = true, _orig_send_attachment = wp.media.editor.send.attachment;

    $('.uploader .button').on('click',function (e) {
      var send_attachment_bkp = wp.media.editor.send.attachment;
      var button = $(this);
      var id = button.attr('id').replace('_button', '');
      _custom_media = true;
      wp.media.editor.send.attachment = function (props, attachment) {
        if (_custom_media) {
          $("#" + id).val(attachment.url);
        } else {
          return _orig_send_attachment.apply(this, [props, attachment]);
        }
        ;
      };

      wp.media.editor.open(button);
      return false;
    });

    $('.add_media').on('click', function () {
      _custom_media = false;
    });

  }

  $('.logo_position').on('change', 'input[name=flooring_logo_position]:radio', function (e) {
    var input_value = $(this).attr('id');
    $('.logo_position label').removeClass("label_selected");
    $("." + input_value).addClass("label_selected");
  });
  $('.import-demo-screenshot').on('change', 'input[name=flooring_footer_columns]:radio', function (e) {
    var input_value = $(this).attr('id');
    $('.flooring_footer_columns label').removeClass("label_selected");
    $("." + input_value).addClass("label_selected");
  });

  $('.import-demo-screenshot').on('change', 'input[name=demo_screenshot]:radio', function (e) {
    var input_value = $(this).attr('id');
    $('.import-demo-screenshot label').removeClass("label_selected");
    $("." + input_value).addClass("label_selected");
  });
//---------page setting-----------
  $(function () {
    $('#flooring_page_title_area_style').on('change',function () {
      var selected = $(this).find(':selected').text();
      //alert(selected);
      if (selected == 'Standard Style') {
        $(".flooring_show_hide.float_left").hide();
      } else {
        $(".flooring_show_hide.float_left").show();
      }
      //$('#' + selected).show();
    }).change()
  });



});

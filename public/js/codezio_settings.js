$(document).ready( function() {

    $('body').append('<a href="#" id="theme_switcher">asdsad</a><div id="switcher_panel"><span>PREDEFINED COLORS</span><ul class="colours"><li><a href="#" class="blue"></a></li><li><a href="#" class="green"></a></li><li><a href="#" class="grey"></a></li><li><a href="#" class="orange"></a></li><li><a href="#" class="red"></a></li><li><a href="#" class="turqoise"></a></li><li><a href="#" class="purple"></a></li><li><a href="#" class="yellow"></a></li></ul><div class="clear"></div><span>THEME MAIN COLOR</span><div id="theme_color" class="color_s"><div></div></div></a><div class="clear"></div><span>SLIDER BG COLOR</span><div id="slider_color" class="color_s"><div></div></div></a><div class="clear"></div><span>PAGE LAYOUT</span><select name="page_layout" id="page_layout"><option value="boxed">Boxed</option><option value="fluid">Fluid</option></select><div class="clear"></div><span>HEADER STYLE</span><select name="header_style" id="header_style"><option value="layered">Layer Slider</option><option value="cover">Mockup Slider</option><option value="minimal">Minimal Header</option></select><div class="clear"></div><span>BG PATTERN</span><select name="pattern" id="pattern"><option value="1.png">Pattern 1</option><option value="2.png">Pattern 2</option><option value="3.png">Pattern 3</option><option value="4.png">Pattern 4</option><option value="5.png">Pattern 5</option><option value="6.png">Pattern 6</option><option value="7.png">Pattern 7</option><option value="8.png">Pattern 8</option><option value="9.png">Pattern 9</option><option value="10.png">Pattern 10</option><option value="11.png">Pattern 11</option><option value="12.png">Pattern 12</option><option value="13.png">Pattern 13</option><option value="14.png">Pattern 14</option><option value="15.png">Pattern 15</option><option value="16.png">Pattern 16</option><option value="17.png">Pattern 17</option><option value="18.png">Pattern 18</option><option value="19.png">Pattern 19</option><option value="20.png">Pattern 20</option><option value="21.png">Pattern 21</option><option value="22.png">Pattern 22</option><option value="23.png">Pattern 23</option></select></div><style type="text/css">#theme_switcher {background-image: url(images/codezio_settings.png);background-repeat: no-repeat;background-position: center center;position: fixed;background-color: #FFFFFF;left: 0;top: 50px;width: 40px;height: 40px;display: block;text-indent: -9999px;-webkit-transition: 300ms ease-in all;-moz-transition: 300ms ease-in all;-ms-transition: 300ms ease-in all;-o-transition: 300ms ease-in all;transition: 300ms ease-in all;}#theme_switcher.opened {background-image: url(images/codezio_settings_hover.png);left: 160px;}#switcher_panel {z-index: 9999;width: 160px;background-color: #FFFFFF;padding-bottom: 20px;position: fixed;top: 50px;left: -160px;opacity: 0;-webkit-transition: 300ms ease-in all;-moz-transition: 300ms ease-in all;-ms-transition: 300ms ease-in all;-o-transition: 300ms ease-in all;transition: 300ms ease-in all;}#switcher_panel.opened {left: 0;opacity: 1;-webkit-transition: 300ms ease-in all;-moz-transition: 300ms ease-in all;-ms-transition: 300ms ease-in all;-o-transition: 300ms ease-in all;transition: 300ms ease-in all;}#switcher_panel span {font-size: 12px;color: #666666;padding: 10px;display: block;}ul.colours {padding: 0px;margin: 4px;display: block;}ul.colours li {float: left;margin: 8px;}ul.colours li a {width: 20px;height: 20px;border: 1px solid #F7F7F7;display: list-item;-webkit-transition: 200ms ease-in all;-moz-transition: 200ms ease-in all;-ms-transition: 200ms ease-in all;-o-transition: 200ms ease-in all;transition: 200ms ease-in all;}ul.colours li a.blue {background-color: #3498DB;}ul.colours li a.green {background-color: #26AE5F;}ul.colours li a.grey {background-color: #7F8C8D;}ul.colours li a.orange {background-color: #E67E22;}ul.colours li a.red {background-color: #E74C3C;}ul.colours li a.turqoise {background-color: #1ABC9C;}ul.colours li a.purple {background-color: #9B59B6;}ul.colours li a.yellow {background-color: #F1C40F;}ul.colours li a:hover {border: 1px solid #EEEEEE;opacity: .5;}select {margin-left: 10px;}.color_s {margin-left: 10px;}</style>');

});

$('#theme_switcher').live('click', function() {

    $('#switcher_panel, #theme_switcher').toggleClass('opened');

});

$('#pattern').live('change', function() { 
    get_pattern = $('#pattern option:selected').val();
    $('body').css('background-image','url(images/patterns/'+get_pattern+')');
});

$('#page_layout').live('change', function() { 

    get_layout = $('#page_layout option:selected').val();

    if(get_layout=='boxed') {
        $('body').removeClass('fluid');
    } else {
        $('body').removeClass('fluid').addClass('fluid');
    }

});

$('#header_style').live('change', function() { 
    get_header = $('#header_style option:selected').val();

    if(get_header == 'minimal') {
        window.location = 'index_minimal.html';
    } else if(get_header == 'layered') {
        window.location = 'index_layered_slider.html';
    } else if(get_header == 'cover') {
        window.location = 'index_cover.html';
    } 
    
});

$('.colours li a').live('click', function() {

    $('#colorize').attr('href','css/predefineds/'+$(this).attr('class')+'.css');
    return false;

});

$.cssHooks.backgroundColor = {
    get: function(elem) {
        if (elem.currentStyle)
            var bg = elem.currentStyle["backgroundColor"];
        else if (window.getComputedStyle)
            var bg = document.defaultView.getComputedStyle(elem,
                null).getPropertyValue("background-color");
        if (bg.search("rgb") == -1)
            return bg;
        else {
            bg = bg.match(/^rgb\((\d+),\s*(\d+),\s*(\d+)\)$/);
            function hex(x) {
                return ("0" + parseInt(x).toString(16)).slice(-2);
            }
            return "#" + hex(bg[1]) + hex(bg[2]) + hex(bg[3]);
        }
    }
}

$(document).ready( function() {

    $('#theme_color div').css('background-color',$('#copyright').css('backgroundColor'));
    $('#slider_color div').css('background-color',$('.slider-wrapper').css('backgroundColor'));

    $('#theme_color').ColorPicker({
        color: $("body").css("background-color"),
        onShow: function (colpkr) {
            $(colpkr).fadeIn(500);
            return false;
        },
        onHide: function (colpkr) {
            $(colpkr).fadeOut(500);
            return false;
        },
        onSubmit: function(hsb, hex, rgb, el) {
            $('#theme_color div').css('backgroundColor', '#' + hex);
            $('body').append('<style type="text/css">input[type="submit"], footer #copyright, .content.color, section .container.none_bottom .content.color:after, section .button, .slider .button, section .features li a:hover i, section #screens li a div:before, #toTop a, header .header.fixed #menu_cover, header .header.fixed #menu_cover:before, header .header.fixed #menu_cover:after, section aside .module .content .tags a, header .header.layered .tint {background-color: #'+hex+';}textarea, input, section .download li a i:before, section .features li a i:before, section .features li a:hover span, section #filters li a, #team_members .team_member .title .name, #contact p a, #toTop div, header .header nav#menu ul li a.current, section aside .module .content .posts li a:hover span, section #blog .breadcrumb ul li a {color: #'+hex+';}section .features li a:hover i {border: 3px solid #'+hex+';}textarea:hover, input:hover, section #team_members .team_member:hover .photo {border: 1px solid #'+hex+';}textarea:focus, input:focus {border: 1px solid #'+hex+';-webkit-box-shadow: inset 0px 0px 0px 3px #'+hex+';-moz-box-shadow: inset 0px 0px 0px 3px #'+hex+';box-shadow: inset 0px 0px 0px 3px #'+hex+';}section aside .module .content .tags a:before {border-color: transparent #'+hex+' transparent transparent;}</style>');
            $(el).ColorPickerHide();
        },
        onChange: function (hsb, hex, rgb) {
            $('#theme_color div').css('backgroundColor', '#' + hex);
            $('body').append('<style type="text/css">input[type="submit"], footer #copyright, .content.color, section .container.none_bottom .content.color:after, section .button, .slider .button, section .features li a:hover i, section #screens li a div:before, #toTop a, header .header.fixed #menu_cover, header .header.fixed #menu_cover:before, header .header.fixed #menu_cover:after, section aside .module .content .tags a, header .header.layered .tint {background-color: #'+hex+';}textarea, input, section .download li a i:before, section .features li a i:before, section .features li a:hover span, section #filters li a, #team_members .team_member .title .name, #contact p a, #toTop div, header .header nav#menu ul li a.current, section aside .module .content .posts li a:hover span, section #blog .breadcrumb ul li a {color: #'+hex+';}section .features li a:hover i {border: 3px solid #'+hex+';}textarea:hover, input:hover, section #team_members .team_member:hover .photo {border: 1px solid #'+hex+';}textarea:focus, input:focus {border: 1px solid #'+hex+';-webkit-box-shadow: inset 0px 0px 0px 3px #'+hex+';-moz-box-shadow: inset 0px 0px 0px 3px #'+hex+';box-shadow: inset 0px 0px 0px 3px #'+hex+';}section aside .module .content .tags a:before {border-color: transparent #'+hex+' transparent transparent;}</style>');
        }
    });

    $('#slider_color').ColorPicker({
        color: $("body").css("background-color"),
        onShow: function (colpkr) {
            $(colpkr).fadeIn(500);
            return false;
        },
        onHide: function (colpkr) {
            $(colpkr).fadeOut(500);
            return false;
        },
        onSubmit: function(hsb, hex, rgb, el) {
            $('#slider_color div, .slider-wrapper').css('backgroundColor', '#' + hex);
            $(el).ColorPickerHide();
        },
        onChange: function (hsb, hex, rgb) {
            $('#slider_color div, .slider-wrapper').css('backgroundColor', '#' + hex);
            $('body').append('');
        }
    });
    
});
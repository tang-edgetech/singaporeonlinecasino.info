$(document).ready(function() {
    $(document).on('mouseenter', '#masthead .navbar li.menu-item-has-children', function() {
        var $this = $(this),
            $button;
    });
    // <li class="menu-item menu-item-lvl2 text-0-9 text-weight-400 text-uppercase pr-2 mr-4 position-relative live-dealer tag tag-hot" data-game-type="live-dealer" data-tag="hot">
    //     <a href="https://eupphuat.com/live-casino" role="button">Live Casino</a>
    // </li>
    
    // <li class="menu-item menu-item-lvl3 text-0-9 text-weight-400 text-uppercase text-center position-relative w-100 text-center tag tag-hot" data-tag="hot">
    //     <a href="https://eupphuat.com/yeebet/play/30" title="EU9 Casino">
    //         <img src="https://ano20.eucdnex.com/public/assets/provider/live-dealer/eu9_casino.webp" alt="EU9 Casino" width="100"/>
    //         <span class="d-none hide">EU9 Casino</span>
    //     </a>
    // </li>

    $(document).on('click', '#masthead .navbar .menu-toggler', function(e) {
        e.preventDefault();
        var $button = $(this),
            $navbar = $button.closest('nav.navbar'),
            $side_menu = $navbar.siblings('.side-menu-wrapper');
        $navbar.addClass('navbar-opened');
        $side_menu.addClass('open');
    });
    $(document).on('click', '#masthead .side-menu-wrapper .close-side-menu', function(e) {
        e.preventDefault();
        var $button = $(this),
            $side_menu = $button.closest('.side-menu-wrapper'),
            $navbar = $side_menu.siblings('.navbar');
        $navbar.removeClass('navbar-opened');
        $side_menu.removeClass('open');
    });
});
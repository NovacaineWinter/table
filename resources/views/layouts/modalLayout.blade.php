<div class="modalHeader">
    @yield('headerContent')
    <div id="closeModalButton">x</div>
</div>

<div id="modalContainer">
    <div class="halfwidth lefthalfwidth">
    	@yield('lefthalf')
    </div>
    <div class="halfwidth">
    	@yield('righthalf')
    </div>
</div>
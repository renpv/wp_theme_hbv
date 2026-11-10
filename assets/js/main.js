/**
 * História de Boa Viagem — Memória
 * JavaScript sem dependências: menu responsivo, filtro de listas, copiar link e voltar ao topo.
 */
( function () {
	'use strict';

	var doc = document;

	/* ---------- Menu principal ---------- */
	var toggle = doc.querySelector( '.hbv-nav-toggle' );
	var nav = doc.getElementById( 'hbv-primary-nav' );

	if ( toggle && nav ) {
		toggle.addEventListener( 'click', function () {
			var open = nav.classList.toggle( 'is-open' );
			toggle.setAttribute( 'aria-expanded', open ? 'true' : 'false' );
		} );
	}

	// Botão para abrir submenus (toque e teclado).
	doc.querySelectorAll( '.hbv-menu li.menu-item-has-children' ).forEach( function ( item ) {
		var link = item.querySelector( ':scope > a' );
		if ( ! link ) { return; }
		var btn = doc.createElement( 'button' );
		btn.type = 'button';
		btn.className = 'hbv-subtoggle';
		btn.setAttribute( 'aria-expanded', 'false' );
		btn.setAttribute( 'aria-label', 'Abrir submenu de ' + link.textContent.trim() );
		link.insertAdjacentElement( 'afterend', btn );
		btn.addEventListener( 'click', function () {
			var open = item.classList.toggle( 'is-open' );
			btn.setAttribute( 'aria-expanded', open ? 'true' : 'false' );
		} );
	} );

	// Esc fecha submenus abertos.
	doc.addEventListener( 'keydown', function ( e ) {
		if ( e.key !== 'Escape' ) { return; }
		doc.querySelectorAll( '.hbv-menu li.is-open' ).forEach( function ( li ) {
			li.classList.remove( 'is-open' );
			var b = li.querySelector( ':scope > .hbv-subtoggle' );
			if ( b ) { b.setAttribute( 'aria-expanded', 'false' ); }
		} );
	} );

	/* ---------- Filtro de listas (biografias, logradouros) ---------- */
	function normalize( s ) {
		return ( s || '' ).toString().toLowerCase().normalize( 'NFD' ).replace( /[̀-ͯ]/g, '' );
	}

	doc.querySelectorAll( '[data-hbv-filter]' ).forEach( function ( input ) {
		var scope = doc.querySelector( input.getAttribute( 'data-hbv-filter' ) );
		if ( ! scope ) { return; }
		var items = scope.querySelectorAll( '[data-hbv-item]' );
		var groups = scope.querySelectorAll( '[data-hbv-group]' );
		var counter = doc.getElementById( input.id + '-count' );

		input.addEventListener( 'input', function () {
			var q = normalize( input.value.trim() );
			var shown = 0;
			items.forEach( function ( li ) {
				var hit = q === '' || normalize( li.textContent ).indexOf( q ) !== -1;
				li.hidden = ! hit;
				if ( hit ) { shown++; }
			} );
			groups.forEach( function ( g ) {
				g.hidden = g.querySelectorAll( '[data-hbv-item]:not([hidden])' ).length === 0;
			} );
			if ( counter ) {
				counter.textContent = q === '' ? '' : shown + ( shown === 1 ? ' resultado' : ' resultados' );
			}
		} );
	} );

	/* ---------- Copiar link ---------- */
	doc.querySelectorAll( '[data-hbv-copy]' ).forEach( function ( btn ) {
		btn.addEventListener( 'click', function () {
			var url = btn.getAttribute( 'data-hbv-copy' );
			var label = btn.textContent;
			var done = function () {
				btn.textContent = 'Link copiado';
				setTimeout( function () { btn.textContent = label; }, 2000 );
			};
			if ( navigator.clipboard && navigator.clipboard.writeText ) {
				navigator.clipboard.writeText( url ).then( done, function () { window.prompt( 'Copie o link:', url ); } );
			} else {
				window.prompt( 'Copie o link:', url );
			}
		} );
	} );

	/* ---------- Voltar ao topo ---------- */
	var top = doc.querySelector( '.hbv-totop' );
	if ( top ) {
		var onScroll = function () { top.hidden = window.scrollY < 600; };
		window.addEventListener( 'scroll', onScroll, { passive: true } );
		onScroll();
		top.addEventListener( 'click', function () {
			var reduce = window.matchMedia && window.matchMedia( '(prefers-reduced-motion: reduce)' ).matches;
			window.scrollTo( { top: 0, behavior: reduce ? 'auto' : 'smooth' } );
		} );
	}
}() );

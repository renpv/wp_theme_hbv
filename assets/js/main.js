/**
 * História de Boa Viagem — Memória
 * JavaScript sem dependências: menu responsivo, tema claro/escuro, barra inferior do celular,
 * filtro de listas, copiar link e voltar ao topo.
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

	/* ---------- Tema claro, escuro ou automático ---------- */
	// O atributo data-theme é aplicado antes da pintura por um script curto no <head> (functions.php).
	var root = doc.documentElement;
	var themeButtons = doc.querySelectorAll( '[data-hbv-theme]' );

	function currentTheme() {
		var t = root.getAttribute( 'data-theme' );
		return t === 'light' || t === 'dark' ? t : 'auto';
	}

	function paintTheme() {
		var current = currentTheme();
		themeButtons.forEach( function ( b ) {
			b.setAttribute( 'aria-pressed', b.getAttribute( 'data-hbv-theme' ) === current ? 'true' : 'false' );
		} );
	}

	function setTheme( choice ) {
		if ( choice === 'light' || choice === 'dark' ) {
			root.setAttribute( 'data-theme', choice );
		} else {
			root.removeAttribute( 'data-theme' );
		}
		try {
			if ( choice === 'light' || choice === 'dark' ) {
				window.localStorage.setItem( 'hbv-theme', choice );
			} else {
				window.localStorage.removeItem( 'hbv-theme' );
			}
		} catch ( e ) { /* navegação privada ou armazenamento bloqueado: vale só nesta página */ }
		paintTheme();
	}

	if ( themeButtons.length ) {
		doc.querySelectorAll( '.hbv-theme' ).forEach( function ( group ) { group.hidden = false; } );
		themeButtons.forEach( function ( b ) {
			b.addEventListener( 'click', function () { setTheme( b.getAttribute( 'data-hbv-theme' ) ); } );
		} );
		paintTheme();
	}

	/* ---------- Barra inferior do celular e painel "Menu" ---------- */
	var sheet = doc.getElementById( 'hbv-sheet' );
	var sheetBtn = doc.querySelector( '.hbv-tabbar [aria-controls="hbv-sheet"]' );

	function reduceMotion() {
		return window.matchMedia && window.matchMedia( '(prefers-reduced-motion: reduce)' ).matches;
	}

	if ( sheet && sheetBtn ) {
		var closeSheet = function ( returnFocus ) {
			sheet.hidden = true;
			sheetBtn.setAttribute( 'aria-expanded', 'false' );
			if ( returnFocus ) { sheetBtn.focus(); }
		};

		sheetBtn.addEventListener( 'click', function () {
			var open = sheet.hidden;
			sheet.hidden = ! open;
			sheetBtn.setAttribute( 'aria-expanded', open ? 'true' : 'false' );
		} );

		// Fecha ao tocar fora, ao escolher um link e com Esc.
		doc.addEventListener( 'click', function ( e ) {
			if ( sheet.hidden ) { return; }
			if ( sheet.contains( e.target ) || sheetBtn.contains( e.target ) ) {
				if ( e.target.closest && e.target.closest( 'a' ) && sheet.contains( e.target ) ) { closeSheet( false ); }
				return;
			}
			closeSheet( false );
		} );
		doc.addEventListener( 'keydown', function ( e ) {
			if ( e.key === 'Escape' && ! sheet.hidden ) { closeSheet( true ); }
		} );
	}

	// "Buscar" na barra inferior: leva ao topo e põe o foco no campo de busca (sem script, abre a busca).
	doc.querySelectorAll( '[data-hbv-focus-search]' ).forEach( function ( link ) {
		link.addEventListener( 'click', function ( e ) {
			var field = doc.querySelector( '.hbv-header input[type="search"]' );
			if ( ! field ) { return; }
			e.preventDefault();
			window.scrollTo( { top: 0, behavior: reduceMotion() ? 'auto' : 'smooth' } );
			field.focus( { preventScroll: true } );
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
			window.scrollTo( { top: 0, behavior: reduceMotion() ? 'auto' : 'smooth' } );
		} );
	}
}() );

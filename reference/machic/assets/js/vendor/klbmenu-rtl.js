class Klbmenu {
  constructor( opt ) {
    this.selector = document.querySelectorAll( opt.selector );
    this.speed = opt.speed;

    for ( var i = 0; i < this.selector.length; i++ ) {
      this.menu = this.selector[i];
      this.base = this.menu.firstElementChild;
    }

    this.init( () => {
      this.transition( this.speed );
    });
  }
  init( el ) {
    const promises = [];

    const { menu, base } = this;

    menu.classList.add( 'klb-menu' );
    base.classList.add( 'klb-menu-wrapper' );

    // set default height
    this.resizeMenu( base );

    // add next / prev buttons
    const hasChild = this.menu.querySelectorAll( '.menu-item-has-children' );
    for ( var i = 0; i < hasChild.length; i++ ) {
      const self = hasChild[i];
      const nextButton = document.createElement( 'a' );
      nextButton.classList.add( 'next' );
      nextButton.href = '#';
      self.appendChild( nextButton );

      if ( self.firstElementChild.getAttribute( 'href' ).charAt(0) === "#" ) {
        self.firstElementChild.classList.add( 'next-link' );
      }

      const titleText = self.firstElementChild.innerText;
      const submenuHeader = document.createElement( 'li' );
      submenuHeader.classList.add( 'menu-header' );

      const subMenu = self.querySelector( '.sub-menu' );

      if ( subMenu !== null ) {
        subMenu.prepend( submenuHeader );
        const prevButton = document.createElement( 'a' );
        prevButton.classList.add( 'back' );
        prevButton.innerText = titleText;
        prevButton.href = '#';

        submenuHeader.append( prevButton );
      }
    }

    this.addListeners();

    Promise.all( promises ).then( () => {
      el();
    });
  }
  transition( speed = 300 ) {
    const { menu, base, css } = this;

    menu.style.transitionDuration = `${speed}ms`;
    base.style.transitionDuration = `${speed}ms`;
  }
  resizeMenu( content ) {
    const { menu } = this;

    menu.style.height = `${content.offsetHeight}px`;
  }
  addListeners() {
    const { menu, base, speed } = this;

    menu.addEventListener( 'click', ( e ) => {
      // prevent broken/half transitions
      if (this._clicked + speed > Date.now()) {
        return false
      }

      // cache click time to check on next click
      this._clicked = Date.now()

      const link = e.target;

      if ( link.tagName === 'A' ) {
        if ( link.getAttribute( 'href' ).charAt(0) === "#" || link.classList.contains( 'next' ) || link.classList.contains( 'next-link' ) || link.classList.contains( 'back' ) ) {
          e.preventDefault();
        }
      }

      if ( link.classList.contains( 'next' ) ) {
        const prev = link.previousElementSibling;
        
        if ( prev.tagName === 'UL' ) {
          prev.style.display = 'block';

          this.move( 1 );

          this.resizeMenu( prev );
        }

      } else if ( link.classList.contains( 'next-link' ) ) {
        const next = link.nextElementSibling;
        
        if ( next.tagName === 'UL' ) {
          next.style.display = 'block';

          this.move( 1 );

          this.resizeMenu( next );
        }
      } else if ( link.classList.contains( 'back' ) ) {
        const closest = link.closest( 'ul' );
        this.move( -1, () => {
          closest.style.display = 'none';
        });

        const parent = closest.parentElement.closest( 'ul' );

        if ( parent.classList.contains( 'menu' ) ) {
          this.resizeMenu( base );
        } else {
          this.resizeMenu( parent );
        }

      }

    })
  }
  move( depth = 0, callback = () => {} ) {
    // don't bother packing if we're not going anywhere
    if (depth === 0) {
      return
    }

    const { base, speed, css } = this;

    // get current position from the right
    const right = Math.round( parseInt( base.style.right ) ) || 0;

    // set the new position from the right
    base.style.right = `${right - depth * 100}%`;

    // callback after the animation
    if ( typeof callback === 'function' ) {
      setTimeout( callback, speed );
    }
  }

}
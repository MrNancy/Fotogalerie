import './styles/app.styl'
import './bootstrap'
import 'bootstrap'

import Glightbox from 'glightbox/src/js/glightbox'

const customLightboxHTML =
  `<div id="glightbox-body" class="glightbox-container glightbox-lightbox" tabindex="-1" role="dialog" aria-hidden="false">
    <div class="gloader visible" style="display: none;"></div>
    <div class="goverlay"></div>
    <div class="gcontainer">
        <div id="glightbox-slider" class="gslider">
            <div class="gslide">
                <div class="gslide-inner-content">
                    <div class="ginner-container">
                        <div class="gslide-media">
                        </div>
                        <div class="gslide-description">
                            <div class="gdesc-inner">
                                <h4 class="gslide-title"></h4>
                                <div class="gslide-desc"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <button class="gshare gbtn" data-share="test" aria-label="Teilen" data-taborder="4"><i class="mdi mdi-share-variant-outline"></i></button>
        <button class="gclose gbtn" aria-label="Schließen" data-taborder="3"><i class="mdi mdi-close"></i></button>
        <button class="gprev gbtn" aria-label="Zurück" data-taborder="2"><i class="mdi mdi-chevron-left"></i></button>
        <button class="gnext gbtn" aria-label="Weiter" data-taborder="1"><i class="mdi mdi-chevron-right"></i></button>
    </div>
</div>
`

const glightbox = Glightbox({
  openEffect: 'zoom',
  closeEffect: 'fade',
  hideControls: false,
  loop: false,
  cssEfects: {
    fade: { in: 'fadeIn', out: 'fadeOut' },
    zoom: { in: 'zoomIn', out: 'zoomOut' }
  },
  lightboxHTML: customLightboxHTML,
  skin: 'lightbox'
})

glightbox.on('open', () => {
  const shareButton = document.querySelector('.gshare')
  shareButton.addEventListener('click', evt => {
    evt.preventDefault()
    // todo: open&create content share modal and change {{ content }}
  })
})
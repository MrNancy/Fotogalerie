import { Controller } from '@hotwired/stimulus'

const bootstrap = require('bootstrap')

export default class extends Controller {
  connect () {
    this.addShareButtonEvents()
  }

  addShareButtonEvents () {
    const shareButtons = document.querySelectorAll('[data-share]')

    shareButtons.forEach(button => {
      button.addEventListener('click', () => {
        const value = button.getAttribute('data-share')
        if (window.navigator && window.navigator.canShare) {
          const title = document.getElementsByTagName('title')[0]
          window.navigator.share({
            title: title.innerHTML,
            text: value
          })
        } else {
          const shareModal = new bootstrap.Modal(document.getElementById('shareModal'))
          shareModal.show()
        }
      })
    })
  }
}

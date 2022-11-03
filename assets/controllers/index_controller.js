import { Controller } from '@hotwired/stimulus'

export default class extends Controller {
  connect () {
    document.querySelectorAll('[data-copy-to-clipboard]').forEach(button => {
      button.addEventListener('click', () => {
        const content = button.getAttribute('data-copy-to-clipboard')

        window.navigator.clipboard.writeText(content)
        alert('Erfolgreich in Zwischenablage kopiert!')
      })
    })
  }
}

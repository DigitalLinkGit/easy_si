import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
    connect() {
        const btn = document.createElement('button')
        btn.setAttribute('class','btn btn-outline-primary')
        btn.innerText = 'Ajouter'
        btn.setAttribute('type', 'button')
        btn.addEventListener('click',this.addElement)
        this.element.append(btn)
        console.log('button ok')    
    }

    addElement = (e) => {
        e.preventDefault()    
    }
}

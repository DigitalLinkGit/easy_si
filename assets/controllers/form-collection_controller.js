import { Controller } from "@hotwired/stimulus"

let Sortable = null

export default class extends Controller {
  static values = {
    addLabel: String,
    deleteLabel: String,
    enableDrag: Boolean,
  }

  connect() {
    this.index = this.element.querySelectorAll("[data-collection-item]").length

    this.addAddButton()
    this.element.querySelectorAll("[data-collection-item]").forEach(this.addDeleteButton)

    if (this.hasEnableDragValue && this.enableDragValue) {
      this.initSortable()
    }
  }

  addAddButton() {
    const btn = document.createElement("button")
    btn.type = "button"
    btn.className = "btn btn-outline-primary mt-2"
    btn.innerText = this.addLabelValue || "Ajouter un élément"
    btn.addEventListener("click", this.addElement)
    this.element.append(btn)
  }

  addElement = (e) => {
    e.preventDefault()
    const prototype = this.element.dataset.prototype
    const newItem = document.createRange().createContextualFragment(
      prototype.replaceAll("__name__", this.index)
    ).firstElementChild

    newItem.dataset.collectionItem = "true"
    this.addDeleteButton(newItem)
    this.index++
    this.element.insertBefore(newItem, e.currentTarget)
  }

  addDeleteButton = (item) => {
    const btn = document.createElement("button")
    btn.type = "button"
    btn.className = "btn btn-outline-danger btn-sm mt-2"
    btn.innerText = this.deleteLabelValue || "Supprimer"
    btn.addEventListener("click", (e) => {
      e.preventDefault()
      item.remove()
    })

    const innerDiv = item.querySelector("div")
    ;(innerDiv || item).append(btn)
  }

  injectFromModal(data) {
    const prototype = this.element.dataset.prototype
    const newItem = document.createRange().createContextualFragment(
      prototype.replaceAll("__name__", this.index)
    ).firstElementChild

    newItem.dataset.collectionItem = "true"

    Object.entries(data).forEach(([key, value]) => {
      const input = newItem.querySelector(`[name$="[${key}]"]`)
      if (input) input.value = value
    })

    this.addDeleteButton(newItem)
    this.index++
    const addBtn = this.element.querySelector("button[type='button']")
    this.element.insertBefore(newItem, addBtn)
  }

  async initSortable() {
    try {
      const module = await import("sortablejs")
      Sortable = module.default
      Sortable.create(this.element, {
        handle: ".drag-handle",
        animation: 150,
        filter: "button",
      })
    } catch (e) {
      console.warn("sortablejs non chargé : drag & drop désactivé")
    }
  }
}

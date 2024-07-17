import DOMPurify from "dompurify"
import axios from "axios"

export default class Profile {
  constructor() {
    this.links = document.querySelectorAll(".profile-nav a")
    this.contentArea = document.querySelector(".profile-slot-content")
    this.events()
  }

  // events
  events() {
    addEventListener("popstate", () => {
      this.handleChange()
    })
    this.links.forEach(link => {
      link.addEventListener("click", e => this.handleLinkClick(e))
    })
    this.initPaginationLinks()
  }

  handleChange() {
    this.links.forEach(link => link.classList.remove("active"))
    this.links.forEach(async link => {
      if (link.getAttribute("href") == window.location.pathname) {
        const response = await axios.get(link.href + "/raw")
        this.contentArea.innerHTML = DOMPurify.sanitize(response.data.theHTML)
        document.title = response.data.docTitle + " | OurApp"
        link.classList.add("active")
        this.initPaginationLinks()  // Re-initialize pagination links
      }
    })
  }

  // methods
  async handleLinkClick(e) {
    this.links.forEach(link => link.classList.remove("active"))
    e.target.classList.add("active")
    e.preventDefault()
    const response = await axios.get(e.target.href + "/raw")
    this.contentArea.innerHTML = DOMPurify.sanitize(response.data.theHTML)
    document.title = response.data.docTitle + " | OurApp"

    history.pushState({}, "", e.target.href)
    this.initPaginationLinks()  // Re-initialize pagination links
  }

  initPaginationLinks() {
    const paginationLinks = document.querySelectorAll(".pagination a")
    paginationLinks.forEach(link => {
      link.addEventListener("click", async e => {
        e.preventDefault()
        const response = await axios.get(e.target.href)
        this.contentArea.innerHTML = DOMPurify.sanitize(response.data.theHTML)
        this.initPaginationLinks()  // Re-initialize pagination links
        history.pushState({}, "", e.target.href)  // Update the URL
      })
    })
  }
}

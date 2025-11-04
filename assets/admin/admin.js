import { __, _x, sprintf } from "@wordpress/i18n";

class SDLAdminEditor {
  init(tableEditor) {
    this.editor = tableEditor;
    this.tableBody = tableEditor.querySelector("tbody");

    this.restUrl = sdlRest.rest_url;
    this.nonce = sdlRest.nonce;

    this.registerEvents();

    this.loadTable();
  }

  async loadTable(filter = "", page = 1) {
    try {
      const data = { filter: filter, page: page };
      const route = `${this.restUrl}all`;
      const response = await fetch(route, {
        method: "GET",
        headers: {
          "Content-Type": "application/json",
          "X-WP-Nonce": this.nonce,
        },
      });

      const result = await response.json();
      result.forEach((item) => {
        this.addRow(
          item["id"],
          item["name"],
          item.description,
          item.category,
          item.download
        );
      });
    } catch (error) {
      // String not displayed to the user, typically just for developers
      console.error(__("REST error:", "simple-downloads-list"), error);
    }
  }

  registerEvents() {
    const editor = this.editor;
    const addButton = editor.querySelector(".add-btn");
    const savePopupBtn = editor.querySelector(".popupBox .save-btn");
    const cancelPopupBtn = editor.querySelector(".popupBox .cancel-btn");
    const popupOverlay = editor.querySelector(".popupOverlay");
    const galleryPicker = editor.querySelector(".popupBox .gallery-picker");

    addButton.addEventListener("click", () => this.openPopup());
    savePopupBtn.addEventListener("click", () => this.savePopup());
    cancelPopupBtn.addEventListener("click", () => this.closePopup());
    popupOverlay.addEventListener("click", (e) => {
      if (e.target === popupOverlay) {
        this.closePopup();
      }
    });
    galleryPicker.addEventListener("click", () => this.pickDownloadFile());
  }

  savePopup() {
    if (!this.validatePopupForm()) {
      return;
    }

    const popupBtn = this.editor.querySelector(".popupBox .save-btn");
    if (popupBtn.classList.contains("disabled")) {
      return;
    }
    popupBtn.classList.add("disabled");

    const form = this.editor.querySelector(".popupBox form");
    const id = form.id.value;

    if (id) {
      // Update existing download
      this.updateDownload(id);
    } else {
      // Create new download
      this.createDownload();
    }
  }

  pickDownloadFile() {
    let image_frame;

    if (image_frame) {
      image_frame.open();
      return;
    }

    image_frame = wp.media({
      title: __("Select Media", "simple-downloads-list"),
      multiple: true,
      button: {
        text: __("Select", "simple-downloads-list"),
      },
    });

    image_frame.on("select", () => {
      const attachment = image_frame.state().get("selection").first().toJSON();
      const imageUrl = attachment.url;
      this.editor.querySelector(".popupBox form #download").value = imageUrl;
    });

    image_frame.open();
  }

  validatePopupForm() {
    const form = document.querySelector(".popupBox form");
    let isValid = true;

    // Clear previous error styles
    form.querySelectorAll("input, textarea").forEach((field) => {
      field.classList.remove("invalid");
    });

    // Validate required fields
    form.querySelectorAll("[required]").forEach((field) => {
      if (!field.value.trim()) {
        field.classList.add("invalid");
        isValid = false;
      }
    });

    return isValid;
  }

  async createDownload() {
    const form = this.editor.querySelector(".popupBox form");
    const data = {
      name: form.name.value,
      description: form.description.value,
      category: form.category.value,
      download: form.download.value,
    };

    try {
      const route = `${this.restUrl}add`;
      const response = await fetch(route, {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
          "X-WP-Nonce": this.nonce,
        },
        body: JSON.stringify(data),
      });

      const result = await response.json();

      this.addRow(
        result.data.id,
        data.name,
        data.description,
        data.category,
        data.download
      );
      this.closePopup();
    } catch (error) {
      // String not displayed to the user, typically just for developers
      console.error(__("REST error:", "simple-downloads-list"), error);
    }
  }

  async updateDownload() {
    const form = this.editor.querySelector(".popupBox form");
    const data = {
      id: form.id.value,
      name: form.name.value,
      description: form.description.value,
      category: form.category.value,
      download: form.download.value,
    };

    try {
      const route = `${this.restUrl}edit`;
      const response = await fetch(route, {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
          "X-WP-Nonce": this.nonce,
        },
        body: JSON.stringify(data),
      });

      const result = await response.json();

      this.updateRow(
        data.id,
        data.name,
        data.description,
        data.category,
        data.download
      );
      this.closePopup();
    } catch (error) {
      // String not displayed to the user, typically just for developers
      console.error(__("REST error:", "simple-downloads-list"), error);
    }
  }
  htmlEscape(string) {
    return string
      .replaceAll("&", "&amp;")
      .replaceAll("<", "&lt;")
      .replaceAll(">", "&gt;")
      .replaceAll('"', "&quot;")
      .replaceAll("'", "&#039;");
  }

  updateRow(id, name, description, category, download) {
    const row = this.tableBody.querySelector(`tr[data-id='${id}']`);
    if (row) {
      this.setRowContent(row, name, description, category, download);
    }
  }

  closePopup() {
    const popupOverlay = this.editor.querySelector(".popupOverlay");
    popupOverlay.style.display = "none";
    this.editor.querySelectorAll(".popupBox .invalid").forEach((field) => {
      field.classList.remove("invalid");
    });
  }

  openPopup(id = null) {
    const form = this.editor.querySelector(".popupBox form");
    form.reset();

    const popupOverlay = this.editor.querySelector(".popupOverlay");
    popupOverlay.style.display = "";

    const popupTitle = this.editor.querySelector(".popupBox .popup-title");
    const popupSubtitle = this.editor.querySelector(
      ".popupBox .popup-subtitle"
    );
    const saveBtn = this.editor.querySelector(".popupBox .save-btn");
    saveBtn.classList.remove("disabled");
    form.id.value = id;

    if (id) {
      const cells = this.tableBody.querySelector(`tr[data-id='${id}']`)?.cells;
      form.name.value = cells[0].textContent;
      form.description.value = cells[1].textContent;
      form.category.value = cells[2].textContent;
      form.download.value = cells[3].textContent;

      popupTitle.textContent = __("Edit Download", "simple-downloads-list");
      // Use sprintf for variable string replacement
      popupSubtitle.textContent = sprintf(
        /* translators: %s: Download ID being edited */
        __("Editing download ID: %s", "simple-downloads-list"),
        id
      );
      this.editor.querySelector(".popupBox .save-btn").textContent = __(
        "Update",
        "simple-downloads-list"
      );
    } else {
      popupTitle.textContent = __("Add New Download", "simple-downloads-list");
      popupSubtitle.textContent = __(
        "Create a new download entry",
        "simple-downloads-list"
      );
      this.editor.querySelector(".popupBox .save-btn").textContent = __(
        "Create",
        "simple-downloads-list"
      );
    }
  }

  addRow(id, name, description, category, download) {
    const row = this.insertEmptyRow(id);
    this.setRowContent(row, name, description, category, download);
  }

  insertEmptyRow(id) {
    const row = document.createElement("tr");
    row.setAttribute("data-id", id);

    // Note: The translatable strings for the buttons are inside the
    // row.innerHTML template literal.
    row.innerHTML = `
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td>
        <button class="edit-btn sdl-btn">
          <i class="fa-solid fa-pen"></i>
          <span class="btn-text">${__("Edit", "simple-downloads-list")}</span>
        </button>
        <button class="delete-btn sdl-btn">
          <i class="fa-solid fa-trash"></i>
          <span class="btn-text">${__("Delete", "simple-downloads-list")}</span>
        </button>
        </td>
    `;
    row.querySelector(".edit-btn").addEventListener("click", () => {
      this.openPopup(id);
    });
    row.querySelector(".delete-btn").addEventListener("click", () => {
      this.deleteRow(id);
    });

    this.tableBody.appendChild(row);
    return row;
  }

  setRowContent(row, name, description, category, download) {
    const cells = row.querySelectorAll("td");

    cells[0].textContent = name;
    cells[1].textContent = description;
    cells[2].textContent = category;
    cells[3].textContent = download;
  }

  async deleteRow(id) {
    const data = { id: id };
    try {
      const route = `${this.restUrl}delete`;
      const response = await fetch(route, {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
          "X-WP-Nonce": this.nonce,
        },
        body: JSON.stringify(data),
      });

      const result = await response.json();
      if (result.success) {
        const row = this.tableBody.querySelector(`tr[data-id='${id}']`);
        if (row) {
          this.tableBody.removeChild(row);
        }
      }
    } catch (error) {
      // String not displayed to the user, typically just for developers
      console.error(__("REST error:", "simple-downloads-list"), error);
    }
  }

  async load(filter, page) {
    return fetch(
      `/wp-json/sdl/v1/downloads?filter=${encodeURIComponent(
        filter
      )}&page=${encodeURIComponent(page)}`
    )
      .then((response) => response.json())
      .then((data) => {
        return data;
      });
  }
}

const sdlAdminEditor = new SDLAdminEditor();

document.addEventListener("DOMContentLoaded", function () {
  const editor = document.querySelector(".table-editor");
  if (editor) {
    sdlAdminEditor.init(editor);
  }
});

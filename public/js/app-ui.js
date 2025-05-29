document.addEventListener("DOMContentLoaded", () => {
  /*** Auto-dismiss Alerts ***/
  document.querySelectorAll(".alert[data-autodismiss]").forEach((alert) => {
    const delay = parseInt(alert.dataset.autodismiss, 10) || 3000;
    setTimeout(() => {
      alert.classList.add("fade");
      alert.addEventListener("transitionend", () => alert.remove());
    }, delay);
  });

  /*** Confirmation Modal Logic ***/
  const modal = document.getElementById("confirmationModal");
  const form = modal?.querySelector("form");
  const modalBody = modal?.querySelector(".modal-body");
  const confirmBtn = modal?.querySelector("#confirm-yes");
  const cancelBtn = modal?.querySelector("#confirm-no");
  const tokenInput = modal?.querySelector("#confirmation-token");

  if (modal) {
    document.querySelectorAll("[data-confirm]").forEach((btn) => {
      btn.addEventListener("click", (e) => {
        e.preventDefault();

        const action = btn.dataset.action;
        const token = btn.dataset.token;
        const message =
          btn.dataset.message || "Êtes-vous sûr de vouloir continuer ?";

        if (!form || !tokenInput || !modalBody) return;

        form.setAttribute("action", action);
        tokenInput.value = token;
        modalBody.innerText = message;

        bootstrap.Modal.getOrCreateInstance(modal).show();
      });
    });
  }

  /*** Tutorial Modal Logic ***/
  if (typeof tutorial !== "undefined" && tutorial?.steps?.length > 0) {
    let currentStepIndex = 0;

    const modalEl = document.getElementById("tutorialModal");
    const modalInstance = new bootstrap.Modal(modalEl);
    const stepText = document.getElementById("tutorial-step-text");
    const stepIndicator = document.getElementById("tutorial-step-indicator");
    const nextBtn = document.getElementById("tutorial-next");
    const prevBtn = document.getElementById("tutorial-prev");

    const highlightElement = (selector) => {
      document
        .querySelectorAll(".tutorial-highlight")
        .forEach((el) => el.classList.remove("tutorial-highlight"));
      const target = document.querySelector(selector);
      if (target) target.classList.add("tutorial-highlight");
    };

    const updateTutorialStep = (index) => {
      const step = tutorial.steps[index];
      if (!step || !stepText || !stepIndicator) return;

      stepText.innerText = step.content;
      stepIndicator.innerText = `${index + 1} / ${tutorial.steps.length}`;
      highlightElement(step.domElement);

      prevBtn.disabled = index === 0;
      nextBtn.disabled = index === tutorial.steps.length - 1;
    };

    window.launchTutorial = () => {
      currentStepIndex = 0;
      updateTutorialStep(currentStepIndex);
      modalInstance.show();
    };

    nextBtn?.addEventListener("click", () => {
      if (currentStepIndex < tutorial.steps.length - 1) {
        currentStepIndex++;
        updateTutorialStep(currentStepIndex);
      }
    });

    prevBtn?.addEventListener("click", () => {
      if (currentStepIndex > 0) {
        currentStepIndex--;
        updateTutorialStep(currentStepIndex);
      }
    });

    modalEl?.addEventListener("hidden.bs.modal", () => {
      document
        .querySelectorAll(".tutorial-highlight")
        .forEach((el) => el.classList.remove("tutorial-highlight"));
    });
  } else {
    window.launchTutorial = () => {
      console.warn("Aucun tutoriel chargé.");
    };
  }

  /*** Bouton navbar tutoriel ***/
  document
    .getElementById("btn-launch-tutorial")
    ?.addEventListener("click", () => {
      if (typeof window.launchTutorial === "function") {
        window.launchTutorial();
      }
    });

  /*** Table filtering logic ***/
  window.filterTable = function (input) {
    const tableId = input.dataset.tableId;
    const columnIndex = input.dataset.filterColumn
      ? parseInt(input.dataset.filterColumn)
      : null;
    const table = document.getElementById(tableId);
    const rows = table?.querySelectorAll("tbody tr") || [];
    const value = input.value.toLowerCase();

    rows.forEach((row) => {
      const cells = row.querySelectorAll("td");
      const match =
        columnIndex !== null
          ? cells[columnIndex]?.innerText.toLowerCase().includes(value)
          : Array.from(cells).some((cell) =>
              cell.innerText.toLowerCase().includes(value)
            );

      row.style.display = match ? "" : "none";
    });
  };
});

window.sortTable = function (tableId, columnIndex) {
  const table = document.getElementById(tableId);
  const rows = Array.from(table.querySelectorAll("tbody > tr"));

  const sorted = rows.sort((a, b) => {
    const cellA = a.children[columnIndex].innerText.trim().toLowerCase();
    const cellB = b.children[columnIndex].innerText.trim().toLowerCase();
    return cellA.localeCompare(cellB, undefined, { numeric: true });
  });

  const tbody = table.querySelector("tbody");
  sorted.forEach((row) => tbody.appendChild(row));
};


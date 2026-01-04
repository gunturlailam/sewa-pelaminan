/**
 * Mandah Pelaminan - Custom Application JavaScript
 * Modern UI/UX 2026
 */

(function () {
  "use strict";

  // ============================================
  // THEME TOGGLE
  // ============================================
  const initThemeToggle = () => {
    const themeToggle = document.getElementById("themeToggle");
    const html = document.documentElement;

    // Check saved theme or system preference
    const savedTheme = localStorage.getItem("theme");
    const systemDark = window.matchMedia(
      "(prefers-color-scheme: dark)"
    ).matches;

    if (savedTheme) {
      html.setAttribute("data-theme", savedTheme);
      updateThemeClass(savedTheme);
    } else if (systemDark) {
      html.setAttribute("data-theme", "dark");
      updateThemeClass("dark");
    }

    updateThemeIcon();

    themeToggle?.addEventListener("click", () => {
      const current = html.getAttribute("data-theme");
      const next = current === "dark" ? "light" : "dark";
      html.setAttribute("data-theme", next);
      localStorage.setItem("theme", next);
      updateThemeClass(next);
      updateThemeIcon();
    });

    function updateThemeClass(theme) {
      if (theme === "dark") {
        html.classList.remove("light-style");
        html.classList.add("dark-style");
      } else {
        html.classList.remove("dark-style");
        html.classList.add("light-style");
      }
    }

    function updateThemeIcon() {
      const icon = themeToggle?.querySelector("i");
      if (icon) {
        const isDark = html.getAttribute("data-theme") === "dark";
        icon.className = isDark ? "bx bx-sun" : "bx bx-moon";
      }
    }
  };

  // ============================================
  // CONFIRM DELETE
  // ============================================
  const initConfirmDelete = () => {
    document.querySelectorAll("[data-confirm-delete]").forEach((btn) => {
      btn.addEventListener("click", function (e) {
        e.preventDefault();
        const url = this.getAttribute("href");
        const message =
          this.getAttribute("data-confirm-delete") ||
          "Yakin ingin menghapus data ini?";

        if (typeof Swal !== "undefined") {
          Swal.fire({
            title: "Konfirmasi",
            text: message,
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#696cff",
            cancelButtonColor: "#6c757d",
            confirmButtonText: "Ya, Hapus!",
            cancelButtonText: "Batal",
          }).then((result) => {
            if (result.isConfirmed) {
              window.location.href = url;
            }
          });
        } else {
          if (confirm(message)) {
            window.location.href = url;
          }
        }
      });
    });
  };

  // ============================================
  // FLASH MESSAGES WITH SWEETALERT
  // ============================================
  const initFlashMessages = () => {
    const successMsg = document.querySelector("[data-flash-success]");
    const errorMsg = document.querySelector("[data-flash-error]");

    if (successMsg && typeof Swal !== "undefined") {
      Swal.fire({
        icon: "success",
        title: "Berhasil!",
        text: successMsg.getAttribute("data-flash-success"),
        timer: 3000,
        showConfirmButton: false,
      });
    }

    if (errorMsg && typeof Swal !== "undefined") {
      Swal.fire({
        icon: "error",
        title: "Gagal!",
        text: errorMsg.getAttribute("data-flash-error"),
      });
    }
  };

  // ============================================
  // AUTO DISMISS ALERTS
  // ============================================
  const initAutoDismissAlerts = () => {
    document.querySelectorAll(".alert-dismissible").forEach((alert) => {
      setTimeout(() => {
        const closeBtn = alert.querySelector(".btn-close");
        if (closeBtn) {
          closeBtn.click();
        }
      }, 5000);
    });
  };

  // ============================================
  // FORMAT CURRENCY INPUT
  // ============================================
  const initCurrencyInput = () => {
    document.querySelectorAll("[data-currency]").forEach((input) => {
      input.addEventListener("input", function () {
        let value = this.value.replace(/\D/g, "");
        this.value = new Intl.NumberFormat("id-ID").format(value);
      });

      input.addEventListener("blur", function () {
        let value = this.value.replace(/\D/g, "");
        this.setAttribute("data-value", value);
      });
    });
  };

  // ============================================
  // FORM VALIDATION FEEDBACK
  // ============================================
  const initFormValidation = () => {
    document.querySelectorAll("form[data-validate]").forEach((form) => {
      form.addEventListener("submit", function (e) {
        if (!form.checkValidity()) {
          e.preventDefault();
          e.stopPropagation();
        }
        form.classList.add("was-validated");
      });
    });
  };

  // ============================================
  // LOADING BUTTON
  // ============================================
  const initLoadingButton = () => {
    document.querySelectorAll("[data-loading]").forEach((btn) => {
      btn.addEventListener("click", function () {
        const originalText = this.innerHTML;
        const loadingText = this.getAttribute("data-loading") || "Loading...";

        this.innerHTML = `<span class="spinner-border spinner-border-sm me-2"></span>${loadingText}`;
        this.disabled = true;

        // Re-enable after form submit or timeout
        setTimeout(() => {
          this.innerHTML = originalText;
          this.disabled = false;
        }, 10000);
      });
    });
  };

  // ============================================
  // TOOLTIP INITIALIZATION
  // ============================================
  const initTooltips = () => {
    if (typeof bootstrap !== "undefined") {
      const tooltipTriggerList = document.querySelectorAll(
        '[data-bs-toggle="tooltip"]'
      );
      tooltipTriggerList.forEach((el) => new bootstrap.Tooltip(el));
    }
  };

  // ============================================
  // POPOVER INITIALIZATION
  // ============================================
  const initPopovers = () => {
    if (typeof bootstrap !== "undefined") {
      const popoverTriggerList = document.querySelectorAll(
        '[data-bs-toggle="popover"]'
      );
      popoverTriggerList.forEach((el) => new bootstrap.Popover(el));
    }
  };

  // ============================================
  // PRINT FUNCTION
  // ============================================
  window.printPage = () => {
    window.print();
  };

  // ============================================
  // INITIALIZE ALL
  // ============================================
  document.addEventListener("DOMContentLoaded", () => {
    initThemeToggle();
    initConfirmDelete();
    initFlashMessages();
    initAutoDismissAlerts();
    initCurrencyInput();
    initFormValidation();
    initLoadingButton();
    initTooltips();
    initPopovers();

    console.log("🚀 Mandah Pelaminan App Initialized");
  });
})();

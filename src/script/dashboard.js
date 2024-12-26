// Kodingan ini buat sidebar
document.addEventListener("DOMContentLoaded", function () {
  const mobileMenuButton = document.getElementById("mobile-menu-button");
  const sidebar = document.getElementById("sidebar");
  let isSidebarOpen = false;

  mobileMenuButton.addEventListener("click", () => {
    isSidebarOpen = !isSidebarOpen;
    sidebar.classList.toggle("-translate-x-full");
  });

  document.addEventListener("click", (event) => {
    if (
      isSidebarOpen &&
      !sidebar.contains(event.target) &&
      !mobileMenuButton.contains(event.target)
    ) {
      isSidebarOpen = false;
      sidebar.classList.add("-translate-x-full");
    }
  });

  const navItems = document.querySelectorAll(".nav-item");
  const sections = document.querySelectorAll(".section-content");

  function showSection(sectionId) {
    sections.forEach((section) => {
      section.classList.add("hidden");
    });

    const activeSection = document.getElementById(sectionId);
    if (activeSection) {
      activeSection.classList.remove("hidden");
    }

    navItems.forEach((item) => {
      if (item.dataset.section === sectionId) {
        item.classList.add("bg-blue-100", "text-blue-700");
      } else {
        item.classList.remove("bg-blue-100", "text-blue-700");
      }
    });
  }

  navItems.forEach((item) => {
    item.addEventListener("click", () => {
      const sectionId = item.dataset.section;
      showSection(sectionId);

      if (window.innerWidth < 768) {
        isSidebarOpen = false;
        sidebar.classList.add("-translate-x-full");
      }
    });
  });

  showSection("section-1");
});

